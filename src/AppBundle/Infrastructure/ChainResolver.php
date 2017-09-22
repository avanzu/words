<?php
/**
 * ChainResolver.php
 * restfully
 * Date: 16.09.17
 */

namespace AppBundle\Infrastructure;


use Components\Infrastructure\Command\Handler\ICommandHandler;
use Components\Infrastructure\Command;
use Components\Infrastructure\Command\Resolver\IHandlerResolver;
use Components\Infrastructure\Exception\HandlerNotFoundException;
use Components\Infrastructure\Request\IRequest;

class ChainResolver implements IHandlerResolver
{

    /** @var IHandlerResolver[] */
    protected $resolvers = [];

    /**
     * ChainResolver constructor.
     *
     * @param IHandlerResolver[] $resolvers
     */
    public function __construct(array $resolvers = []) {
        $this->resolvers = $resolvers;
    }

    /**
     * @param IHandlerResolver $resolver
     * @param bool                   $prepend
     */
    public function addResolver($resolver, $prepend = false)
    {
        $callback = $prepend ? 'array_unshift' : 'array_push';
        call_user_func($callback, $this->resolvers, $resolver);

    }

    /**
     * @param IRequest $request
     *
     * @return ICommandHandler
     * @throws HandlerNotFoundException
     */
    public function getHandler(IRequest $request)
    {
        foreach($this->resolvers as $resolver) {
            if ($resolver = $resolver->getHandler($request)) {
                return $resolver;
            }
        }

        throw new HandlerNotFoundException();
    }
}