<?php
/**
 * TranslateHandler.php
 * words
 * Date: 08.01.18
 */

namespace Components\Interaction\Translations\Translate;


use Components\Infrastructure\Request\IRequest;
use Components\Infrastructure\Response\ErrorResponse;
use Components\Infrastructure\Response\ValidationFailedResponse;
use Components\Interaction\Resource\ResourceHandler;

class TranslateHandler extends ResourceHandler
{

    /**
     * @param IRequest|TranslateRequest $request
     *
     * @return mixed
     */
    public function handle(IRequest $request)
    {
        $resource     = $request->getPayload();
        $locale       = $request->getLocale();
        $localeString = $request->getLocaleString();

        if( ! $value = $resource->getTranslation($locale)) {
            $value = $resource->createTranslation($locale);
        }

        $value->setContent($localeString);

        $result   = $this->manager->validate($resource, ["Default", $request->getIntention()]);

        if (!$result->isValid()) {
            return new ValidationFailedResponse($result);
        }

        try {
            $this->manager->save($resource);
        } catch (\Exception $reason) {
            return new ErrorResponse('Unable to translate resource', 1, $reason);
        }

        return new TranslateResponse($resource, $request);
    }
}