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
	 * Tests a monument that doesn't exist in the repository
	 */
	public function testDefaultSearchNoResult() {

		// Perform request
		$crawler = $this->client->request('GET', '/search?query=Bla');

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
	 * Tests a monument that does exist in the repository
	 */
	public function testDefaultSearchWithResult() {

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
	
	/**
	 * Tests a monument that doesn't exist in the repository
	 */
	public function testTownSearchNoResult() {
	
		// Perform request
		$crawler = $this->client->request('GET', '/search?query=bla&type=town');
	
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
	 * Tests a monument that does exist in the repository
	 */
	public function testTownSearchWithResult() {
	
		// Perform request
		$crawler = $this->client->request('GET', '/search?query=Foobar&type=town');
	
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
	/**
	 * Tests a monument that doesn't exist in the repository
	 */
	public function testNameSearchNoResult() {
	
		// Perform request
		$crawler = $this->client->request('GET', '/search?query=booya&type=name');
	
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
	 * Tests a monument that does exist in the repository
	 */
	public function testNameSearchWithResult() {
	
		// Perform request
		$crawler = $this->client->request('GET', '/search?query=Foo&type=name');
	
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
	/**
	 * Tests a monument that doesn't exist in the repository
	 */
	public function testCategorySearchNoResult() {
	
		// Perform request
		$crawler = $this->client->request('GET', '/search?query=booya&type=mainCategory');
	
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
	 * Tests a monument that does exist in the repository
	 */
	public function testCategorySearchWithResult() {
	
		// Perform request
		$crawler = $this->client->request('GET', '/search?query=foo1&type=mainCategory');
	
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
	
	/**
	 * Tests a monument that does exist in the repository
	 */
	public function testCategorySearchWithResult2() {
	
		// Perform request
		$crawler = $this->client->request('GET', '/search?query=bar1&type=subCategory');
	
		// Assert 200 status OK
		$this
		->assertEquals(200,
				$this->client->getResponse()->getStatusCode());
	
		// Assert the result exists in the html
		$this
		->assertGreaterThan(0,
				$crawler
				->filter(
						'html:contains("Foobar")')->count());
	}
	
	/**
	 * Tests a monument that doesn't exist in the repository
	 */
	public function testStreetSearchNoResult() {
	
		// Perform request
		$crawler = $this->client->request('GET', '/search?query=booya&type=street');
	
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
	 * Tests a monument that does exist in the repository
	 */
	public function testStreetSearchWithResult() {
	
		// Perform request
		$crawler = $this->client->request('GET', '/search?query=bar&type=street');
	
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
	
		/**
	 * Tests a monument that doesn't exist in the repository
	 */
	public function testMunicipalitySearchNoResult() {
	
		// Perform request
		$crawler = $this->client->request('GET', '/search?query=booya&type=municipality');
	
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
	 * Tests a monument that does exist in the repository
	 */
	public function testMunicipalitySearchWithResult() {
	
		// Perform request
		$crawler = $this->client->request('GET', '/search?query=bar&type=municipality');
	
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
	
	/**
	 * Tests a monument that doesn't exist in the repository
	 */
	public function testProvinceSearchNoResult() {
	
		// Perform request
		$crawler = $this->client->request('GET', '/search?query=booya&type=province');
	
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
	 * Tests a monument that does exist in the repository
	 */
	public function testProvinceSearchWithResult() {
	
		// Perform request
		$crawler = $this->client->request('GET', '/search?query=bar&type=province');
	
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
