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
	 * retrieves right monument from the database,
	 * and displays the monument using the monument.html.twig template
	 * 
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
		
		if ($lat != 0 || $lon != 0) {
			$map = $this->createMap($lat, $lon);
			$result['map'] = $map;
		}
		return $result;
	}
	
	/**
	 * creates a map with a marker at the location ($lat, $lon)
	 */
	private function createMap($lat, $lon) {
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
							array('width' => '220px', 'height' => '220px',));

			/**
			 * Create the marker for the monument on the map.
			 */
			$marker = new Marker();
			$marker->setPosition($lon, $lat, true);
			$marker
					->setOptions(
							array('clickable' => false, 'flat' => true,));
			$map->addMarker($marker);
			return $map;
	}
}
