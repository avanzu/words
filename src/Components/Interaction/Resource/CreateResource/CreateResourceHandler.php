<?php
/**
 * CreateResourceHandler.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Interaction\Resource\CreateResource;

use Components\Infrastructure\Response\ErrorCommandResponse;
use Components\Infrastructure\Request\CommandRequest;
use Components\Infrastructure\Response\ValidationFailedResponse;
use Components\Interaction\Resource\ResourceHandler;

/**
 * Class CreateResourceHandler
 */
class CreateResourceHandler extends ResourceHandler
{

    /**
     * @param CreateResourceRequest|CommandRequest $request
     *
     * @return CreateResourceResponse|ErrorCommandResponse
     */
    public function handle(CommandRequest $request)
    {
        $resource = $this->manager->createNew($request->getDao());
        $result   = $this->manager->validate($resource, ["Default", $request->getIntention()]);

        if( ! $result->isValid() ) {
            return new ValidationFailedResponse($result);
        }

        try {
            $this->manager->save($resource);
        } catch(\Exception $reason) {
            return new ErrorCommandResponse('Unable to store resource', 1, $reason);
        }

        return $this->createResponse($request, $resource);
    }

    /**
     * @param CommandRequest $request
     * @param                $resource
     *
     * @return CreateResourceResponse
     */
    protected function createResponse(CommandRequest $request, $resource)
    {
        $responseClass = str_replace('Request', 'Response', get_class($request));
        if( class_exists($responseClass) ) return new $responseClass($resource, $request);

        return new CreateResourceResponse($resource, $request);
    }
}