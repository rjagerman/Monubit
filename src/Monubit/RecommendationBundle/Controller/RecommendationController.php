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
    	
    	return array('monument' => $monument);
    	
    }
}
