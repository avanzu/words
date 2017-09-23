<?php
/**
 * ResourceHandlerResolver.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Infrastructure\Command\Resolver;


use Components\Infrastructure\Command\Handler\ICommandHandler;
use Components\Infrastructure\Exception\InvalidHandlerClassException;
use Components\Infrastructure\Request\IRequest;
use Components\Interaction\Resource\ResourceHandler;
use Components\Interaction\Resource\ResourceRequest;
use Components\Resource\IManager;

/**
 * Class ResourceHandlerResolver
 */
class ResourceHandlerResolver extends RequestHandlerResolver
{
    /**
     * @param IRequest $request
     *
     * @return bool|mixed
     */
    protected function getHandlerName(IRequest $request)
    {
        $className = parent::getHandlerName($request);
        if( class_exists($className) ) return $className;

        $parentClass = get_parent_class($request);
        $className   = str_replace('Request', 'Handler', $parentClass);

        if( class_exists($className) ) return $className;
        return false;

    }

    /**
     * @param IRequest $request
     *
     * @return ICommandHandler
     */
    public function getHandler(IRequest $request)
    {
            $handler = parent::getHandler($request);
            return $this->configure($handler, $request);

    }


    /**
     * @param ICommandHandler|ResourceHandler $handler
     * @param IRequest|ResourceRequest         $request
     *
     * @return ICommandHandler
     */
    protected function configure(ICommandHandler $handler, IRequest $request)
    {
        if( !($request instanceof ResourceRequest) ) {
            return $handler;
        }

        if( ! ($handler instanceof ResourceHandler) ) {
            return $handler;
        }

        $handler->setManager($this->getResourceManager($request));

        return $handler;

    }

    /**
     * @param ResourceRequest $request
     *
     * @return IManager
     */
    protected function getResourceManager(ResourceRequest $request)
    {
        /** @var IManager $manager */
        $manager = $this->container->acquire(sprintf('app.manager.%s', $request->getResourceName()));
        return $manager;
    }


}