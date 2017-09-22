<?php
/**
 * CreateResourceRequest.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Interaction\Resource\CreateResource;


use Components\Interaction\Resource\ResourceRequest;

abstract class CreateResourceRequest extends ResourceRequest
{
    public function getIntention()
    {
        return 'create';
    }


}