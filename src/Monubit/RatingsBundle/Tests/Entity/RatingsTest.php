<?php

namespace Monubit\RatingsBundle\Tests\Entity;

use Monubit\RatingsBundle\Entity\Rating;
use Monubit\UserBundle\Entity\User;
use Monubit\MonumentBundle\Entity\Monument;


class RatingsTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Sets up the testing environment
	 */
	protected function setUp() {
		parent::setUp();
		$this->rating = new Rating();
	}
	
	/**
	 * Test the monument
	 */
	public function testMonument() {
		$monument = new Monument();
		$this->rating->setMonument($monument);
		$this->assertEquals($monument, $this->rating->getMonument());
	}
	
	/**
	 * Test the User
	 */
	public function testUser() {
		$user = new User();
		$this->rating->setUser($user);
		$this->assertEquals($user, $this->rating->getUser());
	}

	/**
	 * Test the Rating
	 */
	public function testRating() {
		$rate = 3;
		$this->rating->setRating($rate);
		$this->assertEquals($rate, $this->rating->getRating());
	}

}
