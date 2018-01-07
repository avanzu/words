<?php
/**
 * RemoveResourceRequest.php
 * words
 * Date: 07.01.18
 */

namespace Components\Interaction\Resource\RemoveResource;


use Components\Interaction\Resource\ResourceRequest;

abstract class RemoveResourceRequest extends ResourceRequest
{

    /**
     * @return string
     */
    public function getIntention()
    {
        return 'remove';
    }
}