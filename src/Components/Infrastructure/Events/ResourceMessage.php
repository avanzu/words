<?php
/**
 * ResourceMessage.php
 * restfully
 * Date: 17.09.17
 */

namespace Components\Infrastructure\Events;


use Components\Interaction\Resource\ResourceCommandRequest;
use Components\Interaction\Resource\ResourceResponse;

class ResourceMessage implements Message
{
    /**
     * @var ResourceCommandRequest
     */
    protected $request;

    /**
     * @var ResourceResponse
     */
    protected $response;

    public function __construct(ResourceCommandRequest $request, ResourceResponse $response)
    {
        $this->request  = $request;
        $this->response = $response;
    }

    public function getName()
    {
        $request  = $this->getRequest();
        return sprintf('%s.%s.%s', $request->getResourceName(), $request->getIntention(), $this->getSuffix());
    }

    protected function getSuffix()
    {
        $response = $this->getResponse();

        if ($response->isSuccessful()) {
            return 'done';
        }
        if ($response->isInformational()) {
            return 'processing';
        }
        if ($response->isClientError()) {
            return 'error.client';
        }
        if ($response->isServerError()) {
            return 'error.server';
        }

        return 'promise';
    }

    /**
     * @return ResourceCommandRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return ResourceResponse
     */
    public function getResponse()
    {
        return $this->response;
    }

}