<?php
/**
 * Message.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Infrastructure\Events;


use Components\Infrastructure\Request\CommandRequest;
use Components\Infrastructure\Response\CommandResponse;

interface Message
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return CommandRequest
     */
    public function getRequest();

    /**
     * @return CommandResponse
     */
    public function getResponse();

}