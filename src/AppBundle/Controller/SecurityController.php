<?php
/**
 * SecurityController.php
 * restfully
 * Date: 09.04.17
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController implements ITemplateAware
{
    /**
     * @var AuthenticationUtils
     */
    protected $authUtils;

    /**
     * @var EngineInterface
     */
    protected $engine;

    /**
     * @var string
     */
    protected $template = '@App/Security/login.html.twig';

    /**
     * SecurityController constructor.
     *
     * @param AuthenticationUtils $authUtils
     * @param EngineInterface     $engine
     */
    public function __construct(AuthenticationUtils $authUtils, EngineInterface $engine)
    {
        $this->authUtils = $authUtils;
        $this->engine    = $engine;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param string $template
     *
     * @return $this
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction()
    {
        $authenticationUtils = $this->authUtils;

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->engine->renderResponse($this->getTemplate(), array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }
}