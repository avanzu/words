<?php
/**
 * ActivateRequest.php
 * restfully
 * Date: 17.09.17
 */

namespace Components\Interaction\Users\Activate;


use Components\Interaction\Resource\ResourceRequest;

class ActivateRequest extends ResourceRequest
{

    /**
     * @return string
     */
    public function getResourceName()
    {
        return 'user';
    }

    /**
     * @return string
     */
    public function getIntention()
    {
        return 'activate';
    }
}