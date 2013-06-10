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
     * Adds a rating (1-5) to a monument for logged in user
     * 
	 * @Route("/rating/rate/{id}/{rating}", name = "ratings_rate",
	 * 	requirements={"id" = "\d+", "rating" = "1|2|3|4|5"}
	 * )
	 */
    public function rateAction($id, $rating)
    {
    	
    	// Get the entity manager
    	$em = $this->getDoctrine()->getManager();
    	
    	try {
    		
    		// Get the user's rating for given monument
    		$monument = $this->findMonument($id);
    		$user = $this->getUser();
    		if($user == null) {
    			throw new \Exception("User is not logged in", 403);
    		}
    		$monumentRating = $em->getRepository('MonubitRatingsBundle:Rating')->findOneBy(array("monument" => $monument, "user" => $user));
    		 
    		// If the rating does not exist yet, create a new
    		if ($monumentRating == null) {
    			$monumentRating = new Rating();
    			$monumentRating->setUser($user);
    			$monumentRating->setMonument($monument);
    		}
    		 
    		// Set the rating and store it in the database
    		$monumentRating->setRating($rating);
    		$em->persist($monumentRating);
    		$em->flush();
    		
    	} catch(\Exception $e) {
    		
    		return new JsonResponse(array("error" => array("code" => $e->getCode(), "message" => $e->getMessage())));
    		
    	}
    	
    	return new JsonResponse("success");
    	
    	
    }
    
    /**
     * Removes a rating from a given monument for the logged in user
     * 
     * @Route("/rating/remove/{id}", name = "ratings_remove",
     * 	requirements={"id" = "\d+"}
     * )
     */
    public function removeAction($id) {
    	
    	// Get the entity manager
    	$em = $this->getDoctrine()->getManager();
    	 
    	try {
    	
    		// Get the user's rating for given monument
    		$monument = $this->findMonument($id);
    		$user = $this->getUser();
    		if($user == null) {
    			throw new \Exception("User is not logged in", 403);
    		}
    		$monumentRating = $em->getRepository('MonubitRatingsBundle:Rating')->findOneBy(array("monument" => $monument, "user" => $user));
    		if ($monumentRating == null) {
    			throw new \Exception("User did not yet rate this monument", 412);
    		}
    		
    		// Remove it from the database
    		$em->remove($monumentRating);
    		$em->flush();
    		
    	} catch(\Exception $e) {
    	
    		return new JsonResponse(array("error" => array("code" => $e->getCode(), "message" => $e->getMessage())));
    	
    	}

    	return new JsonResponse("success");
    	
    }
    
    /**
     * Returns the HTML of the rating field from given monument for the logged in user
     * or without a rating if the user is not logged in
     * 
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
    
    /**
     * Finds the monument with given id
     * 
     * @param int $id The monument id
     * @throws \Exception If the monument does not exist
     * @return \Monubit\Monumentbundle\Entity\Monument The monument
     */
    protected function findMonument($id) {
    	
    	// Get the entity manager
    	$em = $this->getDoctrine()->getManager();
    	
    	// Get the monument
    	$monument = $em->getRepository('MonubitMonumentBundle:Monument')->find($id);
    	
    	// If the monument does not exist, give an error
    	if ($monument == null) {
    		throw new \Exception("Monument not found", 412);
    	}
    	
    	return $monument;
    }
    
}
