<?php
/**
 * UserManager.php
 * restfully
 * Date: 08.04.17
 */

namespace AppBundle\Manager;


use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
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
        return $this->encodePassword($model);
    }

    /**
     * @param User $model
     *
     * @return User
     */
    protected function encodePassword(User $model)
    {
        if( ! $model->getPlainPassword() ) return $model;
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

}