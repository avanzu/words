<?php
/**
 * UserManager.php
 * restfully
 * Date: 22.09.17
 */

namespace Components\Resource;


/**
 * Class UserManager
 * @method UserRepository getRepository
 */
interface UserManager
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