<?php

namespace Monubit\MapBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Monubit\MonumentBundle\Entity\Monument;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\Overlays\Marker;
use Ivory\GoogleMap\Controls\ControlPosition;
use Ivory\GoogleMap\Controls\ZoomControl;
use Ivory\GoogleMap\Controls\ZoomControlStyle;
use Ivory\GoogleMap\Controls\StreetViewControl;


class MapController extends Controller
{
    /**
	 * @Route("/maps", name = "maps")
	 * @Template()
	 */
    public function mapAction()
    {
    	//$geocoder = $this->get('ivory_google_map.geocoder');
    	//$response = $geocoder->geocode($town);
    	
    	$em = $this->getDoctrine();
    	$monuments = $em->getRepository('MonubitMonumentBundle:Monument')->createQueryBuilder('mon')
    	->leftJoin('mon.location', 'loc')
    	->where('mon.description NOT LIKE \'%huis%\'')
    	->andWhere('mon.description NOT LIKE \'%huiz%\'')
    	->andWhere('mon.description NOT LIKE \'%pand%\'')
    	->groupBy('loc.town')
    	->getQuery()
    	->getResult();
    	  	
    	
    	$streetViewControl = new StreetViewControl();
    	
        $map = new Map();
		$map->setCenter(52.0833, 5.1333, true);
		$map->setZoomControl(ControlPosition::TOP_LEFT,	ZoomControlStyle::DEFAULT_);
		$map->setStreetViewControl($streetViewControl);
		$map->setStreetViewControl(ControlPosition::TOP_LEFT);
		$map->setMapOptions(
				array('disableDefaultUI' => true,
					  	'disableDoubleClickZoom' => true,
						'zoom' => 8));
		$map->setStylesheetOptions(array('width' => '950px', 'height' => '625px',));
		$count = 0;
								
			foreach($monuments as $monument){
				$lon = $monument->getLocation()->getLongitude();
				$lat = $monument->getLocation()->getLatitude();
				$count++;
				if ($lat != 0 || $lon != 0) {
					/**
					 * Create the marker for the monument on the map.
					 */

					$marker = new Marker();
					$marker->setPosition($lon, $lat, true);
					/*$marker
					->setOptions(
							array('clickable' => true, 'flat' => true,));*/
					$map->addMarker($marker);
				}
				if($count>500) {
					$result['map'] = $map;
					return $result;
				}
			}		
			$result['map'] = $map;
			return $result;
    }
}
