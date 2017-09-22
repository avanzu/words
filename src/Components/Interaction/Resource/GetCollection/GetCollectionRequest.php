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
    protected $offset   = 0;

    protected $resourceName;

    /**
     * @var Criteria[]
     */
    protected $criteria = null;

    /**
     * GetCollectionRequest constructor.
     *
     * @param null       $dao
     * @param            $resourceName
     * @param int        $limit
     * @param int        $offset
     * @param Criteria[] $criteria
     */
    public function __construct($dao = null, $resourceName = null, $limit = 10, $offset = null, array $criteria = null)
    {
        $this->limit        = $limit;
        $this->offset       = $offset;
        $this->resourceName = $resourceName;
        $this->criteria     = $criteria;
        parent::__construct($dao);
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
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     *
     * @return $this
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;

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