<?php

namespace Monubit\RatingsBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Monubit\MonumentBundle\Entity\Monument;

class RatingsControllerTest extends WebTestCase {

	/**
	 * The client
	 * @var Client
	 */
	private $client;

	/**
	 * Sets up the testing environment by mocking the appropriate objects
	 */
	public function setUp() {
		parent::setUp();

		// Create client and load database fixtures
		$this->client = static::createClient();
		$this
				->loadFixtures(
						array(
								'Monubit\RatingsBundle\Tests\Fixtures\LoadMonumentData'));

	}

	/**
	 * Tests a monument that exists in the repository
	 */
	public function testNotLoggedIn() {

		// Perform request
		$crawler = $this->client->request('GET', '/monument/17');

		// Assert 200 status OK
		$this
				->assertEquals(200,
						$this->client->getResponse()->getStatusCode());

	}
}
