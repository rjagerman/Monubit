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
		
		
		$manager->flush();
		
	}
}
