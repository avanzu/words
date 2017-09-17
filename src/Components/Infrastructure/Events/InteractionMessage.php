<?php
/**
 * InteractionMessage.php
 * restfully
 * Date: 17.09.17
 */

namespace Components\Infrastructure\Events;


use Components\Infrastructure\Request\CommandRequest;
use Components\Infrastructure\Response\CommandResponse;

/**
 * Class InteractionMessage
 */
class InteractionMessage implements Message
{
    /**
     * @var CommandRequest
     */
    protected $request;
    /**
     * @var CommandResponse
     */
    protected $response;
    /**
     * @var string
     */
    protected $name;

    /**
     * InteractionMessage constructor.
     *
     * @param                 $name
     * @param CommandRequest  $request
     * @param CommandResponse $response
     */
    public function __construct($name, CommandRequest $request, CommandResponse $response = null)
    {
        $this->request  = $request;
        $this->response = $response;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return CommandRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return CommandResponse
     */
    public function getResponse()
    {
        return $this->response;
    }

}