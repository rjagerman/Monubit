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
    	// Get the entity manager
    	$em = $this->getDoctrine()->getManager();
    	
    	// Create JSON response
    	$response = new JsonResponse();
    	
    	// Find tag, or create it if it does not exist
    	$repository = $em->getRepository('MonubitTagBundle:Tag');
    	$tag = $repository->findOneBy(array('tagname' => $tagname));
    	
    	if($tag == null) {
    		$tag = new Tag();
    		$tag->setTagname($tagname);
    	}
    	
    	// Find monument
    	$repository = $this->getDoctrine()->getManager()->getRepository('MonubitMonumentBundle:Monument');
    	$monument = $repository->find($id);
    	
    	// Check if monument exists
    	if($monument == null) {
    		$response->setData(array('error' => array('code' => 404, 'message' => 'Monument could not be found')));
    		return $response;
    	}
    	
    	// Add the tag to the monument and vice versa
    	$monument->addTag($tag);
    	$tag->addMonument($monument);
    	
    	// Store the monument (and tag)
    	$em->persist($tag);
    	$em->persist($monument);
    	
    	// Flush the changes to the database
    	$em->flush();
    	
    	// Notify succesfull response
    	$response->setData('success');
    	 
    	
    	// monument.addTag(tag);
    	
    	// entity manager -> persist(monument);
    	
    	// Return the json response
        return $response;
    }
}
