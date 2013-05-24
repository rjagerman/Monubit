<?php

namespace Monubit\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SearchController extends Controller {
	/**
	 * @Route("/search",
	 *   name="search"
	 * )
	 * @Template()
	 */
	public function searchAction(Request $request) {

		// Initialize settings
		$resultsPerPage = 10;
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
		$criteria = array($type => $query);
		
		// Get the results
		$results = $repository->findLike($criteria, $resultsPerPage, ($offset-1) * $resultsPerPage);
		
		// Get the total number of results
		$totalNumberOfResults = $repository->findCountLike($criteria);
		$totalNumberOfPages = $totalNumberOfResults / $resultsPerPage;

		// Create pagination start and end indices
		$adjacentPages = 4;
		$start = max(1, min($offset - $adjacentPages, $totalNumberOfPages));
		$end = max(1, min($offset + $adjacentPages, $totalNumberOfPages));

		// Return the found results to the template
		return array('results' => $results, 'query' => $query, 'type' => $type,
				'page' => $offset, 'pages' => $totalNumberOfPages,
				'startpage' => $start, 'endpage' => $end);
	}
}
