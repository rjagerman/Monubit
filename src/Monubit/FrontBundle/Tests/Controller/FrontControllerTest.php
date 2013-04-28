<?php

namespace Monubit\MonumentBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FrontControllerTest extends WebTestCase {

	/**
	 * The client
	 * @var Client
	 */
	private $client;

	/**
	 * Sets up the testing environment by mocking the appropriate objects
	 */
	public function setUp() {

		// Create the client
		$this->client = static::createClient();

	}

	/**
	 * Tests a monument that exists in the repository
	 */
	public function testFrontFound() {

		// Perform request
		$crawler = $this->client->request('GET', '/');

		// Assert 200 status OK
		$this
				->assertEquals(200,
						$this->client->getResponse()->getStatusCode());

	}

}
