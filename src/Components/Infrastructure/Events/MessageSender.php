<?php
/**
 * MessageSender.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Infrastructure\Events;


interface MessageSender
{
    public function setNotifier(Notifier $notifier);
}