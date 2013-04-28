<?php

namespace Monubit\MonumentBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Monubit\MonumentBundle\Entity\Monument;

class MonumentControllerTest extends WebTestCase {

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
								'Monubit\MonumentBundle\Tests\Fixtures\LoadMonumentData'));

	}

	/**
	 * Tests a monument that exists in the repository
	 */
	public function testMonumentFound() {

		// Perform request
		$crawler = $this->client->request('GET', '/monument/17');

		// Assert 200 status OK
		$this
				->assertEquals(200,
						$this->client->getResponse()->getStatusCode());

	}

	/**
	 * Tests a monument that doesn't exist in the repository
	 */
	public function testMonumentNotFound() {

		// Perform request
		$crawler = $this->client->request('GET', '/monument/29');

		// Assert 404 status not found
		$this
				->assertEquals(404,
						$this->client->getResponse()->getStatusCode());

	}

	/**
	 * Tests that the monument page contains its name
	 */
	public function testMonumentHasName() {

		// Perform request
		$crawler = $this->client->request('GET', '/monument/17');

		// Assert the returned page contains the monument's name
		$this
				->assertGreaterThan(0,
						$crawler->filter('html:contains("Foo")')->count());

	}

	/**
	 * Tests that the monument page contains its description
	 */
	public function testMonumentHasDescription() {

		// Perform request
		$crawler = $this->client->request('GET', '/monument/17');

		// Assert the returned page contains the monument's name
		$this
				->assertGreaterThan(0,
						$crawler
								->filter(
										'html:contains("Description of the foo monument")')
								->count());

	}

}
