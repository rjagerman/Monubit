<?php

namespace Monubit\TagBundle\Tests\Entity;

use Monubit\MonumentBundle\Entity\Monument;
use Monubit\TagBundle\Entity\Tag;
use Doctrine\Common\Collections\ArrayCollection;

class TagTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var Monubit\TagBundle\Entity\Tag
	 */
	private $tag;

	/**
	 * Sets up the testing environment
	 */
	protected function setUp() {
		parent::setUp();
		$this->tag = new Tag();
	}

	/**
	 * Test the id
	 */
	public function testId() {
		$id = 3;
		$this->tag->setId($id);
		$this->assertEquals($id, $this->tag->getId());
	}

	/**
	 * Test the name methods
	 */
	public function testName() {
		$name = 'Test name';
		$this->tag->setTagname($name);
		$this->assertEquals($name, $this->tag->getTagname());
	}

	/**
	 * Test the number of monuments
	 */
	public function testNumberOfMonuments() {
		$this->assertEquals(0, $this->tag->setNumberOfMonuments(0));
		$this->assertEquals(0, $this->tag->getNumberOfMonuments());
		$this->assertEquals(0, $this->tag->setNumberOfMonuments($this->tag->getNumberOfMonuments()+1));
		$this->assertEquals(1, $this->tag->getNumberOfMonuments());
	}

	/**
	 * Test the adding of monuments
	 */
	public function testMonuments() {
		$monument1 = new Monument();
		$array = new ArrayCollection();
		$array[] = $monument1;
		$this->tag->addMonument($monument1);
		$this->assertEquals($array, $this->tag->getMonuments());
	}

}
