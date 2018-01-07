<?php
/**
 * UpdateResourceRequest.php
 * words
 * Date: 07.01.18
 */

namespace Components\Interaction\Resource\UpdateResource;


use Components\Interaction\Resource\ResourceRequest;

abstract  class UpdateResourceRequest extends ResourceRequest
{


    /**
     * @return string
     */
    public function getIntention()
    {
        return 'update';
    }
}