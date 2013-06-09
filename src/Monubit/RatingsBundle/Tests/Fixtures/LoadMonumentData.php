<?php

namespace Monubit\RatingsBundle\Tests\Fixtures;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Monubit\MonumentBundle\Entity\Monument;
use Monubit\MonumentBundle\Entity\Location;
use Monubit\RatingsBundle\Entity\Rating;
use Monubit\UserBundle\Entity\User;

class LoadMonumentData implements FixtureInterface {
	
	public function load(ObjectManager $manager) {
		
		$monument = new Monument();
		$monument->setId(17);
		$monument->setName('Foo');
		$location = new Location();
		$monument->setLocation($location);
		
		$monument2 = new Monument();
		$monument2->setId(19);
		$monument2->setName('Bar');
		$location2 = new Location();
		$monument2->setLocation($location2);
		
		$user = new User();
		$user->setUsername('Tester');
		$user->setEmail('tester@test.com');
		$user->setPlainPassword('something');
		$user->setEnabled(true);
		
		$rating = new Rating();
		$rating->setRating(5);

		$user->setRatings(array($rating));
		$monument->setRatings(array($rating));
		
		$rating->setUser($user);
		$rating->setMonument($monument);
		
		$manager->persist($monument);
		$manager->persist($location);
		$manager->persist($monument2);
		$manager->persist($location2);
		$manager->persist($rating);
		$manager->persist($user);
			
		$manager->flush();
		
	}
}
