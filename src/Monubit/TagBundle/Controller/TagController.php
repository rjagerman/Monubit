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
    	
    	// Find tag
    	$repository = $em->getRepository('MonubitTagBundle:Tag');
    	$tag = $repository->findOneBy(array('tagname' => $tagname));
    	
    	// Create tag if it does not exist
    	if($tag == null) {
    		$tag = new Tag();
    		$tag->setTagname($tagname);
    	}
    	
    	// Find monument
    	$repository = $this->getDoctrine()->getManager()->getRepository('MonubitMonumentBundle:Monument');
    	$monument = $repository->find($id);
    	
    	// Return a JSON error if the monument does not exist
    	if($monument == null) {
    		$response->setData(array('error' => array('code' => 404, 'message' => 'Monument kon niet worden gevonden')));
    		return $response;
    	}
    	
    	// Return a JSON error if the tag already exists for given monument
    	if($monument->getTags()->contains($tag)) {
    		$response->setData(array('error' => array('code' => 500, 'message' => 'Tag bestaat al in dit monument')));
    		return $response;
    	}
    	
    	// Add the tag to the monument and vice versa
    	$monument->addTag($tag);
    	$tag->addMonument($monument);
    	
    	// Store the monument and tag in the database
    	$em->persist($tag);
    	$em->persist($monument);
    	
    	// Flush the changes to the database
    	$em->flush();
    	
    	// Notify the client and return a succesfull json response
    	$html = $this->renderView('MonubitTagBundle:Tag:tags.html.twig', array('monument' => $monument));
    	$response->setData(array('success', 'html' => $html));
        return $response;
    }
}
