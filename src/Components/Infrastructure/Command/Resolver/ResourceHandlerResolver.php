<?php
/**
 * ResourceHandlerResolver.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Infrastructure\Command\Resolver;


use Components\Infrastructure\Command\Handler\CommandHandler;
use Components\Infrastructure\Request\CommandRequest;
use Components\Interaction\Resource\ResourceHandler;
use Components\Interaction\Resource\ResourceCommandRequest;
use Components\Resource\Manager;

class ResourceHandlerResolver extends RequestHandlerResolver
{
    protected function getHandlerName(CommandRequest $request)
    {
        $className = parent::getHandlerName($request);
        if( class_exists($className) ) return $className;

        $parentClass = get_parent_class($request);
        $className   = str_replace('Request', 'Handler', $parentClass);

        if( class_exists($className) ) return $className;
        return false;

    }

    /**
     * @param CommandRequest $request
     *
     * @return CommandHandler
     */
    public function getHandler(CommandRequest $request)
    {
        return $this->configure(parent::getHandler($request), $request);
    }


    /**
     * @param CommandHandler|ResourceHandler        $handler
     * @param CommandRequest|ResourceCommandRequest $request
     *
     * @return CommandHandler
     */
    protected function configure(CommandHandler $handler, CommandRequest $request)
    {
        if( !($request instanceof ResourceCommandRequest) ) {
            return $handler;
        }

        if( ! ($handler instanceof ResourceHandler) ) {
            return $handler;
        }

        $handler->setManager($this->getResourceManager($request));

        return $handler;

    }

    /**
     * @param ResourceCommandRequest $request
     *
     * @return Manager
     */
    protected function getResourceManager(ResourceCommandRequest $request)
    {
        /** @var Manager $manager */
        $manager = $this->container->acquire(sprintf('app.manager.%s', $request->getResourceName()));
        return $manager;
    }


}