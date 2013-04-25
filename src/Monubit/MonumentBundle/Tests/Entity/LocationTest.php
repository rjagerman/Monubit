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
	
	/**
	 * Tests the id
	 */
    public function testId() {
    	$id = 3;
		$this->location->setId($id);
        $this->assertEquals($id, $this->location->getId());
    }
    
    /**
     * Tests the latitude
     */
    public function testLatitude() {
    	$latitude = 59.24657;
    	$this->location->setLatitude($latitude);
    	$this->assertEquals($latitude, $this->location->getLatitude());
    }
    
    /**
     * Tests the longitude
     */
    public function testLongitude() {
    	$longitude = 14.37911;
    	$this->location->setLongitude($longitude);
    	$this->assertEquals($longitude, $this->location->getLongitude());
    }
    
    /**
     * Tests the province
     */
    public function testProvince() {
    	$province = 'Province';
    	$this->location->setProvince($province);
    	$this->assertEquals($province, $this->location->getProvince());
    }
    
    /**
     * Tests the municipality
     */
    public function testMunicipality() {
    	$municipality = 'Municipality';
    	$this->location->setMunicipality($municipality);
    	$this->assertEquals($municipality, $this->location->getMunicipality());
    }
    
    /**
     * Tests the town
     */
    public function testTown() {
    	$town = 'Town';
    	$this->location->setTown($town);
    	$this->assertEquals($town, $this->location->getTown());
    }
    
    /**
     * Tests the street
     */
    public function testStreet() {
    	$street = 'Street';
    	$this->location->setStreet($street);
    	$this->assertEquals($street, $this->location->getStreet());
    }
    
    /**
     * Tests the street number
     */
    public function testStreetNumber() {
    	$streetNumber = 30;
    	$this->location->setStreetNumber($streetNumber);
    	$this->assertEquals($streetNumber, $this->location->getStreetNumber());
    }
    
    /**
     * Tests the street number appendix
     */
    public function testStreetNumberAppendix() {
    	$streetNumberAppendix = 'A';
    	$this->location->setStreetNumberAppendix($streetNumberAppendix);
    	$this->assertEquals($streetNumberAppendix, $this->location->getStreetNumberAppendix());
    }
    
    /**
     * Tests the zipcode
     */
    public function testZipCode() {
    	$zipCode = '1234AB';
    	$this->location->setZipCode($zipCode);
    	$this->assertEquals($zipCode, $this->location->getZipCode());
    }
    
}
