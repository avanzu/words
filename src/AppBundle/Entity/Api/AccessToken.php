<?php
/**
 * AccessToken.php
 * restfully
 * Date: 09.04.17
 */

namespace AppBundle\Entity\Api;


use FOS\OAuthServerBundle\Entity\AccessToken as BaseAccessToken;

/**
 */
class AccessToken extends BaseAccessToken
{

    protected $user;
}