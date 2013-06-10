<?php

namespace Monubit\TagBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Monubit\TagBundle\Entity\Tag;

class TagController extends Controller
{
    /**
     * @Route("/newtag/{id}/{tagname}", name="newtag")
     */
    public function newTagAction($id, $tagname)
    { 	
    	// Get the entity manager and create JSON response
    	$em = $this->getDoctrine()->getManager();
    	$response = new JsonResponse();
    	
    	try {
	    	// Find tag or create if non existent and find the monument
			$tag = $this->findOrCreateTag($tagname);
	    	$monument = $this->findMonument($id, $response);
	    	
	    	// Return a JSON error if the tag already exists for the given monument
    		if($monument->getTags()->contains($tag)) {
    			throw new \Exception("Tag bestaat al in dit monument", 412);
    		}
    		
    		// add the tag and update the database
    		$this->update($monument, $tag);
    		
    		// Notify the client and return a succesfull json response
    		$html = $this->renderView('MonubitTagBundle:Tag:tags.html.twig', array('monument' => $monument));
    		$response->setData(array('success', 'html' => $html));
    	}
    	catch(\Exception $e) {
    		$response->setData(array('error' => array('code' => $e->getCode(), 'message' => $e->getMessage())));
    	}
    	return $response;
    }
    
    public function findOrCreateTag($tagname) {
    	// check that the tagname length is not greater than 16
    	if(strlen($tagname) > 16) {
    		throw new \Exception("Tag is te lang", 412);
    	}
    	
    	// find tag
    	$repository = $this->getDoctrine()->getManager()->getRepository('MonubitTagBundle:Tag');
    	$tag = $repository->findOneBy(array('tagname' => $tagname));
    
    	// Create tag if it does not exist
    	if($tag == null) {
    		$tag = new Tag();
    		$tag->setTagname($tagname);
    	}
    	return $tag;
    }
    
    public function findMonument($id, $response) {
    	// Find monument
    	$repository = $this->getDoctrine()->getManager()->getRepository('MonubitMonumentBundle:Monument');
    	$monument = $repository->find($id);
    
    	// Return a JSON error if the monument does not exist
    	if($monument == null) {
    		throw new \Exception("Monument kon niet worden gevonden", 404);
    	}
    	return $monument;
    }
    
    public function update($monument, $tag) {
    	// Add the tag to the monument and vice versa
    	$monument->addTag($tag);
    	$tag->addMonument($monument);
    	 
    	// Update the number of monuments
    	$tag->setNumberOfMonuments(count($tag->getMonuments()));
    	 
    	// Store the monument and tag in the database
    	$this->getDoctrine()->getManager()->persist($tag);
    	$this->getDoctrine()->getManager()->persist($monument);
    	 
    	// Flush the changes to the database
    	$this->getDoctrine()->getManager()->flush();
    }    
    
}
