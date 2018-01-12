<?php
/**
 * ResourceRequest.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Interaction\Resource;


use Components\Infrastructure\Request\IRequest;

abstract class ResourceRequest implements IRequest
{
    protected $payload;


    /**
     * ResourceRequest constructor.
     *
     * @param $payload
     */
    public function __construct($payload = null)
    {
        $this->payload       = $payload;
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
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param mixed $payload
     *
     * @return $this
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;

        return $this;
    }

}