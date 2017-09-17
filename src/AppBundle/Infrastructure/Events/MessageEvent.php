<?php
/**
 * MessageEvent.php
 * restfully
 * Date: 16.09.17
 */

namespace AppBundle\Infrastructure\Events;


use Components\Infrastructure\Events\Message;
use Symfony\Component\EventDispatcher\Event;

class MessageEvent extends Event
{
    protected $message;

    /**
     * MessageEvent constructor.
     *
     * @param $message
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * @return Message
     */
    public function getMessage()
    {
        return $this->message;
    }

    public function getRequest()
    {
        return $this->message->getRequest();
    }

    public function getResponse()
    {
        return $this->message->getResponse();
    }
}