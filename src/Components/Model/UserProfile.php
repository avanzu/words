<?php
/**
 * UserProfile.php
 * words
 * Date: 14.01.18
 */

namespace Components\Model;


class UserProfile
{
    protected $username;
    protected $email;
    protected $gender;
    protected $firstName;
    protected $lastName;
    protected $avatar;
    private   $id;

    /**
     * UserProfile constructor.
     *
     * @param        $id
     * @param        $username
     * @param        $email
     * @param string $gender
     * @param string $firstName
     * @param string $lastName
     * @param string $avatar
     */
    public function __construct($id, $username, $email, $gender = '', $firstName = '', $lastName = '', $avatar = '')
    {
        $this->username  = $username;
        $this->email     = $email;
        $this->gender    = $gender;
        $this->firstName = $firstName;
        $this->lastName  = $lastName;
        $this->avatar    = $avatar;
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

}