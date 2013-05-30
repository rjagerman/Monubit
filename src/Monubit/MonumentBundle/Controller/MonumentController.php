<?php

namespace Monubit\MonumentBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Monubit\MonumentBundle\Entity\Monument;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\Overlays\Marker;
use Ivory\GoogleMap\Controls\ControlPosition;
use Ivory\GoogleMap\Controls\ZoomControl;
use Ivory\GoogleMap\Controls\ZoomControlStyle;

class MonumentController extends Controller {

	/**
	 * @Route("/monument/{id}", requirements={"id": "\d+"}, name="monument")
	 * @Template()
	 */
	public function monumentAction($id) {
		$em = $this->getDoctrine()->getManager();
		$monument = $em->getRepository('MonubitMonumentBundle:Monument')
				->find($id);

		if ($monument == null) {
			throw new NotFoundHttpException();
		}
		$result = array('monument' => $monument);

		$lon = $monument->getLocation()->getLongitude();
		$lat = $monument->getLocation()->getLatitude();

		$securityContext = $this->container->get('security.context');
		$user = $securityContext->getToken()->getUser();
		
		if ($lat != 0 || $lon != 0) {
			/**
			 * Create the map for on the page.
			 * @var Ivory\GoogleMapBundle\Model\Map */
			$map = new Map();
			$map->setCenter($lon, $lat, true);
			$map
					->setZoomControl(ControlPosition::TOP_LEFT,
							ZoomControlStyle::DEFAULT_);
			$map
					->setMapOptions(
							array('disableDefaultUI' => true,
									'disableDoubleClickZoom' => true,
									'zoom' => 16));
			$map
					->setStylesheetOptions(
							array('width' => '225px', 'height' => '225px',));

			/**
			 * Create the marker for the monument on the map.
			 */
			$marker = new Marker();
			$marker->setPosition($lon, $lat, true);
			$marker
					->setOptions(
							array('clickable' => false, 'flat' => true,));
			$map->addMarker($marker);
			$result['map'] = $map;
			
		}
		return $result;
	}
}
