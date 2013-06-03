<?php

namespace Monubit\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Process\Process;

class SearchController extends Controller {
	
	/**
	 * @Route("/search",
	 *   name="search"
	 * )
	 * @Template()
	 */
	public function searchAction(Request $request) {
		
		// Initialize settings
		$repository = $this->getDoctrine()->getManager()
				->getRepository('MonubitMonumentBundle:Monument');
		
		// Get parameters from request
		$query = $request->query->get('query');
		$offset = $request->query->get('offset');
		if($offset < 1) {
			$offset = 1;
		}
		$type = $request->query->get('type');
		if($type == null) {
			$type = 'name';
		}
		
		// Create the necessary criteria
		//$criteria = array($type => $query);
		
		// Get the results
		//$results = $repository->findLike($criteria, $resultsPerPage, ($offset-1) * $resultsPerPage);
		
		// Get the total number of results
		//$totalNumberOfResults = $repository->findCountLike($criteria);
		
		// Get the search results
		$resultsPerPage = 10;
		$results = $this->getSearchResults($query, $offset, $resultsPerPage);
		
		// Create pagination start and end indices
		$totalNumberOfResults = $results['totalNumberOfResults'];
		$totalNumberOfPages = ceil($totalNumberOfResults / $resultsPerPage);
		$adjacentPages = 4;
		$start = max(1, min($offset - $adjacentPages, $totalNumberOfPages));
		$end = max(1, min($offset + $adjacentPages, $totalNumberOfPages));

		// Return the found results to the template
		return array('results' => $results['monuments'], 'query' => $query, 'type' => $type,
				'page' => $offset, 'pages' => $totalNumberOfPages,
				'startpage' => $start, 'endpage' => $end);
	}
	
	/**
	 * Gets the search results for running given query from given offset
	 * 
	 * @param string $query The query
	 * @param int $offset The offset
	 * @return array The array of results
	 */
	protected function getSearchResults($query, $offset, $resultsPerPage) {
		$cleanoffset = ($offset-1) * $resultsPerPage;
		$cleanquery = preg_replace('/[^a-zA-Z0-9]+/', ' ', $query);
		
		$command = 'python -m monubit.search.query -q "' . $cleanquery . '" -o ' . $cleanoffset;
		$folder = $this->get('kernel')->getRootDir() . '/../python';
		$process = new Process($command);
		$process->setWorkingDirectory($folder);
		$process->run();
		
		$monuments = array();
		$totalNumberOfResults = 0;
		if ($process->isSuccessful()) {
			$results = json_decode($process->getOutput());
			$totalNumberOfResults = $results->nrOfResults;
			$repository = $this->getDoctrine()->getManager()->getRepository('MonubitMonumentBundle:Monument');
			foreach($results->results as $id) {
				$monuments[] = $repository->find($id);
			}
		}
		
		return array('monuments' => $monuments, 'totalNumberOfResults' => $totalNumberOfResults);
	}
	
}
