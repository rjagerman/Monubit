<?php
namespace Monubit\MonumentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* A monument
*
* @ORM\Entity
* @ORM\Table(name="monument")
*/
class Monument {
	
	/**
	 * The identifier
	 * 
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * 
	 * @var int
	 */
	private $id;
	
	/**
	 * @ORM\Column(type="string", length=255)
	 * @var string
	 */
	private $title;
	
	/**
	 * @ORM\Column(type="text")
	 * @var string
	 */
	private $description;
	
	/**
	 * @ORM\OneToOne(targetEntity="Location", cascade={"all"})
	 * 
	 * @var Location
	 */
	private $location;
	
	/**
	 * @ORM\Column(type="string", length=255)
	 * @var string
	 */
	private $mainCategory;
	
	/**
	 * @ORM\Column(type="string", length=255)
	 * @var string
	 */
	private $subCategory;
	
	// usageOnOtherWikis
	
	// usageOnWikiMediaCommons
	
	/**
	 * @return int The identifier
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @param int $id The identifier
	 */
	public function setId($id) {
		$this->id = $id;
	}
	
}