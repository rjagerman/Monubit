<?php
namespace Monubit\RatingsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * A Rating
 * 
 *
 * @ORM\Entity
 * @ORM\Table(name="rating",
 * 	uniqueConstraints={
 * 		@ORM\UniqueConstraint(name="monumentuser_unique", columns={"monument_id", "user_id"})
 * 	},
 * 	indexes={
 * 		@ORM\index(name="monumentrating_idx", columns={"monument_id", "rating"})
 * 	}
 * )
 * @UniqueEntity({"monument", "user"})
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
	 * The monument this rating is for.
	 * 
	 * @ORM\ManyToOne(targetEntity="\Monubit\MonumentBundle\Entity\Monument", inversedBy="rating")
	 */
	private $monument;
	
	/**
	 * The user who made this rating.
	 *
	 * @ORM\ManyToOne(targetEntity="\Monubit\UserBundle\Entity\User", inversedBy="rating")
	 */
	private $user;
	
	/**
	 * The rating the user gave to the monument.
	 *
	 * @ORM\Column(type="smallint", nullable=false)
	 * @var integer
	 *
	 */
	private $rating;
	
	/**
	 * @return \Monubit\MonumentBundle\Entity\Monument The monument
	 */
	public function getMonument() {
		return $this->monument;
	}
	
	/**
	 * @param \Monubit\MonumentBundle\Entity\Monument $mId The monument
	 */
	public function setMonument($monument) {
		$this->monument = $monument;
	}
	
	/**
	 * @return \Monubit\UserBundle\Entity\User The user
	 */
	public function getUser() {
		return $this->user;
	}
	
	/**
	 * @param \Monubit\UserBundle\Entity\User $user The user
	 */
	public function setUser($user) {
		$this->user = $user;
	}
	
	/**
	 * @return integer the rating
	 */
	public function getRating() {
		return $this->rating;
	}
	
	/**
	 * @param integer $rate the rating
	 */
	public function setRating($rate) {
		$this->rating = $rate;
	}
}
