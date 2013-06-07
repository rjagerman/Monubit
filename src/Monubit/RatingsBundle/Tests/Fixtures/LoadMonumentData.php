<?php

namespace Monubit\RatingBundle\Tests\Fixtures;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Monubit\MonumentBundle\Entity\Monument;
use Monubit\MonumentBundle\Entity\Location;
use Monubit\RatingBundle\Entity\Rating;

class LoadMonumentData implements FixtureInterface {
	
	public function load(ObjectManager $manager) {
		
		$monument = new Monument();
		$monument->setId(17);
		$monument->setName('Foo');
		
		$user = new User();
		$user->setRatings($rating);
		
		$rating = new Rating();
		$rating->setRating(5);		
		
		$rating->setUser($user);
		$rating->setMonument($monument);
		
		$manager->persist($monument);
		$manager->persist($rating);
		$manager->persist($user);
			
		$manager->flush();
		
		
		
		
	}
}
