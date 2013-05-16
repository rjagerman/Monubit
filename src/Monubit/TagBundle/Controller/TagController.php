<?php

namespace Monubit\TagBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Monubit\TagBundle\Entity\Tag;

class TagController extends Controller
{
    /**
     * @Route("/newtag/{id}/{tagname}")
     */
    public function newTagAction($id, $tagname)
    {
    	// Get the entity manager
    	$em = $this->getDoctrine()->getManager();
    	
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
    		throw new NotFoundException();
    	}
    	
    	// Add the tag to the monument and vice versa
    	$monument->addTag($tag);
    	$tag->addMonument($monument);
    	
    	// Store the monument (and tag)
    	$em->persist($tag);
    	$em->persist($monument);
    	
    	// Flush the changes to the database
    	$em->flush();
    	 
    	
    	// monument.addTag(tag);
    	
    	// entity manager -> persist(monument);
    	
        return '';
    }
}
