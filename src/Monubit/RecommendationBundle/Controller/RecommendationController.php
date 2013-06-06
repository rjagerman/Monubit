<?php

namespace Monubit\RecommendationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class RecommendationController extends Controller {
	/**
	 * @Route("/recommendation/{id}", requirements={"id" = "\d+"})
	 * @Template()
	 */
    public function recommendationAction($id) {
    	// Initialize settings
    	$repository = $this->getDoctrine()->getManager()
    		->getRepository('MonubitMonumentBundle:Monument');
		
    	// Get the monument
    	$monument = $repository->find($id);
    	
    	/*$recommended = array();
    	foreach($results->getMonuments() as $monument) {
    		if($monument->getId() != $id) {
    			$recommended[] = $monument;    			
    		}
    	}*/
    	return array('monument' => $monument);
    	
    	/*$tags = $monument->getTags();
    	$recommended = array();
    	
    	for($i = 0; $i < min(4, count($tags));$i++) {
    		$monuments = $tags[$i]->getMonuments();
    		if($monuments[$i]->getId() != $id) {
    			$recommended[$i] = $monuments[$i];
    		}
    	}
    	return array('recommended' => $recommended);*/
    }
}
