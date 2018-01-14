<?php
/**
 * ResourceResponse.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Interaction\Resource;


use Components\Infrastructure\Response\IResponse;
use Components\Infrastructure\Response\Response;

class ResourceResponse extends Response
{
    /**
     * @var mixed
     */
    protected $resource;

    /**
     * @var ResourceRequest
     */
    private $request;


    /**
     * ResourceResponse constructor.
     *
     * @param                        $resource
     * @param int                    $status
     * @param ResourceRequest        $request
     *
     * @internal param null $resourceName
     */
    public function __construct($resource, ResourceRequest $request = null, $status = IResponse::STATUS_OK) {
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