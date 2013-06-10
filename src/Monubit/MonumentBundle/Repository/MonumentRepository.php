<?php

namespace Monubit\MonumentBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Monubit\MonumentBundle\Entity\Monument;
use Monubit\MonumentBundle\Entity\Location;
use Monubit\TagBundle\Entity\Tag;

/**
 * The monument repository
 */
class MonumentRepository extends EntityRepository {
	
	/**
	 * Finds the average rating for given monument
	 * @param \Monubit\MonumentBundle\Entity\Monument $monument The monument
	 */
	public function findAverageRating($monument) {
		$qb = $this->getEntityManager()->createQueryBuilder();
		$qb = $qb->select($qb->expr()->avg('r.rating'))
			->from('MonubitRatingsBundle:rating', 'r')
			->where('r.monument = :monument')
			->setParameter('monument', $monument);
		
		return $qb->getQuery()->getSingleScalarResult();
	}
	
}