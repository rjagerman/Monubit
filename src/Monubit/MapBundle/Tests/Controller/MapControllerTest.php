<?php

namespace Monubit\MapBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class MapControllerTest extends WebTestCase {

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
								'Monubit\MapBundle\Tests\Fixtures\LoadMapData'));

	}

/*
	public function testNoMaps() {

		// Perform request
		$crawler = $this->client->request('GET', '/maps');

		// Assert 500 status error
		$this
				->assertEquals(500,
						$this->client->getResponse()->getStatusCode());

	}
	*/
}
