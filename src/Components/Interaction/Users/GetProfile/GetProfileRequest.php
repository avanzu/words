<?php
/**
 * GetProfileRequest.php
 * words
 * Date: 14.01.18
 */

namespace Components\Interaction\Users\GetProfile;


use Components\Interaction\Resource\ResourceRequest;

class GetProfileRequest extends ResourceRequest
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
        return 'profile';
    }
}