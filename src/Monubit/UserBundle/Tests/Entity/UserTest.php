<?php

namespace Monubit\UserBundle\Tests\Controller;

use Monubit\UserBundle\Entity\User;

class UserTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Tests the creation of a new user
	 */
	public function testUserCreation() {
		$user = new User();
		$this->assertNotNull($user);
	}

}
