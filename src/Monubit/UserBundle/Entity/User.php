<?php

namespace Monubit\UserBundle\Entity;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="monubit_user")
 */
class User extends BaseUser {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\OneToMany(targetEntity="\Monubit\RatingsBundle\Entity\Rating", mappedBy="user")
	 */
	private $ratings;
	
	public function __construct() {
		parent::__construct();
		$this->ratings = new ArrayCollection();
	}
	
	/**
	 * @return ArrayCollection The ratings
	 */
	public function getRatings() {
		return $this->ratings;
	}
	
	/**
	 * @param ArrayCollection $ratings The ratings
	 */
	public function setRatings($ratings) {
		$this->ratings = $ratings;
	}

}
