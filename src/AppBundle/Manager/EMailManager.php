<?php
/**
 * EMailManager.php
 * restfully
 * Date: 29.04.17
 */

namespace AppBundle\Manager;


use AppBundle\Entity\User;

class EMailManager
{

    /**
     * @var \Twig_Environment
     */
    protected $engine;

    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var string
     */
    protected $from;

    /**
     * @var string
     */
    protected $appName;

    /**
     * EMailManager constructor.
     *
     * @param \Twig_Environment $engine
     * @param \Swift_Mailer     $mailer
     * @param string            $from
     */
    public function __construct(\Twig_Environment $engine, \Swift_Mailer $mailer, $from, $appName)
    {
        $this->engine  = $engine;
        $this->mailer  = $mailer;
        $this->from    = $from;
        $this->appName = $appName;
    }

    protected function buildMessage($template, $context)
    {
        $template  = $this->engine->load($template);
        $subject   = $template->renderBlock('subject', $context);
        $bodyHtml  = $template->renderBlock('body_html', $context);
        $bodyPlain = $template->renderBlock('body_plain', $context);

        $message   = \Swift_Message::newInstance();
        $message
            ->setSubject($subject)
            ->setBody($bodyPlain)
            ->addPart($bodyHtml, 'text/html')
            ->setFrom($this->from);

        return $message;
    }

    /**
     * @param User $user
     */
    public function sendRegistrationMail(User $user)
    {
        $message = $this->buildMessage('@App/EMail/register.html.twig', ['user' => $user, 'appName' => $this->appName]);
        $message->setTo($user->getEMail());

        $this->mailer->send($message);
    }

    /**
     * @param User $user
     */
    public function sendResetMail(User $user)
    {
        $message = $this->buildMessage('@App/EMail/reset.html.twig', ['user' => $user, 'appName' => $this->appName]);
        $message->setTo($user->getEMail());
        $this->mailer->send($message);
    }


}