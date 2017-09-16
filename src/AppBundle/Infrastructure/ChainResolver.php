<?php
/**
 * ChainResolver.php
 * restfully
 * Date: 16.09.17
 */

namespace AppBundle\Infrastructure;


use Components\Infrastructure\CommandHandler;
use Components\Infrastructure\CommandResolver;
use Components\Infrastructure\Exception\HandlerNotFoundException;
use Components\Infrastructure\Request\CommandRequest;

class ChainResolver implements CommandResolver
{

    /** @var CommandResolver[] */
    protected $resolvers = [];

    /**
     * ChainResolver constructor.
     *
     * @param CommandResolver[] $resolvers
     */
    public function __construct(array $resolvers = []) {
        $this->resolvers = $resolvers;
    }

    /**
     * @param CommandResolver $resolver
     * @param bool            $prepend
     */
    public function addResolver($resolver, $prepend = false)
    {
        $callback = $prepend ? 'array_unshift' : 'array_push';
        call_user_func($callback, $this->resolvers, $resolver);

    }

    /**
     * @param CommandRequest $request
     *
     * @return CommandHandler
     * @throws HandlerNotFoundException
     */
    public function getHandler(CommandRequest $request)
    {
        foreach($this->resolvers as $resolver) {
            if ($resolver = $resolver->getHandler($request)) {
                return $resolver;
            }
        }

        throw new HandlerNotFoundException();
    }
}