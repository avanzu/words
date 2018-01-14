<?php
/**
 * IUserManager.php
 * restfully
 * Date: 08.04.17
 */

namespace AppBundle\Manager;


use AppBundle\Repository\UserRepository;
use Components\Model\User;
use Components\Model\UserProfile;
use Components\Resource\IUserManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Class IUserManager
 * @method UserRepository getRepository
 */
class UserManager extends ResourceManager implements UserProviderInterface, ContainerAwareInterface, IUserManager
{

    const INTENT_REGISTER = 'register';

    const INTENT_RESET = 'reset';

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
        if (!$user) {
            throw new UsernameNotFoundException();
        }

        return $user;
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
        return $this->getRepository()->findOneBy(['token' => $token]);
    }


    /**
     * @param User $model
     *
     * @return User
     */
    protected function updatePassword(User $model)
    {
        if (!$model->getPlainPassword()) {
            return $model;
        }
        $encoded = $this->getEncoder()->encodePassword($model, $model->getPlainPassword());
        $model->setPassword($encoded);

        return $model;
    }

    /**
     * @return object|\Symfony\Component\Security\Core\Encoder\UserPasswordEncoder
     */
    protected function getEncoder()
    {
        return $this->getContainer()->get('security.password_encoder');
    }    /**
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
     * {@inheritdoc}
     */
    public function loadUserProfile(User $model)
    {
        return $this->getRepository()->fetchUserProfile($model);
    }


    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
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
     * @param $eventName
     * @param $event
     */
    protected function dispatch($eventName, $event)
    {
        $this->getContainer()->get('event_dispatcher')->dispatch($eventName, $event);
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
    }    /**
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






}