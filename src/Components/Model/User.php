<?php
/**
 * User.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Model;

/**
 * User
 */
class User
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     *
     */
    protected $username;

    /**
     * @var string
     *
     */
    protected $email;

    /**
     * @var string
     *
     */
    protected $password;


    /**
     */
    protected $isActive = false;

    /**
     * @var string
     */
    protected $plainPassword;

    /**
     * @var array
     *
     */
    protected $roles;

    /**
     * @var string
     */
    protected $token;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->roles = ['ROLE_USER'];
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param mixed $isActive
     *
     * @return $this
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

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
     * @param string $plainPassword
     *
     * @return $this
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }


    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @param array $roles
     *
     * @return $this
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     *
     */
    public function eraseCredentials()
    {
    }

    /** @inheritdoc */
    public function isAccountNonExpired()
    {
        return true;
    }

    /** @inheritdoc */
    public function isAccountNonLocked()
    {
        return true;
    }

    /** @inheritdoc */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /** @inheritdoc */
    public function isEnabled()
    {
        return $this->isActive;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     *
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

}