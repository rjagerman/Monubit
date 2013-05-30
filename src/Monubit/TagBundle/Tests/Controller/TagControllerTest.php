<?php

namespace Monubit\TagBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Monubit\TagBundle\Entity\Tag;

class TagControllerTest extends WebTestCase {

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
								'Monubit\TagBundle\Tests\Fixtures\LoadTagData'));

	}

	/**
	 * Tests whether a tag exists in the repository
	 */
	public function testStatus200() {

		// Perform request
		$crawler = $this->client->request('GET', '/newtag/17/status');

		// Assert 200 status OK
		$this
				->assertEquals(200,
						$this->client->getResponse()->getStatusCode());

	}
	
	/**
	 * Tests whether too long tags are handled
	 */
	public function testAddLongTag() {
	
		// Perform request
		$request = $this->client->request('GET', '/newtag/17/this-tag-is-way-too-long');
		
		// Get the content and convert to array
		$content = $this->client->getResponse()->getContent();
		$array_of_contents = json_decode($content,true);
		
		$this->assertEquals(500, $array_of_contents["error"]["code"]);	
		$this->assertEquals("Tag is te lang", $array_of_contents["error"]["message"]);
	}

	
	/**
	 * Tests what happens when the monument doesn't exist
	 */
	public function testNoMonument() {
	
		// Perform request
		$request = $this->client->request('GET', '/newtag/18/do-something');
	
		// Get the content and convert to array
		$content = $this->client->getResponse()->getContent();
		$array_of_contents = json_decode($content,true);
	
		$this->assertEquals(404, $array_of_contents["error"]["code"]);
		$this->assertEquals("Monument kon niet worden gevonden", $array_of_contents["error"]["message"]);
	}

	/**
	 * Tests whether a tag is added when it already is contained in the monument
	 */
	public function testTagExists() {
	
		// Perform request
		$request = $this->client->request('GET', '/newtag/17/bar');
	
		// Get the content and convert to array
		$content = $this->client->getResponse()->getContent();
		$array_of_contents = json_decode($content,true);
	
		$this->assertEquals(500, $array_of_contents["error"]["code"]);
		$this->assertEquals("Tag bestaat al in dit monument", $array_of_contents["error"]["message"]);
	}
}
