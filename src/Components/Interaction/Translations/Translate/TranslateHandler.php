<?php
/**
 * TranslateHandler.php
 * words
 * Date: 08.01.18
 */

namespace Components\Interaction\Translations\Translate;


use AppBundle\Manager\ResourceManager;
use Components\Infrastructure\Request\IRequest;
use Components\Infrastructure\Response\ErrorResponse;
use Components\Infrastructure\Response\ValidationFailedResponse;
use Components\Interaction\Resource\ResourceHandler;
use Components\Resource\ITransUnitManager;

/**
 * Class TranslateHandler
 * @property ITransUnitManager|ResourceManager $manager
 */
class TranslateHandler extends ResourceHandler
{

    /**
     * @param IRequest|TranslateRequest $request
     *
     * @return mixed
     */
    public function handle(IRequest $request)
    {
        $locale       = $request->getLocale();
        $resource     = $this->manager->loadOrCreate(
            $request->getKey(),
            $request->getCatalogue(),
            $request->getProject()
        );

        if( ! $value = $resource->getTranslation($locale)) {
            $value = $resource->createTranslation($locale);
        }

        $value->setContent($request->getLocaleString())->setState($request->getState());

        $result   = $this->manager->validate($resource, ["Default", $request->getIntention()]);

        if (!$result->isValid()) {
            return new ValidationFailedResponse($result);
        }

        try {
            $this->manager->save($resource);
            $message = $this->manager->getMessage($resource->getId(), $locale);

        } catch (\Exception $reason) {
            return new ErrorResponse('Unable to translate resource', 1, $reason);
        }

        return new TranslateResponse($message, $request);
    }
}