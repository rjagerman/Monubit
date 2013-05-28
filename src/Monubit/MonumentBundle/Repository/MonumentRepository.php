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
	
	/**
	 * Finds monuments using partial text matching
	 * 
	 * @param array $criteria Array of criteria utilising fields and their values
	 * @param int $limit The limit
	 * @param int $offset The offset
	 */
	public function findLike($criteria, $limit = 0, $offset = 0) {
		
		// Create query
		$query = $this->getSelect('m');
		
		// Add LIKE clauses
		$query = $this->addCriteria($query, $criteria);
		
		// Add limit and offset
		if($limit != 0) {
			$query->setMaxResults($limit);
		}
		$query->setFirstResult($offset);
		
		// Execute and return result
		return $query->getQuery()->getResult();
		
	}
	
	/**
	 * Finds the total number of results using partial text matching
	 * 
	 * @param array $criteria The criteria
	 * @return Ambigous <multitype:, \Doctrine\ORM\mixed, \Doctrine\DBAL\Driver\Statement, \Doctrine\Common\Cache\mixed> The results
	 */
	public function findCountLike($criteria) {
		
		// Create query
		$query = $this->getSelect('count(m)');
		
		// Add LIKE clauses
		$query = $this->addCriteria($query, $criteria);
		
		// Execute and return result
		return $query->getQuery()->getSingleScalarResult();
	}
	
	/**
	 * Adds the given criteria as LIKE clauses to the query
	 * 
	 * @param \Doctrine\ORM\QueryBuilder $query The query
	 * @param array $criteria The criteria
	 * 
	 * @return \Doctrine\ORM\QueryBuilder The query
	 */
	public function addCriteria($query, $criteria) {
		
		// Add criteria to query
		foreach($criteria as $field => $value) {
			$query = $this->addWhereLike($query, get_class(new Monument()), $field, $value);
			$query = $this->addWhereLike($query, get_class(new Location()), $field, $value);
			$query = $this->addWhereLike($query, get_class(new Tag()), $field, $value);
		}
		
		// Return the new query
		return $query;
		
	}

	
	/**
	 * Adds a where clause on given query using given class, field and value
	 * by utilising LIKE
	 * 
	 * @param \Doctrine\ORM\QueryBuilder $query The query
	 * @param string $class The class for which the field comparison is added
	 * @param string $field The field to compare on
	 * @param mixed $value The value to compare to
	 * 
	 * @return \Doctrine\ORM\QueryBuilder The new query
	 */
	private function addWhereLike($query, $class, $field, $value) {
		
		// Grab methods from the class
		$methods = array_values(get_class_methods($class));
		$class = substr($class, strrpos($class, '\\')+1);
		
		foreach($methods as $method) {
			
			// If the field has a setter it can be accessed, so we can add
			// it to the query
			if($method == 'set' . ucfirst($field)) {
				$query = $query->where(strtolower(substr($class, 0, 1)) . '.' . $field . ' LIKE :v' . $class . $field);
				$query = $query->setParameter('v' . $class . $field, '%' . $value . '%');
			}
		}
		
		// Return the new query with the additional where clauses
		return $query;
	}
	
	
	/**
	 * Gets a query builder with a basic select on monuments and their locations
	 * 
	 * @param string $select The select query
	 * @return Ambigous <\Doctrine\ORM\QueryBuilder, \Doctrine\ORM\QueryBuilder> The query builder
	 */
	private function getSelect($select) {
		return $this->getEntityManager()->createQueryBuilder()
			->select($select)
			->from('MonubitMonumentBundle:Monument', 'm')
			->leftJoin('m.location', 'l')
			->leftJoin('m.tags', 't');
	}

}