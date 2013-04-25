<?php

namespace Monubit\MonumentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Monubit\MonumentBundle\Entity\Monument;

class MonumentController extends Controller
{
    /**
     * @Route("/monument/{id}", name="monument")
     * @Template()
     */
    public function monumentAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$monument = $em->getRepository('MonubitMonumentBundle:Monument')->find($id);
    	
    	$monument = new Monument();
    	$monument->setTitle('Title');
    	$monument->setDescription('Some description...');
    	
    	if($monument == null) {
    		throw new NotFoundHttpException();
    	}
    	
        return array('monument' => $monument);
        
    }
}
