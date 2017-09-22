<?php
/**
 * CreateResourceHandler.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Interaction\Resource\CreateResource;

use Components\Infrastructure\Response\ErrorResponse;
use Components\Infrastructure\Request\IRequest;
use Components\Infrastructure\Response\ValidationFailedResponse;
use Components\Interaction\Resource\ResourceHandler;

/**
 * Class CreateResourceHandler
 */
class CreateResourceHandler extends ResourceHandler
{

    /**
     * @param CreateResourceRequest|IRequest $request
     *
     * @return CreateResourceResponse|ErrorResponse
     */
    public function handle(IRequest $request)
    {
        $resource = $this->manager->createNew($request->getDao());
        $result   = $this->manager->validate($resource, ["Default", $request->getIntention()]);

        if( ! $result->isValid() ) {
            return new ValidationFailedResponse($result);
        }

        try {
            $this->manager->save($resource);
        } catch(\Exception $reason) {
            return new ErrorResponse('Unable to store resource', 1, $reason);
        }

        return $this->createResponse($request, $resource);
    }

    /**
     * @param IRequest       $request
     * @param                $resource
     *
     * @return CreateResourceResponse
     */
    protected function createResponse(IRequest $request, $resource)
    {
        $responseClass = str_replace('Request', 'Response', get_class($request));
        if( class_exists($responseClass) ) return new $responseClass($resource, $request);

        return new CreateResourceResponse($resource, $request);
    }
}