<?php
/**
 * Client.php
 * restfully
 * Date: 09.04.17
 */

namespace AppBundle\Entity\Api;
use FOS\OAuthServerBundle\Entity\Client as BaseClient;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity as AssertUnique;

/**
 * Class Client
 * @ORM\Entity
 * @AssertUnique({"name"})
 */
class Client extends BaseClient
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column()
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @var array
     * @Assert\All({
     *  @Assert\Regex("#^(authorization_code|token|password|client_credentials|refresh_token|https?://.+|urn:.+)$#")
     * })
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