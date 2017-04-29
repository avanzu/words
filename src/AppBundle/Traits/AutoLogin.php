<?php
/**
 * AutoLogin.php
 * restfully
 * Date: 29.04.17
 */

namespace AppBundle\Traits;


use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

trait AutoLogin
{
    protected function executeAutoLogin(User $user)
    {
        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $this->get('security.token_storage')->setToken($token);
        $this->get('session')->set('_security_main', serialize($token));
    }
}