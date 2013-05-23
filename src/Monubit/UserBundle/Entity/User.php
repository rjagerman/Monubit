<?php

namespace Monubit\UserBundle\Entity;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

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
	private $rating;
	
	public function __construct() {
		parent::__construct();
	}

}
