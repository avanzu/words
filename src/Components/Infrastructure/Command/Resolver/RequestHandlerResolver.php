<?php
/**
 * CommandResolver.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Infrastructure\Command\Resolver;

use Components\Infrastructure\Command\Handler\ICommandHandler;
use Components\Infrastructure\Exception\InvalidHandlerClassException;
use Components\Infrastructure\IContainer;
use Components\Infrastructure\Exception\HandlerNotFoundException;
use Components\Infrastructure\Request\IRequest;

/**
 * Class CommandResolver
 */
class RequestHandlerResolver implements IHandlerResolver
{

    /**
     * @var IContainer
     */
    protected $container;

    /**
     * @var array
     */
    protected $handlers;

    /**
     * CommandResolver constructor.
     *
     * @param IContainer $container
     */
    public function __construct(IContainer $container) {
        $this->container = $container;
    }

    /**
     * @param array $handlers
     */
    public function setHandlers(array $handlers = []) {
        foreach($handlers as $className => $serviceID) $this->setHandler($className, $serviceID);
    }

    /**
     * @param $className
     * @param $serviceID
     */
    public function setHandler($className, $serviceID)
    {
        $this->handlers[$className] = $serviceID;
    }

    /**
     * @param IRequest $request
     *
     * @return ICommandHandler
     * @throws HandlerNotFoundException
     */
    public function getHandler(IRequest $request)
    {
        $handlerName = $this->getHandlerName($request);
        /** @var ICommandHandler $handler */
        $handler     = $this->loadHandler($handlerName);

        if( ! $handler ) {
            $handler = $this->createHandler($handlerName);
        }

        if( ! $handler ) {
            throw new HandlerNotFoundException(sprintf('Unable to find handler for request type: %s', get_class($request)));
        }

        return $handler;

    }

    /**
     * @param IRequest $request
     *
     * @return mixed
     */
    protected function getHandlerName(IRequest $request)
    {
        return str_replace('Request', 'Handler', get_class($request));
    }

    /**
     * @param $handlerName
     *
     * @return ICommandHandler|bool
     */
    protected function createHandler($handlerName)
    {
        if( ! class_exists($handlerName) ) {
            return false;
        }

        if( ! is_a($handlerName, ICommandHandler::class, true)) {
            return false;
        }

        /** @var ICommandHandler $handler */
        $handler =  new $handlerName();


        return $handler;
    }

    /**
     * @param $handlerName
     *
     * @return bool|object
     */
    protected function loadHandler($handlerName)
    {
        if( isset($this->handlers[$handlerName]) ) {
            $handlerName = $this->handlers[$handlerName];
        }

        if( $this->container->exists($handlerName) ) {
            return $this->container->acquire($handlerName);
        }

        return false;

    }
}