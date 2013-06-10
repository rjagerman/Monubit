<?php

namespace Monubit\RecommendationBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Monubit\TagBundle\Entity\Tag;

class RecommendationControllerTest extends WebTestCase {

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
								'Monubit\RecommendationBundle\Tests\Fixtures\LoadMonumentData'));

	}

	/**
	 * Tests whether a tag exists in the repository
	 */
	public function testStatus200() {

		// Perform request
		$crawler = $this->client->request('GET', '/recommendation/17');

		// Assert 200 status OK
		$this
				->assertEquals(200,
						$this->client->getResponse()->getStatusCode());

	}
	
	/**
	 * Tests whether a tag exists in the repository
	 */
	public function testRecommendedMonument() {
	
		// Perform request
		$crawler = $this->client->request('GET', '/recommendation/17');
	
		// Assert containing monument
		$this
				->assertEquals(0,
						$crawler->filter('html:contains("Foo")')->count());
	
	}
	
}
