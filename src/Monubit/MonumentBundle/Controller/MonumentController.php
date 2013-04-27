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
     * @Route("/monument/{id}", requirements={"id": "\d+"}, name="monument")
     * @Template()
     */
    public function monumentAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$monument = $em->getRepository('MonubitMonumentBundle:Monument')->find($id);
    	
    	if($monument == null) {
    		throw new NotFoundHttpException();
    	}
    	
        return array('monument' => $monument);
        
    }
}
