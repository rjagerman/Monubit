<?php

namespace Monubit\TagBundle\Tests\Fixtures;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Monubit\TagBundle\Entity\Tag;
use Monubit\MonumentBundle\Entity\Monument;
use Monubit\MonumentBundle\Entity\Location;

class LoadTagData implements FixtureInterface {
	
	public function load(ObjectManager $manager) {
		
		$monument = new Monument();
		$monument->setId(17);
		$monument->setName('Foo');
		$monument->setDescription('Description of the foo monument');
		
		$tag = new Tag();
		$tag->setTagname("bar");
		$tag->addMonument($monument);
		$tag->setNumberOfMonuments(1);
		
		$monument->addTag($tag);
		
		$location = new Location();
		$monument->setLocation($location);
		$location->setStreet('Foo street');
		
		$location->setLongitude(52.3741666667);
		$location->setLatitude(4.89966666667);
		
		$manager->persist($tag);
		$manager->persist($monument);
		
		/*
		
		$monument2 = new Monument();
		$monument2->setId(6);
		$monument2->setName('Foo');
		$monument2->setDescription('Description of the foo monument');
		
		$location2 = new Location();
		$monument2->setLocation($location2);
		$location2->setStreet('Foo street');
		
		$location2->setLongitude(0);
		$location2->setLatitude(0);
		
		$manager->persist($monument2);
		*/
		$manager->flush();
		
	}
}
