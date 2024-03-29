<?php

namespace Monubit\UserBundle\Tests\Controller;

use Monubit\UserBundle\Entity\User;
use Monubit\RatingsBundle\Entity\Rating;

class UserTest extends \PHPUnit_Framework_TestCase {
	
	
	protected function setUp() {
		parent::setUp();
		$this->user = new User();
	}

	/**
	 * Tests the creation of a new user
	 */
	public function testUserCreation() {
		$user = new User();
		$this->assertNotNull($user);
	}
	
	/**
	 * Tests the ratings
	 */
	public function testRating() {
		$rating1 = new Rating();
		$rating2 = new Rating();
		$ratings = [$rating1, $rating2];
		$this->user->setRatings($ratings);
		$this->assertEquals($rating1, $this->user->getRatings()[0]);
		$this->assertEquals($rating2, $this->user->getRatings()[1]);
	}
	
}
