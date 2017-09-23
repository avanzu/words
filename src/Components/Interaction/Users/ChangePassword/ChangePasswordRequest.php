<?php
/**
 * ChangePasswordRequest.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Interaction\Users\ChangePassword;


use Components\Interaction\Resource\ResourceRequest;
use Components\Model\User;

/**
 * Class ChangePasswordRequest
 */
class ChangePasswordRequest extends ResourceRequest
{

    /**
     * @var string
     */
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
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @return User|null
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