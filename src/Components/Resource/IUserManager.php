<?php
/**
 * IUserManager.php
 * restfully
 * Date: 22.09.17
 */

namespace Components\Resource;

use AppBundle\Repository\UserRepository;
use Components\Exception\ActivationFailedException;
use Components\Exception\RegistrationFailedException;
use Components\Exception\ResetAccountException;
use Components\Model\User;
use Components\Model\UserProfile;


/**
 * Class IUserManager
 * @method UserRepository getRepository
 */
interface IUserManager extends IManager
{
    /**
     * @param $criteria
     *
     * @return User|false
     */
    public function loadUserByCriteria($criteria);

    /**
     * @param $token
     *
     * @return User
     */
    public function loadUserByToken($token);

    /**
     * @param User $model
     * @param      $plainPassword
     *
     * @return string
     */
    public function encodePassword(User $model, $plainPassword);

    /**
     * @param User $model
     *
     * @return UserProfile
     */
    public function loadUserProfile(User $model);
}