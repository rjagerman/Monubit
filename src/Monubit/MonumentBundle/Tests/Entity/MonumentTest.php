<?php

namespace Monubit\MonumentBundle\Tests\Entity;

use Monubit\MonumentBundle\Entity\Monument;
use Monubit\MonumentBundle\Entity\Location;
use Monubit\TagBundle\Entity\Tag;

class MonumentTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var Monubit\MonumentBundle\Entity\Monument
	 */
	private $monument;

	/**
	 * Sets up the testing environment
	 */
	protected function setUp() {
		parent::setUp();
		$this->monument = new Monument();
	}

	/**
	 * Test the id
	 */
	public function testId() {
		$id = 3;
		$this->monument->setId($id);
		$this->assertEquals($id, $this->monument->getId());
	}

	/**
	 * Test the title
	 */
	public function testName() {
		$name = 'Test name';
		$this->monument->setName($name);
		$this->assertEquals($name, $this->monument->getName());
	}

	/**
	 * Test the description
	 */
	public function testDescription() {
		$description = 'Some text description';
		$this->monument->setDescription($description);
		$this->assertEquals($description, $this->monument->getDescription());
	}

	/**
	 * Test the location
	 */
	public function testLocation() {
		$location = new Location();
		$this->monument->setLocation($location);
		$this->assertEquals($location, $this->monument->getLocation());
	}

	/**
	 * Test the main category
	 */
	public function testMainCategory() {
		$mainCategory = 'Test Main Category';
		$this->monument->setMainCategory($mainCategory);
		$this->assertEquals($mainCategory, $this->monument->getMainCategory());
	}

	/**
	 * Test the sub category
	 */
	public function testSubCategory() {
		$subCategory = 'Test Sub Category';
		$this->monument->setSubCategory($subCategory);
		$this->assertEquals($subCategory, $this->monument->getSubCategory());
	}
	
	public function testTag() {
		$tag1 = new Tag();
		$tag2 = new Tag();
		$this->monument->addTag($tag1);
		$this->monument->addTag($tag2);
		$tags = $this->monument->getTags();
		$this->assertEquals($tag1, $tags[0]);
		$this->assertEquals($tag2, $tags[1]);
	}

	/**
	 * Tests the image
	 */
	public function testImage() {
		$image = 'http://www.someurl.com/image.png';
		$this->monument->setImage($image);
		$this->assertEquals($image, $this->monument->getImage());
	}

}
