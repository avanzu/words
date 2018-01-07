<?php
/**
 * GetTranslationsRequest.php
 * words
 * Date: 07.01.18
 */

namespace Components\Interaction\Translations\GetTranslations;


use Components\Interaction\Resource\GetCollection\GetCollectionRequest;

class GetTranslationsRequest extends GetCollectionRequest
{
    public function getResourceName()
    {
        return 'trans.unit';
    }


}