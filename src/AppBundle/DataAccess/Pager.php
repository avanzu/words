<?php
/**
 * Pager.php
 * words
 * Date: 13.01.18
 */

namespace AppBundle\DataAccess;


use Components\DataAccess\IPager;
use JMS\Serializer\Annotation as Serializer;
use Pagerfanta\Pagerfanta;
use JMS\Serializer\Annotation\Exclude;


/**
 * Class Pager
 */
class Pager extends Pagerfanta implements IPager
{

    /**
     * @param int $pageSize
     *
     * @return $this
     */
    public function setPageSize($pageSize)
    {
        $this->setMaxPerPage($pageSize);
        return $this;
    }

    /**
     * @return int
     */
    public function getPageSize()
    {
        return $this->getMaxPerPage();
    }

    /**
     * @param int $page
     *
     * @return $this
     */
    public function setPage($page)
    {
        $this->setCurrentPage($page);
        return $this;
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->getCurrentPage();
    }

    /**
     * @return int
     */
    public function getResultsTotal()
    {
        return $this->getNbResults();
    }

    /**
     * @return int
     */
    public function getPagesTotal()
    {
        return $this->getNbPages();
    }

    /**
     * @return array|\Traversable
     */
    public function getItems()
    {
        return $this->getCurrentPageResults();
    }

    /**
     * @return bool
     */
    public function hasNext()
    {
        return $this->hasNextPage();
    }

    /**
     * @return int
     */
    public function getNext()
    {
        return $this->getNextPage();
    }

    /**
     * @return bool
     */
    public function hasPrevious()
    {
        return $this->hasPreviousPage();
    }

    /**
     * @return int
     */
    public function getPrevious()
    {
        return $this->getPreviousPage();
    }

    /**
     * @return bool
     */
    public function isMultiPage()
    {
        return $this->haveToPaginate();
    }

}