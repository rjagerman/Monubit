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
	
	/**
	 * Compute the cosine similarity between this user and given user
	 * 
	 * @param \Monubit\UserBundle\Entity\User $user The user
	 * @return number The cosine similarity
	 */
	public function getCosineSimilarity($user) {
		
		// Initialise arrays
		$a = $b = $c = 0;
		$tokensA = $tokensB = $uniqueTokensA = $uniqueTokensB = array();
		
		// Get the ratings and place them in sparse arrays
		foreach($user->getRatings() as $rating) {
			$tokensA[$rating->getMonument()->getId()] = $rating->getRating();
		}
		foreach($this->getRatings() as $rating) {
			$tokensB[$rating->getMonument()->getId()] = $rating->getRating();
		}
		
		// Get unique values of the merged arrays
		$uniqueMergedTokens = array_unique(array_merge($user->getRatings()->toArray(), $user->getRatings()->toArray()));
		
		// Set others to 0
		foreach ($tokensA as $token) $uniqueTokensA[$token] = 0;
		foreach ($tokensB as $token) $uniqueTokensB[$token] = 0;
		
		// Compute cosine angle between the arrays
		foreach ($uniqueMergedTokens as $token) {
			$x = isset($uniqueTokensA[$token]) ? 1 : 0;
			$y = isset($uniqueTokensB[$token]) ? 1 : 0;
			$a += $x * $y;
			$b += $x;
			$c += $y;
		}
		return $b * $c != 0 ? $a / sqrt($b * $c) : 0;
	}

}
