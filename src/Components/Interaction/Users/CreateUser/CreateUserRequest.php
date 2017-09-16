<?php
/**
 * CreateUserRequest.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Interaction\Users\CreateUser;


use Components\Interaction\Resource\CreateResource\CreateResourceRequest;

class CreateUserRequest extends CreateResourceRequest
{

    /**
     * @return string
     */
    public function getResourceName()
    {
        return 'user';
    }
}