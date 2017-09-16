<?php
/**
 * AuthCode.php
 * restfully
 * Date: 09.04.17
 */

namespace AppBundle\Entity\Api;

use FOS\OAuthServerBundle\Entity\AuthCode as BaseAuthCode;

/**
 */
class AuthCode extends BaseAuthCode
{

    protected $user;
}