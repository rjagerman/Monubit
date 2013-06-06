<?php
namespace Monubit\SearchBundle\Entity;

/**
 * A search query
 */
class Query {

	/**
	 * The query
	 * 
	 * @var string
	 */
	private $query;

	/**
	 * The number of results per page
	 * 
	 * @var int
	 */
	private $resultsPerPage;

	/**
	 * The offset to the first returned result
	 * 
	 * @var int
	 */
	private $offset;

	/**
	 * Creates a query
	 * 
	 * @param string $query The query
	 * @param int $page The current page
	 * @param int $resultsPerPage The number of results per page (default: 10)
	 */
	public function __construct($query, $page, $resultsPerPage = 10) {
		$this->setResultsPerPage($resultsPerPage);
		$this->setQuery($query);
		$this->setOffset(($page - 1) * $this->getResultsPerPage());
	}

	/**
	 * @return string The query
	 */
	public function getQuery() {
		return $this->query;
	}
	
	/**
	 * @return string The safe variant of the query for passing on to other scripts
	 */
	public function getSafeQuery() {
		return preg_replace('/[^a-zA-Z0-9]+/', ' ', $this->query);
	}

	/**
	 * @param string $query The query
	 */
	public function setQuery($query) {
		$this->query = $query;
	}

	/**
	 * @return int The result offset
	 */
	public function getOffset() {
		return $this->offset;
	}

	/**
	 * @param int $offset The result offset
	 */
	public function setOffset($offset) {
		if ($offset < 1) {
			$offset = 1;
		}
		$this->offset = $offset;
	}

	/**
	 * @return number The number of results per page
	 */
	public function getResultsPerPage() {
		return $this->resultsPerPage;
	}

	/**
	 * @param number $resultsPerPage The number of results per page
	 */
	public function setResultsPerPage($resultsPerPage) {
		if ($resultsPerPage < 1) {
			$resultsPerPage = 10;
		}
		$this->resultsPerPage = $resultsPerPage;
	}

}
