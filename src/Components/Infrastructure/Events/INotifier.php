<?php
/**
 * Notifier.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Infrastructure\Events;


interface INotifier
{
    public function notify(IMessage $message);
}