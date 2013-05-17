<?php
namespace Monubit\RatingsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * A Rating
 *
 * @ORM\Entity
 * @ORM\Table(name="rating")
 */
class Rating {
	
	
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 *
	 * @var int
	 */
	private $id;

	/**
	 * The id of the monument this rating is for.
	 * 
	 * @ORM\ManyToOne(targetEntity="Monubit\MonumentBundle\Entity\Monument")
	 */
	private $monument;
	
	/**
	 * @return integer The monument identifier
	 */
	public function getMonument() {
		return $this->monument;
	}
	
	/**
	 * @param integer $mId The monument identifier
	 */
	public function setMonument($mId) {
		$this->Monument = $mId;
	}
	
	/**
	 * The id of the user who made this rating.
	 * 
	 * @ORM\ManyToOne(targetEntity="Monubit\UserBundle\Entity\User")
	 */
	private $user;
	
	/**
	 * @return integer The user identifier
	 */
	public function getUser() {
		return $this->user;
	}
	
	/**
	 * @param integer $uId The user identifier
	 */
	public function setUser($uId) {
		$this->User = $uId;
	}
	
	/**
	 * The rating the user gave to the monument.
	 * 
	 * @ORM\Column(type="float", nullable=false)
	 * @var float
	 * 
	 */
	private $rating;
	
	/**
	 * @return float the rating
	 */
	public function getRating() {
		return $this->rating;
	}
	
	/**
	 * @param float the rating
	 */
	public function setRating($rate) {
		$this->rating = $rate;
	}
}
