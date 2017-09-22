<?php
/**
 * InteractionMessage.php
 * restfully
 * Date: 17.09.17
 */

namespace Components\Infrastructure\Events;


use Components\Infrastructure\Request\IRequest;
use Components\Infrastructure\Response\IResponse;

/**
 * Class InteractionMessage
 */
class InteractionMessage implements IMessage
{
    /**
     * @var IRequest
     */
    protected $request;
    /**
     * @var IResponse
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
     * @param IRequest        $request
     * @param IResponse       $response
     */
    public function __construct($name, IRequest $request, IResponse $response = null)
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
     * @return IRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return IResponse
     */
    public function getResponse()
    {
        return $this->response;
    }

}