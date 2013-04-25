<?php

namespace Monubit\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SearchController extends Controller
{
    /**
     * @Route("/search/{query}/{offset}",
     *   name="search",
     *   requirements={"offset" = "\d+"},
     *   defaults={"offset" = 1}
     * )
     * @Template()
     */
    public function searchAction($query, $offset)
    {
    	
    	// Initialize settings
    	$resultsPerPage = 15;
    	$repository = $this->getDoctrine()->getManager()->getRepository('MonubitMonumentBundle:Monument');
    	
    	// Create the query for searching
    	$dql = $repository->createQueryBuilder('m')
    		->where('m.title LIKE :query')
    		->setParameter('query', '%' . $query . '%')
    		->orderBy('m.id', 'ASC')
    		->getQuery();
    	
    	// Set the maximum number of results per page and jump to the correct page
    	$dql->setMaxResults($resultsPerPage);
    	$dql->setFirstResult(($offset-1) * $resultsPerPage);
    	
    	// Get the results
    	$results = $dql->getResult();
    	
    	// Create the query for counting
    	$dql = $repository->createQueryBuilder('m')
    		->select('count(m)')
    		->where('m.title LIKE :query')
    		->setParameter('query', '%' . $query . '%')
    		->getQuery();
    	
    	// Calculate the total number of pages
    	$totalNumberOfResults = $dql->getSingleScalarResult();
    	$totalNumberOfPages = ceil($totalNumberOfResults / $resultsPerPage);
    	
    	// Create pagination start and end indices
    	$adjacentPages = 4;
    	$start = max(1, min($totalNumberOfPages - $adjacentPages*2, max(1, $offset - $adjacentPages - max(0, min(5, $offset + $adjacentPages - $totalNumberOfPages)))));
    	$end = max(1, min($totalNumberOfPages, min($offset + $adjacentPages + max(0, min(5, 5-$offset)), $totalNumberOfPages)));
    	
        return array('results' => $results, 'query' => $query, 'page' => $offset, 'pages' => $totalNumberOfPages, 'startpage' => $start, 'endpage' => $end);
    }
}
