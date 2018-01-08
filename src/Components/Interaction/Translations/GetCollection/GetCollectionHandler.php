<?php
/**
 * GetCollectionHandler.php
 * words
 * Date: 08.01.18
 */

namespace Components\Interaction\Translations\GetCollection;
use Components\Infrastructure\Request\IRequest;
use Components\Infrastructure\Response\ErrorResponse;
use Components\Infrastructure\Response\IResponse;
use Components\Interaction\Resource\GetCollection\GetCollectionHandler as CollectionHandler;
use Components\Resource\ITransUnitManager;

class GetCollectionHandler extends CollectionHandler
{
    /**
     * @param IRequest|GetCollectionRequest $request
     *
     * @return ErrorResponse|GetCollectionResponse|mixed
     */
    public function handle(IRequest $request)
    {

        /** @var ITransUnitManager $manager */
        $manager    = $this->getManager();
        try {
            $collection = $manager->getTranslatables(
                $request->getLocale(),
                $request->getCatalogue(),
                $request->getProject(),
                $request->getOffset(),
                $request->getLimit()
            );

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