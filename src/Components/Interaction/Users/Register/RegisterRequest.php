<?php
/**
 * RegisterRequest.php
 * restfully
 * Date: 17.09.17
 */

namespace Components\Interaction\Users\Register;


use Components\Interaction\Resource\ResourceCommandRequest;

class RegisterRequest extends ResourceCommandRequest
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
        return 'register';
    }
}