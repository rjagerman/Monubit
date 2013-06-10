<?php
namespace Monubit\MonumentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * A monument
 *
 * @ORM\Entity(repositoryClass="Monubit\MonumentBundle\Repository\MonumentRepository")
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
	 * @ORM\Column(type="string", length=255, nullable=true)
	 * @var string
	 */
	private $name;

	/**
	 * @ORM\Column(type="text", nullable=true)
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
	 * @ORM\Column(type="string", length=255, nullable=true)
	 * @var string
	 */
	private $mainCategory;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 * @var string
	 */
	private $subCategory;
	
	/**
	 * @ORM\ManyToMany(targetEntity="\Monubit\TagBundle\Entity\Tag", mappedBy="monuments")
	 * @ORM\OrderBy({"numberOfMonuments" = "DESC"})
	 * @var tag
	 */
	private $tags;

	/**
	 * @ORM\Column(type="string", length=510, nullable=true)
	 * @var string
	 */
	private $image;
	
	/**
	 * @ORM\OneToMany(targetEntity="\Monubit\RatingsBundle\Entity\Rating", mappedBy="monument", fetch="EXTRA_LAZY")
	 * @var Monubit\RatingsBundle\Entity\Rating
	 */
	private $ratings;
	
	public function __construct() {
		$this->tags = new ArrayCollection();
		$this->ratings = new ArrayCollection();
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
	 * @return string The name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param string $name The name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @return string The description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param string $description The description
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * @return \Monubit\MonumentBundle\Entity\Location
	 */
	public function getLocation() {
		return $this->location;
	}

	/**
	 * @param \Monubit\MonumentBundle\Entity\Location $location
	 */
	public function setLocation($location) {
		$this->location = $location;
	}

	/**
	 * @return string The main category
	 */
	public function getMainCategory() {
		return $this->mainCategory;
	}

	/**
	 * @param string $mainCategory The main category
	 */
	public function setMainCategory($mainCategory) {
		$this->mainCategory = $mainCategory;
	}

	/**
	 * @return string The sub category
	 */
	public function getSubCategory() {
		return $this->subCategory;
	}

	/**
	 * @param string $subCategory The sub category
	 */
	public function setSubCategory($subCategory) {
		$this->subCategory = $subCategory;
	}

	/**
	 * @return string The image
	 */
	public function getImage() {
		return $this->image;
	}

	/**
	 * @param string $image The image
	 */
	public function setImage($image) {
		$this->image = $image;
	}
	
	/**
	 * @return string The tags
	 */
	public function getTags() {
		return $this->tags;
	}
	
	/**
	 * @param string $tags The tags
	 */
	public function addTag($tag) {
		$this->tags[] = $tag;
	}
	
	/**
	 * @return the rating of this monument
	 */
	public function getRatings() {
		return $this->ratings;
	}
	
	/**
	 * @param ratings the id used for storing ratings for this monument.
	 */
	public function setRatings($ratings) {
		$this->ratings = $ratings;
	}

}
