<?php
/**
 * SimpleCommandBus.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Infrastructure;


use Components\Infrastructure\Command\Resolver\CommandHandlerResolver;
use Components\Infrastructure\Request\CommandRequest;
use Components\Infrastructure\Response\CommandResponse;
use Components\Infrastructure\Response\ErrorCommandResponse;

/**
 * Class SimpleCommandBus
 */
class SimpleCommandBus implements CommandBus
{
    /**
     * @var CommandHandlerResolver
     */
    protected $resolver;

    /**
     * @var bool
     */
    protected $throwErrors = true;

    /**
     * SimpleCommandBus constructor.
     *
     * @param CommandHandlerResolver $resolver
     */
    public function __construct(CommandHandlerResolver $resolver) {
        $this->resolver = $resolver;

    }


    /**
     * @param CommandRequest $request
     *
     * @return CommandResponse
     * @throws ErrorCommandResponse
     */
    public function execute(CommandRequest $request)
    {
        $response = $this->resolver->getHandler($request)->handle($request);
        if($response instanceof ErrorCommandResponse ) {
            throw $response;
        }

        return $response;
    }
}