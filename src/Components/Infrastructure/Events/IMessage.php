<?php
/**
 * Message.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Infrastructure\Events;


use Components\Infrastructure\Request\IRequest;
use Components\Infrastructure\Response\IResponse;

interface IMessage
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return IRequest
     */
    public function getRequest();

    /**
     * @return IResponse
     */
    public function getResponse();

}