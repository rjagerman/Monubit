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
	 * @ORM\Column(type="decimal")
	 * @var double
	 */
	private $lattitude;
	
	/**
	 * @ORM\Column(type="decimal")
	 * @var double
	 */
	private $longitude;
	
	/**
	 * @ORM\Column(type="string", length=255)
	 * @var string
	 */
	private $province;
	
	/**
	 * @ORM\Column(type="string", length=255)
	 * @var string
	 */
	private $municipality;
	
	/**
	 * @ORM\Column(type="string", length=255)
	 * @var string
	 */
	private $town;
	
	/**
	 * @ORM\Column(type="string", length=255)
	 * @var string
	 */
	private $street;
	
	/**
	 * @ORM\Column(type="string", length=255)
	 * @var string
	 */
	private $streetNumber;
	
	/**
	 * @ORM\Column(type="string", length=6)
	 * @var string
	 */
	private $zipCode;
	
}