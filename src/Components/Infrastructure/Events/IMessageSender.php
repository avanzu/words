<?php
/**
 * MessageSender.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Infrastructure\Events;


interface IMessageSender
{
    public function setNotifier(INotifier $notifier);
}