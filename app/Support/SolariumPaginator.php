<?php

namespace Jitterbug\Support;

use Solarium\QueryType\Select\Result\Result;

/*
 * Pagination support for Solarium result sets.
 */
class SolariumPaginator implements \Countable, \IteratorAggregate
{
    /**
     * The current page being viewed.
     *
     * @var int
     */
    protected $currentPage;

    /**
     * The solarium result set.
     *
     * @var Solarium\QueryType\Select\Result\Result
     */
    protected $resultSet;

    /**
     * The total number of documents in the result set.
     *
     * @var int
     */
    protected $total;

    /**
     * The last page of the result set.
     *
     * @var int
     */
    protected $lastPage;

    /**
     * Number of items to return per page.
     *
     * @var int
     */
    protected $perPage;

    public function __construct(Result $resultSet, $currentPage, $perPage)
    {
        $this->resultSet = $resultSet;
        $this->perPage = $perPage;
        $this->currentPage = $currentPage === null ? 1 : $currentPage;
        $this->total = $resultSet->getNumFound();
        $this->lastPage = (int) ceil($this->total / $perPage);
    }

    /**
     * Determine if there are more items in the data source.
     *
     * @return bool
     */
    public function currentPage()
    {
        return $this->currentPage;
    }

    /**
     * Determine if there are more items in the data source.
     *
     * @return bool
     */
    public function hasMorePages()
    {
        return $this->currentPage() < $this->lastPage();
    }

    /**
     * Get the total number of items being paginated.
     *
     * @return int
     */
    public function total()
    {
        return $this->total;
    }

    /**
     * Get the last page.
     *
     * @return int
     */
    public function lastPage()
    {
        return $this->lastPage;
    }

    /**
     * IteratorAggregate implementation.
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return $this->resultSet->getIterator();
    }

    /**
     * Countable implementation.
     *
     * @return int
     */
    public function count()
    {
        return $this->resultSet->count();
    }
}
