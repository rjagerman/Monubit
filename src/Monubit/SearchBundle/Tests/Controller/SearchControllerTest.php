<?php

namespace Monubit\SearchBundle\Tests\SearchController;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Monubit\MonumentBundle\Entity\Monument;

class SearchControllerTest extends WebTestCase {

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
								'Monubit\SearchBundle\Tests\Fixtures\LoadMonumentData'));

	}

	/**
	 * Tests a monument that exists in the repository
	 */
	public function testSearchNoResult() {

		// Perform request
		$crawler = $this->client->request('GET', '/search?query=Bar');

		// Assert 200 status OK
		$this
				->assertEquals(200,
						$this->client->getResponse()->getStatusCode());

		// Assert the result does not exist in the html
		$this
				->assertEquals(0,
						$crawler
								->filter(
										'html:contains("Foo")')->count());

	}

	/**
	 * Tests a monument that doesn't exist in the repository
	 */
	public function testSearchWithResult() {

		// Perform request
		$crawler = $this->client->request('GET', '/search?query=Foo');

		// Assert 200 status OK
		$this
				->assertEquals(200,
						$this->client->getResponse()->getStatusCode());

		// Assert the result exists in the html
		$this
				->assertGreaterThan(0,
						$crawler
								->filter(
										'html:contains("Foo")')->count());

	}

}
