<?php
/**
 * CreateResourceRequest.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Interaction\Resource\CreateResource;


use Components\Interaction\Resource\ResourceCommandRequest;

abstract class CreateResourceRequest extends ResourceCommandRequest
{
    public function getIntention()
    {
        return 'create';
    }


}