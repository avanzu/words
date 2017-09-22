<?php
/**
 * UserManager.php
 * restfully
 * Date: 22.09.17
 */

namespace Components\Resource;

use AppBundle\Repository\UserRepository;
use Components\Exception\ActivationFailedException;
use Components\Exception\RegistrationFailedException;
use Components\Exception\ResetAccountException;
use Components\Model\User;


/**
 * Class UserManager
 * @method UserRepository getRepository
 */
interface UserManager extends Manager
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
     * @param User $user
     *
     * @throws RegistrationFailedException
     */
    public function registerUser(User $user);

    /**
     * @param User $user
     *
     * @throws ActivationFailedException
     */
    public function activateUser(User $user);

    /**
     * @param User $user
     *
     * @throws ResetAccountException
     */
    public function enableReset(User $user);

    /**
     * @param User $user
     *
     * @throws ResetAccountException
     */
    public function resetUser(User $user);

    /**
     * @param User $model
     * @param      $plainPassword
     *
     * @return string
     */
    public function encodePassword(User $model, $plainPassword);
}