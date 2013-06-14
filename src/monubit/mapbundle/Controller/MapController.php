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

		try {

			$em = $this->getDoctrine();
			$monuments = $em->getRepository('MonubitMonumentBundle:monument')
					->createQueryBuilder('m')
					->leftJoin('m.location', 'l')
					->select("m.id, m.name, l.latitude, l.longitude, l.street, l.streetNumber")
					->getQuery()
					->getResult();

			if (null == $monuments) {
				throw new \Exception("De database gaf geen resultaten", 500);
			}

			$response->setData(array('success', 'data' => $monuments));
		} catch (\Exception $e) {
			$response
					->setData(
							array(
									'error' => array('code' => $e->getCode(),
											'message' => $e->getMessage())));
		}
		return $response;
	}
}
