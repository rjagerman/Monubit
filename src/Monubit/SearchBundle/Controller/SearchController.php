<?php

namespace Monubit\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Process\Process;
use Monubit\SearchBundle\Entity\Pagination;
use Monubit\SearchBundle\Entity\Query;
use Monubit\SearchBundle\Entity\Results;

class SearchController extends Controller {

	/**
	 * @Route("/search",
	 *   name="search"
	 * )
	 * @Template()
	 */
	public function searchAction(Request $request) {
		/*return $this->searchresultsAction($request->query->get('query'),
				$request->query->get('page'), $request->query->get('resultsPerPage'));*/
		
		// Construct query from the request parameters
		$query = new Query($request->query->get('query'),
				$request->query->get('page'), $request->query->get('resultsPerPage'));
		
		// Get the search results
		$results = $this->getSearchResults($query);
		
		// Create pagination for the search results
		$pagination = new Pagination($results);
		
		// Render the template with the results and pagination
		return array('results' => $results, 'pagination' => $pagination);
	}
	
	/**
	 * @Route("/searchresults/{query}/{page}/{resultsPerPage}/{filter}",
	 *   name="searchresults",
	 *   defaults={"filter" = 0}
	 * )
	 * @Template()
	 */
	public function searchresultsAction($query, $page, $resultsPerPage, $filter = 0) {
		
		// Construct query from the request parameters
		$query = new Query($query, $page, $resultsPerPage);
		
		// Get the search results
		$results = $this->getSearchResults($query);
		$results->filter($filter);
		
		// Create pagination for the search results
		$pagination = new Pagination($results);
		
		// Render the template with the results and pagination
		return array('results' => $results, 'pagination' => $pagination);
	}


	/**
	 * Gets the search results for running given query from given offset
	 * 
	 * @param \Monubit\SearchBundle\Entity\Query $query The query
	 * @return \Monubit\SearchBundle\Entity\Results The results
	 */
	public function getSearchResults($query) {

		// Construct and execute python search command
		$command = 'python -m monubit.search.query -q "' . $query->getSafeQuery()
				. '" -o ' . $query->getOffset() . ' --resultsPerPage=' . $query->getResultsPerPage();
		$folder = $this->get('kernel')->getRootDir() . '/../python';
		$process = new Process($command);
		$process->setWorkingDirectory($folder);
		$process->run();

		// Iterate over the results and construct a results object
		$results = new Results($query);
		if ($process->isSuccessful()) {
			$response = json_decode($process->getOutput());
			$results->setNumberOfResults($response->nrOfResults);
			$repository = $this->getDoctrine()->getManager()
					->getRepository('MonubitMonumentBundle:Monument');
			foreach ($response->results as $id) {
				$results->addMonuments($repository->find($id));
			}
		}

		return $results;
	}

}
