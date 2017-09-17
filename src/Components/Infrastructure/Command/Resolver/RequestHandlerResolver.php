<?php
/**
 * CommandResolver.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Infrastructure\Command\Resolver;

use Components\Infrastructure\Command\Handler\CommandHandler;
use Components\Infrastructure\Container;
use Components\Infrastructure\Exception\HandlerNotFoundException;
use Components\Infrastructure\Request\CommandRequest;

/**
 * Class CommandResolver
 */
class RequestHandlerResolver implements CommandHandlerResolver
{

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var array
     */
    protected $handlers;

    /**
     * CommandResolver constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container) {
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
     * @param CommandRequest $request
     *
     * @return CommandHandler
     * @throws HandlerNotFoundException
     */
    public function getHandler(CommandRequest $request)
    {
        $handlerName = $this->getHandlerName($request);
        /** @var CommandHandler $handler */
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
     * @param CommandRequest $request
     *
     * @return mixed
     */
    protected function getHandlerName(CommandRequest $request)
    {
        return str_replace('Request', 'Handler', get_class($request));
    }

    /**
     * @param $handlerName
     *
     * @return CommandHandler|bool
     */
    protected function createHandler($handlerName)
    {
        if( ! class_exists($handlerName) ) {
            return false;
        }

        /** @var CommandHandler $handler */
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