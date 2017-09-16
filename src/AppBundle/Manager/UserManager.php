<?php
/**
 * UserManager.php
 * restfully
 * Date: 08.04.17
 */

namespace AppBundle\Manager;


use Components\Model\User;
use AppBundle\Event\UserEvent;
use AppBundle\Event\UserEvents;
use AppBundle\Repository\UserRepository;
use Components\Exception\ActivationFailedException;
use Components\Exception\RegistrationFailedException;
use Components\Exception\ResetAccountException;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Class UserManager
 * @method UserRepository getRepository
 */
class UserManager extends ResourceManager implements UserProviderInterface, ContainerAwareInterface
{

    const INTENT_REGISTER = 'register';

    const INTENT_RESET    = 'reset';

    const INTENT_ACTIVATE = 'activate';

    /**
     * @var ContainerInterface
     */
    protected $container;


    /**
     * Loads the user for the given username.
     *
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @param string $username The username
     *
     * @return UserInterface
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByUsername($username)
    {
        $user = $this->getRepository()->findOneBy(['username' => $username]);
        if( ! $user ) throw new UsernameNotFoundException();
        return $user;
    }

    /**
     * @param $criteria
     *
     * @return User|false
     */
    public function loadUserByCriteria($criteria)
    {
        return $this->getRepository()->findUserByUsernameOrEmail($criteria);
    }

    /**
     * @param $token
     *
     * @return User
     */
    public function loadUserByToken($token)
    {
        return $this->getRepository()->findOneBy(['token' => $token ]);
    }

    /**
     * @param User $user
     * @throws RegistrationFailedException
     */
    public function registerUser(User $user)
    {
        $this->updatePassword($user);
        $user->setToken(uniqid(static::INTENT_ACTIVATE));
        $this->getEntityManager()->beginTransaction();
        try {

            $this->save($user, true, static::INTENT_ACTIVATE);
            $this->dispatch(UserEvents::USER_REGISTER_DONE, new UserEvent($user, UserManager::INTENT_REGISTER));
            $this->getEntityManager()->commit();

        } catch(\Exception $e) {
            $this->getEntityManager()->rollback();
            throw new RegistrationFailedException('Could not create user account.', 0, $e);
        }
    }

    /**
     * @param User $user
     *
     * @throws ActivationFailedException
     */
    public function activateUser(User $user)
    {
        $user->setToken(null)->setIsActive(true);
        $this->getEntityManager()->beginTransaction();

        try {
            $this->save($user, true, static::INTENT_ACTIVATE);
            $this->dispatch(UserEvents::USER_ACTIVATE_DONE, new UserEvent($user, UserManager::INTENT_ACTIVATE));
            $this->getEntityManager()->commit();

        } catch(\Exception $e) {

            $this->getEntityManager()->rollback();
            throw new ActivationFailedException('Could not activate user account.', 0, $e);
        }
    }

    /**
     * @param User $user
     *
     * @throws ResetAccountException
     */
    public function enableReset(User $user)
    {
        $user->setToken(uniqid(static::INTENT_RESET));
        $this->getEntityManager()->beginTransaction();

        try {
            $this->save($user, true, static::INTENT_RESET);
            $this->dispatch(UserEvents::USER_RESET, new UserEvent($user, UserManager::INTENT_RESET));

            $this->getEntityManager()->commit();

        } catch(\Exception $e) {
            $this->getEntityManager()->rollback();
            throw new ResetAccountException('Could not initialize account reset.', 0, $e);
        }
    }


    /**
     * @param User $user
     *
     * @throws ResetAccountException
     */
    public function resetUser(User $user)
    {
        $this->updatePassword($user);
        $user->setToken(null);
        $this->getEntityManager()->beginTransaction();

        try {
            $this->save($user, true, static::INTENT_RESET);
            $this->dispatch(UserEvents::USER_RESET_DONE, new UserEvent($user, UserManager::INTENT_RESET));

            $this->getEntityManager()->commit();

        } catch(\Exception $e) {
            $this->getEntityManager()->rollback();
            throw new ResetAccountException('Could reset account.', 0, $e);
        }
    }

    /**
     * Refreshes the user for the account interface.
     *
     * It is up to the implementation to decide if the user data should be
     * totally reloaded (e.g. from the database), or if the UserInterface
     * object can just be merged into some internal array of users / identity
     * map.
     *
     * @param UserInterface $user
     *
     * @return UserInterface
     *
     * @throws UnsupportedUserException if the account is not supported
     */
    public function refreshUser(UserInterface $user)
    {
        if (!is_a($user, $this->getClassName())) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * @param array $properties
     *
     * @return User
     */
    public function createNew($properties = [])
    {
        $model = parent::createNew($properties);
        return $this->updatePassword($model);
    }

    /**
     * @param User $model
     *
     * @return User
     */
    protected function updatePassword(User $model)
    {
        if( ! $model->getPlainPassword() ) return $model;
        $encoded = $this->getEncoder()->encodePassword($model, $model->getPlainPassword());
        $model->setPassword($encoded);
        return $model;
    }

    /**
     * @param User $model
     * @param      $plainPassword
     *
     * @return string
     */
    public function encodePassword(User $model, $plainPassword)
    {
        return $this->getEncoder()->encodePassword($model, $plainPassword);
    }

    /**
     * @return object|\Symfony\Component\Security\Core\Encoder\UserPasswordEncoder
     */
    protected function getEncoder()
    {
        return $this->getContainer()->get('security.password_encoder');
    }


    /**
     * Whether this provider supports the given user class.
     *
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        return ($this->className == $class);
    }

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param $eventName
     * @param $event
     */
    protected function dispatch($eventName, $event)
    {
        $this->getContainer()->get('event_dispatcher')->dispatch($eventName, $event);
    }
}