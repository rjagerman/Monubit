<?php
namespace Monubit\SearchBundle\Entity;

/**
 * A pagination for search
 */
class Pagination {

	/**
	 * The results of the search
	 * 
	 * @var \Monubit\SearchBundle\Entity\Results
	 */
	private $results;

	/**
	 * The number of adjacent pages
	 * 
	 * @var int
	 */
	private $adjacentPages;

	/**
	 * Creates the pagination
	 * 
	 * @param \Monubit\SearchBundle\Entity\Results $results The results
	 * @param number $resultsPerPage The number of results per page
	 * @param number $adjacentPages The number of adjacent pages
	 */
	public function __construct($results, $adjacentPages = 4) {
		$this->results = $results;
		$this->adjacentPages = $adjacentPages;
	}

	/**
	 * @return number The current page
	 */
	public function getCurrentPage() {
		return ceil(
				$this->results->getQuery()->getOffset()
						/ $this->results->getQuery()->getResultsPerPage());
	}

	/**
	 * @return number The start page of the pagination bar
	 */
	public function getStartPage() {
		return max(1,
				min($this->getCurrentPage() - $this->adjacentPages,
						$this->getNumberOfPages()));
	}

	/**
	 * @return number The final page of the pagination bar
	 */
	public function getEndPage() {
		return max(1,
				min($this->getCurrentPage() + $this->adjacentPages,
						$this->getNumberOfPages()));
	}

	/**
	 * Gets the total number of pages
	 * 
	 * @return number
	 */
	public function getNumberOfPages() {
		return ceil(
				$this->results->getNumberOfResults()
						/ $this->results->getQuery()->getResultsPerPage());
	}

}
