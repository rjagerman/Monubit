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
	 * Tests rating a monument
	 */
	public function testRateMonument() {

		// Log the user in
		$this->login('Tester', 'something');

		// Perform request
		$crawler = $this->client->request('GET', '/rating/rate/19/4');

		// Assert 200 status OK
		$this
				->assertEquals(200,
						$this->client->getResponse()->getStatusCode());

		// Get the monument page
		$crawler = $this->client->request('GET', '/monument/19');

		// Assert the new rating
		// ....
		
	}

	public function testCancelRateMonument() {
		
		// Log the user in
		$this->login('Tester', 'something');
		
		// Remove the rating for monument 17
		
		// Assert ok
		
		// Get the monument page for monument 17
		
		// Assert the new rating
		
	}

	public function login($username, $password) {
		$crawler = $this->client->request('GET', '/login');
		$form = $crawler->selectButton('_submit')
				->form(
						array('_username' => $username,
								'_password' => $password,));
		$this->client->submit($form);
		$this->assertTrue($this->client->getResponse()->isRedirect());
		var_dump($this->client->getResponse());
		$crawler = $this->client->followRedirect();
		var_dump($this->client->getResponse());
	}
}
