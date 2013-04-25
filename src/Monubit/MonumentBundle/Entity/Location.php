<?php
namespace Monubit\MonumentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* A location
*
* @ORM\Entity
* @ORM\Table(name="location")
*/
class Location {
	
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 * 
	 * @var int
	 */
	private $id;
	
	/**
	 * @ORM\Column(type="decimal", nullable=true)
	 * @var double
	 */
	private $latitude;
	
	/**
	 * @ORM\Column(type="decimal", nullable=true)
	 * @var double
	 */
	private $longitude;
	
	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 * @var string
	 */
	private $province;
	
	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 * @var string
	 */
	private $municipality;
	
	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 * @var string
	 */
	private $town;
	
	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 * @var string
	 */
	private $street;
	
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 * @var int
	 */
	private $streetNumber;
	
	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 * @var string
	 */
	private $streetNumberAppendix;
	
	/**
	 * @ORM\Column(type="string", length=6, nullable=true)
	 * @var string
	 */
	private $zipCode;
	
	/**
	 * @return integer The identifier
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @param integer $id The identifier
	 */
	public function setId($id) {
		$this->id = $id;
	}
	
	/**
	 * @return number The latitude
	 */
	public function getLatitude() {
		return $this->latitude;
	}
	
	/**
	 * @param number $latitude The latitude
	 */
	public function setLatitude($latitude) {
		$this->latitude = $latitude;
	}
	
	/**
	 * @return number The longitude
	 */
	public function getLongitude() {
		return $this->longitude;
	}
	
	/**
	 * @param number $longitude The longitude
	 */
	public function setLongitude($longitude) {
		$this->longitude = $longitude;
	}
	
	/**
	 * @return string The province
	 */
	public function getProvince() {
		return $this->province;
	}
	
	/**
	 * @param string $province The province
	 */
	public function setProvince($province) {
		$this->province = $province;
	}
	
	/**
	 * @return string The municipality
	 */
	public function getMunicipality() {
		return $this->municipality;
	}
	
	/**
	 * @param string $municipality The municipality
	 */
	public function setMunicipality($municipality) {
		$this->municipality = $municipality;
	}
	
	/**
	 * @return string The town
	 */
	public function getTown() {
		return $this->town;
	}
	
	/**
	 * @param string $town The town
	 */
	public function setTown($town) {
		$this->town = $town;
	}
	
	/**
	 * @return string The street
	 */
	public function getStreet() {
		return $this->street;
	}
	
	/**
	 * @param string $street The street
	 */
	public function setStreet($street) {
		$this->street = $street;
	}
	
	/**
	 * @return integer The street number
	 */
	public function getStreetNumber() {
		return $this->streetNumber;
	}
	
	/**
	 * @param integer $streetNumber The street number
	 */
	public function setStreetNumber($streetNumber) {
		$this->streetNumber = $streetNumber;
	}
	
	/**
	 * @return string The street number appendix
	 */
	public function getStreetNumberAppendix() {
		return $this->streetNumberAppendix;
	}
	
	/**
	 * @param string $streetNumberAppendix The street number appendix
	 */
	public function setStreetNumberAppendix($streetNumberAppendix) {
		$this->streetNumberAppendix = $streetNumberAppendix;
	}
	
	/**
	 * @return string The zip code
	 */
	public function getZipCode() {
		return $this->zipCode;
	}
	
	/**
	 * @param string $zipCode The zip code
	 */
	public function setZipCode($zipCode) {
		$this->zipCode = $zipCode;
	}
	
}