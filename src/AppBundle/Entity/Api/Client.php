<?php
/**
 * Client.php
 * restfully
 * Date: 09.04.17
 */

namespace AppBundle\Entity\Api;
use FOS\OAuthServerBundle\Entity\Client as BaseClient;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Client
 */
class Client extends BaseClient
{


    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $allowedGrantTypes = array();

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

}