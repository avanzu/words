<?php
/**
 * CommandResolver.php
 * restfully
 * Date: 16.09.17
 */

namespace AppBundle\Infrastructure;
use Components\Infrastructure as Component;
use Components\Infrastructure\CommandHandler;
use Components\Infrastructure\Events\MessageSender;
use Components\Infrastructure\Exception\HandlerNotFoundException;
use Components\Infrastructure\Request\CommandRequest;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CommandResolver
 */
class CommandResolver implements Component\CommandResolver
{

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var array
     */
    protected $handlers;

    /**
     * CommandResolver constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container) { $this->container = $container; }


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
        if( $handler instanceof ContainerAwareInterface ) {
            $handler->setContainer($this->container);
        }

        if( $handler instanceof MessageSender) {
            $handler->setNotifier($this->container->get('app.notifier'));
        }

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

        if( $this->container->has($handlerName) ) {
            return $this->container->get($handlerName);
        }

        return false;

    }
}