<?php
/**
 * Pager.php
 * words
 * Date: 13.01.18
 */

namespace Components\DataAccess;


/**
 * Interface IPager
 *
 * @package Components\DataAccess
 */
interface IPager
{

    /**
     * @param int $pageSize
     *
     * @return $this
     */
    public function setPageSize($pageSize);

    /**
     * @return int
     */
    public function getPageSize();

    /**
     * @param int $page
     *
     * @return $this
     */
    public function setPage($page);

    /**
     * @return int
     */
    public function getPage();

    /**
     * @return int
     */
    public function getResultsTotal();

    /**
     * @return int
     */
    public function getPagesTotal();

    /**
     * @return array|\Traversable
     */
    public function getItems();

    /**
     * @return bool
     */
    public function hasNext();

    /**
     * @return int
     */
    public function getNext();

    /**
     * @return bool
     */
    public function hasPrevious();

    /**
     * @return int
     */
    public function getPrevious();

    /**
     * @return \Traversable
     */
    public function getIterator();
    /**
     * @return bool
     */
    public function isMultiPage();

}