<?php
/**
 * RemoveResourceHandler.php
 * words
 * Date: 07.01.18
 */

namespace Components\Interaction\Resource\RemoveResource;


use Components\Infrastructure\Request\IRequest;
use Components\Infrastructure\Response\ErrorResponse;
use Components\Infrastructure\Response\ValidationFailedResponse;
use Components\Interaction\Resource\ResourceHandler;
use Components\Interaction\Resource\ResourceRequest;

class RemoveResourceHandler extends ResourceHandler
{

    /**
     * @param RemoveResourceRequest|IRequest $request
     *
     * @return RemoveResourceResponse|ErrorResponse
     */
    public function handle(IRequest $request)
    {
        $resource = $request->getPayload();
        $result   = $this->manager->validate($resource, ["Default", $request->getIntention()]);

        if (!$result->isValid()) {
            return new ValidationFailedResponse($result);
        }

        try {
            $this->manager->remove($resource);
        } catch (\Exception $reason) {
            return new ErrorResponse('Unable to remove resource', 1, $reason);
        }

        return $this->createResponse($request, $resource);
    }

    /**
     * @param IRequest|ResourceRequest $request
     * @param                          $resource
     *
     * @return RemoveResourceResponse
     */
    protected function createResponse(IRequest $request, $resource)
    {
        $responseClass = str_replace('Request', 'Response', get_class($request));
        if (class_exists($responseClass)) {
            return new $responseClass($resource, $request);
        }

        return new RemoveResourceResponse($resource, $request);
    }
}