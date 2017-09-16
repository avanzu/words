<?php
/**
 * ResourceRequest.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Interaction\Resource;


use Components\Infrastructure\Request\CommandRequest;

abstract class ResourceCommandRequest implements CommandRequest
{
    protected $dao;

    /**
     * ResourceRequest constructor.
     *
     * @param $dao
     */
    public function __construct($dao = null)
    {
        $this->dao = $dao;
    }

    /**
     * @return string
     */
    abstract public function getResourceName();

    /**
     * @return string
     */
    abstract public function getIntention();

    /**
     * @return mixed
     */
    public function getDao()
    {
        return $this->dao;
    }

    /**
     * @param mixed $dao
     *
     * @return $this
     */
    public function setDao($dao)
    {
        $this->dao = $dao;

        return $this;
    }

}