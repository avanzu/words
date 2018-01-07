<?php
/**
 * CreateTranslationRequest.php
 * words
 * Date: 07.01.18
 */

namespace Components\Interaction\Translations\CreateTranslation;


use Components\Interaction\Resource\CreateResource\CreateResourceRequest;

class CreateTranslationRequest extends CreateResourceRequest
{

    /**
     * @return string
     */
    public function getResourceName()
    {
        return 'trans.unit';
    }
}