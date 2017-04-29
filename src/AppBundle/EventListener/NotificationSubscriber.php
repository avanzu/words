<?php
/**
 * UserEventSubscriber.php
 * restfully
 * Date: 29.04.17
 */

namespace AppBundle\EventListener;


use AppBundle\Event\UserEvent;
use AppBundle\Event\UserEvents;
use AppBundle\Manager\EMailManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class NotificationSubscriber implements EventSubscriberInterface
{

    /**
     * @var EMailManager
     */
    protected $mailManager;

    /**
     * NotificationSubscriber constructor.
     *
     * @param EMailManager $mailManager
     */
    public function __construct(EMailManager $mailManager) {
        $this->mailManager = $mailManager;
    }


    /**
     * @param UserEvent $event
     */
    public function onUserRegisterDone(UserEvent $event)
    {
        $this->mailManager->sendRegistrationMail($event->getModel());
    }

    public function onUserActivateDone(UserEvent $event)
    {

    }

    public function onUserResetDone(UserEvent $event)
    {

    }

    /**
     * @param UserEvent $event
     */
    public function onUserReset(UserEvent $event)
    {
        $this->mailManager->sendResetMail($event->getModel());
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return array(
            UserEvents::USER_REGISTER_DONE => 'onUserRegisterDone',
            UserEvents::USER_ACTIVATE_DONE => 'onUserActivateDone',
            UserEvents::USER_RESET         => 'onUserReset',
            UserEvents::USER_RESET_DONE    => 'onUserResetDone',
        );
    }
}