<?php

namespace Monubit\MapBundle\Tests\Fixtures;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Monubit\TagBundle\Entity\Tag;
use Monubit\MonumentBundle\Entity\Monument;
use Monubit\MonumentBundle\Entity\Location;

class LoadMapData implements FixtureInterface {
	
	public function load(ObjectManager $manager) {
		
		$location = new Location();
		$location->setLatitude(4);
		$location->setLongitude(51);
		
		$monument = new Monument();
		$monument->setId(17);
		$monument->setLocation($location);
		
		$manager->flush();
		
	}
}
