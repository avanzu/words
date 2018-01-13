<?php
/**
 * GetCollectionHandler.php
 * restfully
 * Date: 17.09.17
 */

namespace Components\Interaction\Resource\GetCollection;


use Components\Infrastructure\Request\IRequest;
use Components\Infrastructure\Response\IResponse;
use Components\Infrastructure\Response\ErrorResponse;
use Components\Interaction\Resource\ResourceHandler;

class GetCollectionHandler extends ResourceHandler
{

    /**
     * @param IRequest|GetCollectionRequest $request
     *
     * @return mixed
     */
    public function handle(IRequest $request)
    {
        $manager    = $this->getManager();
        try {
            $collection = $manager->getCollection($request->getLimit(), $request->getPage(), $request->getCriteria());

            return new GetCollectionResponse($collection, $request);
        } catch ( \Exception $e ) {
            return new ErrorResponse(
                sprintf('%s.%s.error', $request->getResourceName(), $request->getIntention()),
                IResponse::STATUS_INTERNAL_SERVER_ERROR,
                $e
            );
        }

    }
}