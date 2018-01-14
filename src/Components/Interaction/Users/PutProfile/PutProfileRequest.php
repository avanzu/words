<?php
/**
 * PutProfileRequest.php
 * words
 * Date: 14.01.18
 */

namespace Components\Interaction\Users\PutProfile;


use Components\Interaction\Resource\UpdateResource\UpdateResourceRequest;

class PutProfileRequest extends UpdateResourceRequest
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
        return 'update_profile';
    }
}