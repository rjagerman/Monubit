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
	public function testRateMonumentLoggedIn() {

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

		// Assert that the new rating (4 stars) correctly exists
		$this
				->assertEquals('checked',
						$crawler->filter('input#rating4')->first()
								->attr('checked'));

	}

	/**
	 * Tests canceling a rating of a monument
	 */
	public function testCancelRateMonumentLoggedIn() {

		// Log the user in
		$this->login('Tester', 'something');

		// Remove the rating for monument 17
		$crawler = $this->client->request('GET', '/rating/remove/17');

		// Assert ok
		$this
				->assertEquals(200,
						$this->client->getResponse()->getStatusCode());

		// Get the monument page for monument 17
		$crawler = $this->client->request('GET', '/monument/17');

		// Assert that the rating (4 stars) does not exist
		$this
				->assertEquals('',
						$crawler->filter('input#rating4')->first()
								->attr('checked'));

	}

	/**
	 * Tests rating a monument when not logged in
	 */
	public function testRateMonumentNotLoggedIn() {

		// Ensure the user is not logged in
		$this->logout();

		// Perform request
		$crawler = $this->client->request('GET', '/rating/rate/19/4');

		// Assert 200 status OK
		$this
				->assertEquals(200,
						$this->client->getResponse()->getStatusCode());
		
		// Assert that an error has occurred
		$json = json_decode($this->client->getResponse()->getContent());
		$this->assertEquals("User is not logged in", $json->error->message);
	}

	/**
	 * Tests canceling a rating of a monument when not logged in
	 */
	public function testCancelRateMonumentNotLoggedIn() {

		// Ensure the user is not logged in
		$this->logout();

		// Perform request
		$crawler = $this->client->request('GET', '/rating/remove/19');

		// Assert 200 status OK
		$this
				->assertEquals(200,
						$this->client->getResponse()->getStatusCode());
		
		// Assert that an error has occurred
		$json = json_decode($this->client->getResponse()->getContent());
		$this->assertEquals("User is not logged in", $json->error->message);

	}

	/**
	 * Tests rating a non existing monument
	 */
	public function testRateNoMonument() {

		// Log the user in
		$this->login('Tester', 'something');

		// Perform request
		$crawler = $this->client->request('GET', '/rating/rate/230/4');

		// Assert 200 status OK
		$this
				->assertEquals(200,
						$this->client->getResponse()->getStatusCode());
		
		// Assert that an error has occurred
		$json = json_decode($this->client->getResponse()->getContent());
		$this->assertEquals("Monument not found", $json->error->message);

	}

	/**
	 * Tests canceling a rating of a non existing monument
	 */
	public function testCancelRateNoMonument() {

		// Log the user in
		$this->login('Tester', 'something');

		// Perform request
		$crawler = $this->client->request('GET', '/rating/remove/230');

		// Assert 200 status OK
		$this
				->assertEquals(200,
						$this->client->getResponse()->getStatusCode());
		
		// Assert that an error has occurred
		$json = json_decode($this->client->getResponse()->getContent());
		$this->assertEquals("Monument not found", $json->error->message);

	}
	
	public function testCancelMonumentNotYetRated() {
		
		// Log the user in
		$this->login('Tester', 'something');
		
		// Perform request
		$crawler = $this->client->request('GET', '/rating/remove/19');
		
		// Assert 200 status OK
		$this
		->assertEquals(200,
				$this->client->getResponse()->getStatusCode());
		
		// Assert that an error has occurred
		$json = json_decode($this->client->getResponse()->getContent());
		$this->assertEquals("User did not yet rate this monument", $json->error->message);
		
	}
	
	public function testRatingMonumentNotFound() {
	
		// Log the user in
		$this->login('Tester', 'something');
	
		// Perform request
		$crawler = $this->client->request('GET', '/rating/230');
	
		// Assert 200 status OK
		$this
		->assertEquals(404,
				$this->client->getResponse()->getStatusCode());
	
	}

	/**
	 * Logs the user in during the test session
	 * 
	 * @param string $username The username
	 * @param string $password The password
	 */
	public function login($username, $password) {
		$crawler = $this->client->request('GET', '/login');
		$form = $crawler->selectButton('_submit')
				->form(
						array('_username' => $username,
								'_password' => $password,));
		$this->client->submit($form);
		$this->assertTrue($this->client->getResponse()->isRedirect());
		$crawler = $this->client->followRedirect();
	}

	/**
	 * Logs the user out during the test session
	 */
	public function logout() {
		$crawler = $this->client->request('GET', '/logout');
		$crawler = $this->client->followRedirect();
	}
}
