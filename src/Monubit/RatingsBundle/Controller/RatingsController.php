<?php

namespace Monubit\RatingsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Monubit\MonumentBundle\Entity\Monument;
use Monubit\RatingsBundle\Entity\Rating;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class RatingsController extends Controller
{
    /**
	 * @Route("/rating/rate/{id}/{rating}", name = "ratings_rate",
	 * 	requirements={"id" = "\d+", "rating" = "1|2|3|4|5"}
	 * )
	 */
    public function rateAction($id, $rating)
    {
    	
    	// Get the entity manager
    	$em = $this->getDoctrine()->getManager();
    	
    	// Get the monument
    	$monument = $em->getRepository('MonubitMonumentBundle:Monument')->find($id);
    	
    	// If the monument does not exist, throw an error
    	if ($monument == null) {
    		return new JsonResponse(array("error" => "Monument not found"));
    	}
    	
    	// Get the logged in user
    	$user = $this->getUser();
    	
    	// If the user is not logged in
    	if ($user == null) {
    		return new JsonResponse(array("error" => "User is not logged in"));
    	}
    	
    	// Get the rating if it already exists
    	$monumentRating = $em->getRepository('MonubitRatingsBundle:Rating')->findOneBy(array("monument" => $monument, "user" => $user));
    	
    	// If the rating does not exist yet, create it anew
    	if ($monumentRating == null) {
    		$monumentRating = new Rating();
    		$monumentRating->setUser($user);
    		$monumentRating->setMonument($monument);
    	}
    	
    	// Set the rating
    	$monumentRating->setRating($rating);
    	
    	// Store it in the database
    	$em->persist($monumentRating);
    	$em->flush();
    	
    	// Return correct response
    	return new JsonResponse("success");
    }
    
    /**
     * @Route("/rating/remove/{id}", name = "ratings_remove",
     * 	requirements={"id" = "\d+"}
     * )
     */
    public function removeAction($id) {
    	// Get the entity manager
    	$em = $this->getDoctrine()->getManager();
    	 
    	// Get the monument
    	$monument = $em->getRepository('MonubitMonumentBundle:Monument')->find($id);
    	 
    	// If the monument does not exist, give an error
    	if ($monument == null) {
    		return new JsonResponse(array("error" => "Monument not found"));
    	}
    	 
    	// Get the logged in user
    	$user = $this->getUser();
    	 
    	// If the user is not logged in, give an error
    	if ($user == null) {
    		return new JsonResponse(array("error" => "User is not logged in"));
    	}
    	 
    	// Get the rating
    	$monumentRating = $em->getRepository('MonubitRatingsBundle:Rating')->findOneBy(array("monument" => $monument, "user" => $user));
    	 
    	// If the rating does not exist, give an error
    	if ($monumentRating == null) {
    		return new JsonResponse(array("error" => "User did not yet rate this monument"));
    	}
    	 
    	// Remove it from the database
    	$em->remove($monumentRating);
    	$em->flush();
    	 
    	// Return correct response
    	return new JsonResponse("success");
    }
    
    /**
     * @Route("/rating/{id}", name = "ratings_rating",
     * 	requirements={"id" = "\d+"}
     * )
     * @Template()
     */
    public function ratingAction($id) {
    	
    	// Get the entity manager
    	$em = $this->getDoctrine()->getManager();
    	 
    	// Get the monument
    	$monument = $em->getRepository('MonubitMonumentBundle:Monument')->find($id);
    	
    	// If the monument does not exist, throw an error
    	if ($monument == null) {
    		throw new NotFoundHttpException();
    	}
    	
    	// Get the average rating
    	$averageRating = round($em->getRepository('MonubitMonumentBundle:Monument')->findAverageRating($monument->getId()));
    	
    	// Get the logged in user
    	$user = $this->getUser();
    	
    	// If the user is logged in, get his rating, otherwise it will be 0
    	$rating = 0;
    	if ($user != null) {
    		
    		// Get the rating if it already exists
    		$monumentRating = $em->getRepository('MonubitRatingsBundle:Rating')->findOneBy(array("monument" => $monument, "user" => $user));
    		 
    		// Set the rating
    		if($monumentRating != null) {
    			$rating = $monumentRating->getRating();
    		}
    		
    	}
    	
    	// Return the values to the template
    	return array("monument" => $monument, "rating" => $rating, "average" => $averageRating);
    	
    }
    
}
