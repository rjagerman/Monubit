<?php

namespace Monubit\MonumentBundle\Tests\Controller;


use Monubit\MonumentBundle\Entity\Monument;
use Monubit\MonumentBundle\Entity\Location;

class MonumentTest extends \PHPUnit_Framework_TestCase {
	
	/**
	 * @var Monubit\MonumentBundle\Entity\Monument
	 */
	private $monument;
	
	/**
	 * Sets up the testing environment
	 */
	protected function setUp() {
		$this->monument = new Monument();
	}
	
    public function testId() {
    	$id = 3;
		$this->monument->setId($id);
        $this->assertEquals($id, $this->monument->getId());
    }
    
    public function testTitle() {
    	$title = 'Test title';
    	$this->monument->setTitle($title);
    	$this->assertEquals($title, $this->monument->getTitle());
    }
    
    public function testDescription() {
    	$description = 'Some text description';
    	$this->monument->setDescription($description);
    	$this->assertEquals($description, $this->monument->getDescription());
    }
    
    public function testLocation() {
    	$location = new Location();
    	$this->monument->setLocation($location);
    	$this->assertEquals($location, $this->monument->getLocation());
    }
    
    public function testMainCategory() {
    	$mainCategory = 'Test Main Category';
    	$this->monument->setMainCategory($mainCategory);
    	$this->assertEquals($mainCategory, $this->monument->getMainCategory());
    }
    
    public function testSubCategory() {
    	$subCategory = 'Test Sub Category';
    	$this->monument->setSubCategory($subCategory);
    	$this->assertEquals($subCategory, $this->monument->getSubCategory());
    }
    
}
