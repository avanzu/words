<?php
/**
 * ResetPasswordRequest.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Interaction\Users\ResetPassword;


use Components\Interaction\Resource\ResourceCommandRequest;
use Components\Model\User;

class ResetPasswordRequest extends ResourceCommandRequest
{




    /**
     * @return User
     */
    public function getUser()
    {
        return $this->getDao();
    }

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
        return 'reset';
    }


}