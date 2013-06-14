<?php

namespace Monubit\MapBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Monubit\MonumentBundle\Entity\Monument;
use Symfony\Component\HttpFoundation\JsonResponse;

class MapController extends Controller {
	/**
	 * @Route("/", name = "maps")
	 * @Template()
	 */
	public function mapAction() {
		return array();
	}

	/**
	 * @Route("/monument", name = "maps_monuments")
	 */
	public function mapsMonumentsAction() {
		$response = new JsonResponse();
		$em = $this->getDoctrine();
		
		$monuments = $em->getRepository('MonubitMonumentBundle:monument')
				->createQueryBuilder('m')
				->leftJoin('m.location', 'l')
				->select("m.id, m.name, l.latitude, l.longitude, l.street, l.streetNumber")
				->getQuery()
				->getResult();

		$response->setData(array('success', 'data' => $monuments));
		
		return $response;
	}
}
