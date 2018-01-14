<?php
/**
 * Profile.php
 * words
 * Date: 14.01.18
 */

namespace AppBundle\Entity;

use Components\Model\Profile as ProfileModel;


class Profile extends ProfileModel
{

    /**
     * @var int
     */
    protected $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Profile constructor.
     *
     * @param User|null $user
     */
    public function __construct(User $user = null) {
        $this->user = $user;
    }
}