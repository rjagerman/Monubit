<?php
namespace Monubit\SearchBundle\Entity;

/**
 * A list of search results
 */
class Results {

	/**
	 * The query that constructed these results
	 *
	 * @var \Monubit\SearchBundle\Entity\Query
	 */
	private $query;

	/**
	 * The number of results
	 *
	 * @var int
	 */
	private $numberOfResults;

	/**
	 * The list of monuments
	 * 
	 * @var array
	 */
	private $monuments;

	/**
	 * Creates a new empty search result set
	 */
	public function __construct($query) {
		$this->query = $query;
		$this->monuments = array();
	}

	/**
	 * @return number The number of results
	 */
	public function getNumberOfResults() {
		return $this->numberOfResults;
	}

	/**
	 * @param number $numberOfResults The number of results
	 */
	public function setNumberOfResults($numberOfResults) {
		$this->numberOfResults = $numberOfResults;
	}

	/**
	 * @return \Monubit\SearchBundle\Entity\Query The query
	 */
	public function getQuery() {
		return $this->query;
	}

	/**
	 * @return array The list of monuments
	 */
	public function getMonuments() {
		return $this->monuments;
	}

	/**
	 * @param \Monubit\MonumentBundle\Entity\Monument $monument
	 */
	public function addMonuments($monument) {
		$this->monuments[] = $monument;
	}
	
	/**
	 * Filters out given id from the search results
	 * 
	 * @param int $id The identifier
	 */
	public function filter($id) {
		$results = array();
		foreach($this->monuments as $monument) {
			if($monument->getId() != $id) {
				$results[] = $monument;
			}
		}
		$this->monuments = $results;
	}

}
