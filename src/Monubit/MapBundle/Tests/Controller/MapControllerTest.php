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
	
	public function testMaps() {
		// Perform request
		$crawler = $this->client->request('GET', '/maps/');
		
		// Assert 200 status OK
		$this
		->assertEquals(200,
				$this->client->getResponse()->getStatusCode());
		
	}
	
	public function testMapsMonuments() {
		// Perform request
		$crawler = $this->client->request('GET', '/maps/monument');
		
		// Assert 200 status OK
		$this
		->assertEquals(200,
				$this->client->getResponse()->getStatusCode());
	}
	
}
