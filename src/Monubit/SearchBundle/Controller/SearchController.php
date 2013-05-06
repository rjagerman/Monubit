<?php

namespace Monubit\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SearchController extends Controller {
	/**
	 * @Route("/search/{offset}",
	 *   name="search",
	 *   requirements={"offset" = "\d+"},
	 *   defaults={"offset" = 1}
	 * )
	 * @Template()
	 */
	public function searchAction(Request $request, $offset) {

		// Initialize settings
		$resultsPerPage = 10;
		$repository = $this->getDoctrine()->getManager()
				->getRepository('MonubitMonumentBundle:Monument');
		$query = $request->query->get('search');
		// Create the query for searching
		$dql = $this->getDoctrine()->getManager()->createQueryBuilder()
				->select('m')->from('MonubitMonumentBundle:Monument', 'm')
				->leftJoin('m.location', 'l');
				switch ($request->query->get('type'))
				{
					case "naam":
						$dql = $dql ->where('m.name LIKE :query');
						break;
					case "categorie":
						$dql = $dql ->where('m.mainCategory LIKE :query');
						$dql = $dql ->orWhere('m.subCategory LIKE :query');
						break;
					case "stad":
						$dql = $dql ->where('l.town LIKE :query');
						break;
					case "gemeente":
						$dql = $dql ->where('l.municipality LIKE :query');
						break;
					case "provincie":
						$dql = $dql ->where('l.province LIKE :query');
						break;
					case "straat":
						$dql = $dql ->where('l.street LIKE :query');
						break;
					default:
						$dql = $dql ->where('m.name LIKE :query');
						break;
					/*case "tag":
						$dql ->where(':type LIKE :query')
						break;*/
				}
				
				$dql = $dql ->setParameter('query', '%' . $query . '%')
				->orderBy('m.id', 'ASC')->getQuery();

		// Set the maximum number of results per page and jump to the correct page
		$dql->setMaxResults($resultsPerPage);
		$dql->setFirstResult(($offset - 1) * $resultsPerPage);

		// Get the results
		$results = $dql->getResult();
		
		// Create the query for counting
		$dql = $this->getDoctrine()->getManager()->createQueryBuilder()
				->select('count(m)')
				->from('MonubitMonumentBundle:Monument', 'm')
				->leftJoin('m.location', 'l');
	switch ($request->query->get('type'))
				{
				case "naam":
					$dql = $dql ->where('m.name LIKE :query');
					break;
				case "categorie":
					$dql = $dql ->where('m.mainCategory LIKE :query');
					$dql = $dql ->orWhere('m.subCategory LIKE :query');
					break;
				case "stad":
					$dql = $dql ->where('l.town LIKE :query');
					break;
				case "gemeente":
					$dql = $dql ->where('l.municipality LIKE :query');
					break;
				case "provincie":
					$dql = $dql ->where('l.province LIKE :query');
					break;
				case "straat":
					$dql = $dql ->where('l.street LIKE :query');
					break;
				default:
					$dql = $dql ->where('m.name LIKE :query');
					break;
				/*case "tag":
					$dql ->where(':type LIKE :query')
					break;*/
				}
				$dql = $dql->setParameter('query', '%' . $query . '%')
				->orderBy('m.id', 'ASC')->getQuery();

		// Calculate the total number of pages
		$totalNumberOfResults = $dql->getSingleScalarResult();
		$totalNumberOfPages = ceil($totalNumberOfResults / $resultsPerPage);

		// Create pagination start and end indices
		$adjacentPages = 4;
		$start = max(1,
				min($totalNumberOfPages - $adjacentPages * 2,
						max(1,
								$offset - $adjacentPages
										- max(0,
												min(5,
														$offset
																+ $adjacentPages
																- $totalNumberOfPages)))));
		$end = max(1,
				min($totalNumberOfPages,
						min(
								$offset + $adjacentPages
										+ max(0, min(5, 5 - $offset)),
								$totalNumberOfPages)));

		return array('results' => $results, 'query' => $query,
				'page' => $offset, 'pages' => $totalNumberOfPages,
				'startpage' => $start, 'endpage' => $end);
	}
}
