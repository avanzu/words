<?php
/**
 * SimpleCommandBus.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Infrastructure;


use Components\Infrastructure\Request\CommandRequest;
use Components\Infrastructure\Response\CommandResponse;
use Components\Infrastructure\Response\ErrorCommandResponse;

class SimpleCommandBus implements CommandBus
{
    /**
     * @var CommandResolver
     */
    protected $resolver;

    protected $throwErrors = true;

    /**
     * SimpleCommandBus constructor.
     *
     * @param CommandResolver $resolver
     */
    public function __construct(CommandResolver $resolver) {
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