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
     *   defaults={"offset" = 0}
     * )
     * @Template()
     */
    public function searchAction($query, $offset)
    {
    	
    	// Initialize settings
    	$resultsPerPage = 10;
    	$em = $this->getDoctrine()->getManager();
    	
    	// Create the query for searching
    	$query = $em->createQuery(
    			'SELECT m FROM MonubitMonumentBundle:Monument m WHERE m.title LIKE :query ORDER BY m.id ASC'
    	)->setParameter('query', '%' . $query . '%');
    	
    	// Set the maximum number of results per page
    	$query->setMaxResults($resultsPerPage);
    	
    	// Get the results
    	$results = $query->getResult();
    	
        return array('results' => $results);
    }
}
