<?php
/**
 * GetCollectionHandler.php
 * restfully
 * Date: 17.09.17
 */

namespace Components\Interaction\Resource\GetCollection;


use Components\Infrastructure\Request\CommandRequest;
use Components\Infrastructure\Response\CommandResponse;
use Components\Infrastructure\Response\ErrorCommandResponse;
use Components\Interaction\Resource\ResourceHandler;

class GetCollectionHandler extends ResourceHandler
{

    /**
     * @param CommandRequest|GetCollectionRequest $request
     *
     * @return mixed
     */
    public function handle(CommandRequest $request)
    {
        $manager    = $this->getManager();
        try {
            $collection = $manager->getCollection($request->getLimit(), $request->getOffset(), $request->getCriteria());

            return new GetCollectionResponse($collection, $request);
        } catch ( \Exception $e ) {
            return new ErrorCommandResponse(
                sprintf('%s.%s.error', $request->getResourceName(), $request->getIntention()),
                CommandResponse::STATUS_INTERNAL_SERVER_ERROR,
                $e
            );
        }

    }
}