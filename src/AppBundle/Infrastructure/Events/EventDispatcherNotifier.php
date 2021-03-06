<?php
/**
 * EventDispatcherNotifier.php
 * restfully
 * Date: 16.09.17
 */

namespace AppBundle\Infrastructure\Events;


use Components\Infrastructure\Events\IMessage;
use Components\Infrastructure\Events\INotifier;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class EventDispatcherNotifier implements INotifier
{

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * EventDispatcherNotifier constructor.
     *
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EventDispatcherInterface $eventDispatcher) {
        $this->eventDispatcher = $eventDispatcher;
    }


    public function notify(IMessage $message)
    {
        $this->eventDispatcher->dispatch($message->getName(), new MessageEvent($message));
    }

}