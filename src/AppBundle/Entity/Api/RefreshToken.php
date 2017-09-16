<?php
/**
 * RefreshToken.php
 * restfully
 * Date: 09.04.17
 */

namespace AppBundle\Entity\Api;

use FOS\OAuthServerBundle\Entity\RefreshToken as BaseRefreshToken;

/**
 */
class RefreshToken extends BaseRefreshToken
{

    protected $user;
}