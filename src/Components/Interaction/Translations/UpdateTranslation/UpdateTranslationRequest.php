<?php
/**
 * UpdateTranslationRequest.php
 * words
 * Date: 07.01.18
 */

namespace Components\Interaction\Translations\UpdateTranslation;


use Components\Interaction\Resource\UpdateResource\UpdateResourceRequest;

class UpdateTranslationRequest extends UpdateResourceRequest
{

    /**
     * @return string
     */
    public function getResourceName()
    {
        return 'trans.unit';
    }
}