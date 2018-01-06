<?php

namespace AppBundle\Entity;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Components\Model\User as UserModel;

/**
 * User
 */
class User extends UserModel implements AdvancedUserInterface, \Serializable
{

    /**
     * @inheritdoc
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
                             $this->id,
                             $this->username,
                             $this->password,
                             $this->isActive
                             // see section on salt below
                             // $this->salt,
                         ));
    }

    /**
     * @see \Serializable::unserialize()
     * @inheritdoc
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->isActive
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }

}

