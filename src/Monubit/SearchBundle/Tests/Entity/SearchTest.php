<?php

namespace Monubit\SearchBundle\Tests\Entity;

use Monubit\SearchBundle\Entity\Results;
use Monubit\MonumentBundle\Entity\Monument;

class SearchTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Sets up the testing environment
	 */
	protected function setUp() {
		parent::setUp();
		$this->results = new Results("");
	}
	
	/**
	 * Test the monument
	 */
	public function testNumber() {
		$num = 5;
		$this->results->setNumberOfResults($num);
		$this->assertEquals($num, $this->results->getNumberOfResults());
	}
	
	public function testMonuments() {
		$mon1 = new Monument();
		$mon2 = new Monument();
		$this->results->addMonuments($mon1);
		$this->results->addMonuments($mon2);
		$mons = $this->results->getMonuments();
		$this->assertEquals($mon1, $mons[0]);
		$this->assertEquals($mon2, $mons[1]);
	}
	
	public function testFilter(){
		$id1 = 1;
		$id2 = 2;
		$mon1 = new Monument();
		$mon2 = new Monument();
		$mon1->setId($id1);
		$mon2->setId($id2);
		$this->results->addMonuments($mon1);
		$this->results->addMonuments($mon2);
		$this->results->filter($id1);
		$mons = $this->results->getMonuments();
		$this->assertEquals($mon2, $mons[0]);
	}
}
