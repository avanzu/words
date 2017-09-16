<?php
/**
 * ChangePasswordRequest.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Interaction\Users\ResetPassword;


use Components\Interaction\Resource\ResourceCommandRequest;

class ChangePasswordRequest extends ResourceCommandRequest
{

    protected $plainPassword;

    /**
     * ChangePasswordRequest constructor.
     *
     * @param null $user
     * @param      $newPassword
     */
    public function __construct($user = null, $newPassword = null) {
        parent::__construct($user);
        $this->plainPassword = $newPassword;
    }

    /**
     * @param null $plainPassword
     *
     * @return $this
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @return null
     */
    public function getDao()
    {
        return $this->dao;
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
        return 'change_password';
    }
}