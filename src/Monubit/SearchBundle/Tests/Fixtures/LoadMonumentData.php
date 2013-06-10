<?php

namespace Monubit\SearchBundle\Tests\Fixtures;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Monubit\MonumentBundle\Entity\Monument;
use Monubit\MonumentBundle\Entity\Location;

class LoadMonumentData implements FixtureInterface {
	
	public function load(ObjectManager $manager) {
		
		$monument = new Monument();
		$monument->setId(17);
		$monument->setName('Foo');
		$monument->setDescription('Description of the foo monument');
		
		$location = new Location();
		$monument->setLocation($location);
		$location->setStreet('FooStreet');
		$location->setProvince('FooProvince');
		$location->setMunicipality('FooMunicipality');
		$location->setTown('FooTown');
		$monument->setMainCategory('FooCategory');

		
		$monument2 = new Monument();
		$monument2->setId(5);
		$monument2->setName('Bar');
		$location2 = new Location();
		$monument2->setLocation($location2);
		$monument2->SetSubCategory('BarCategory');
				
		$manager->persist($monument);
		$manager->persist($monument2);
		$manager->flush();
		
	}
}
