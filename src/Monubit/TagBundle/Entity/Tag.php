<?php
namespace Monubit\TagBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * A tag
 *
 * @ORM\Entity
 * @ORM\Table(name="tag")
 */
class Tag {

	/**
	 * The identifier
	 * 
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 * 
	 * @var int
	 */
	private $id;

	/**
	 * @ORM\ManyToMany(targetEntity="\Monubit\MonumentBundle\Entity\Monument", inversedBy="tags")
	 * @ORM\JoinTable(name="monuments_tags",
     *   joinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="monument_id", referencedColumnName="id")}
     * )
	 * @var monuments
	 */
	private $monuments;
	
	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 * @var string
	 */
	private $tagname;
	
	public function __construct() {
		$this->monuments = new ArrayCollection();
	}
	
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
	
	/**
	 * @return string The monuments
	 */
	public function getMonuments() {
		return $this->monuments;
	}
	
	/**
	 * @param string $monuments The monuments
	 */
	public function addMonument($monument) {
		$this->monuments[] = $monument;
	}
	
	/**
	 * @return string The tagname
	 */
	public function getTagname() {
		return $this->tagname;
	}
	
	/**
	 * @param string $tagname The tagname
	 */
	public function setTagname($tagname) {
		$this->tagname = $tagname;
	}
	
}
