<?php
/**
 * GetCollectionRequest.php
 * restfully
 * Date: 17.09.17
 */

namespace Components\Interaction\Resource\GetCollection;


use Components\DataAccess\Criteria;
use Components\Interaction\Resource\ResourceRequest;

class GetCollectionRequest extends ResourceRequest
{

    protected $limit    = 10;
    protected $page   = 1;

    protected $resourceName;

    /**
     * @var Criteria[]
     */
    protected $criteria = null;

    /**
     * GetCollectionRequest constructor.
     *
     * @param null       $payload
     * @param            $resourceName
     * @param int        $limit
     * @param int        $offset
     * @param Criteria[] $criteria
     */
    public function __construct($payload = null, $resourceName = null, $limit = 10, $page = 1, array $criteria = null)
    {
        $this->limit        = $limit;
        $this->page         = $page;
        $this->resourceName = $resourceName;
        $this->criteria     = $criteria;
        parent::__construct($payload);
    }

    /**
     * GetCollectionRequest constructor.
     *
     * @param $resourceName
     */



    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     *
     * @return $this
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page ?: 1;
    }

    /**
     * @param int $page
     *
     * @return $this
     */
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @return Criteria[]
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * @param Criteria[] $criteria
     *
     * @return $this
     */
    public function setCriteria($criteria)
    {
        $this->criteria = $criteria;

        return $this;
    }

    /**
     * @return string
     */
    public function getIntention()
    {
        return 'list';
    }

    public function getResourceName()
    {
        return $this->resourceName;
    }


}