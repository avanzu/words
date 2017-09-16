<?php
/**
 * Notifier.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Infrastructure\Events;


interface Notifier
{
    public function notify(Message $message);
}