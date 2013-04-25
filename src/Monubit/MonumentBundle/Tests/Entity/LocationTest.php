<?php

namespace Monubit\MonumentBundle\Tests\Controller;


use Monubit\MonumentBundle\Entity\Location;

class LocationTest extends \PHPUnit_Framework_TestCase {
	
	/**
	 * @var Monubit\MonumentBundle\Entity\Location
	 */
	private $location;
	
	/**
	 * Sets up the testing environment
	 */
	protected function setUp() {
		$this->location = new Location();
	}
	
    public function testId() {
    	$id = 3;
		$this->location->setId($id);
        $this->assertEquals($id, $this->location->getId());
    }
    
    public function testLatitude() {
    	$latitude = 59.24657;
    	$this->location->setLatitude($latitude);
    	$this->assertEquals($latitude, $this->location->getLatitude());
    }
    
    public function testLongitude() {
    	$longitude = 14.37911;
    	$this->location->setLongitude($longitude);
    	$this->assertEquals($longitude, $this->location->getLongitude());
    }
    
    public function testProvince() {
    	$province = 'Province';
    	$this->location->setProvince($province);
    	$this->assertEquals($province, $this->location->getProvince());
    }
    
    public function testMunicipality() {
    	$municipality = 'Municipality';
    	$this->location->setMunicipality($municipality);
    	$this->assertEquals($municipality, $this->location->getMunicipality());
    }
    
    public function testTown() {
    	$town = 'Town';
    	$this->location->setTown($town);
    	$this->assertEquals($town, $this->location->getTown());
    }
    
    public function testStreet() {
    	$street = 'Street';
    	$this->location->setStreet($street);
    	$this->assertEquals($street, $this->location->getStreet());
    }
    
    public function testStreetNumber() {
    	$streetNumber = 30;
    	$this->location->setStreetNumber($streetNumber);
    	$this->assertEquals($streetNumber, $this->location->getStreetNumber());
    }
    
    public function testStreetNumberAppendix() {
    	$streetNumberAppendix = 'A';
    	$this->location->setStreetNumberAppendix($streetNumberAppendix);
    	$this->assertEquals($streetNumberAppendix, $this->location->getStreetNumberAppendix());
    }
    
    public function testZipCode() {
    	$zipCode = '1234AB';
    	$this->location->setZipCode($zipCode);
    	$this->assertEquals($zipCode, $this->location->getZipCode());
    }
    
}
