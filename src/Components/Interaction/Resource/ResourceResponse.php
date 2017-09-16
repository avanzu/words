<?php
/**
 * ResourceResponse.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Interaction\Resource;


use Components\Infrastructure\Response\CommandResponse;
use Components\Infrastructure\Response\Response;

class ResourceResponse extends Response
{
    /**
     * @var mixed
     */
    protected $resource;

    /**
     * @var ResourceCommandRequest
     */
    private $request;


    /**
     * ResourceResponse constructor.
     *
     * @param                        $resource
     * @param int                    $status
     * @param ResourceCommandRequest $request
     *
     * @internal param null $resourceName
     */
    public function __construct($resource, ResourceCommandRequest $request, $status = CommandResponse::STATUS_OK) {
        $this->resource     = $resource;
        $this->status       = $status;
        $this->request      = $request;
    }

    /**
     * @return mixed
     */
    public function getResource()
    {
        return $this->resource;
    }


    public function getMessage()
    {
        $request = $this->request;
        return sprintf('response.%s.%s', $request->getResourceName(), $request->getIntention());
    }


}