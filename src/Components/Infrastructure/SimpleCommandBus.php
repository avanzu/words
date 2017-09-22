<?php
/**
 * SimpleCommandBus.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Infrastructure;


use Components\Infrastructure\Command\Resolver\IHandlerResolver;
use Components\Infrastructure\Request\IRequest;
use Components\Infrastructure\Response\IResponse;
use Components\Infrastructure\Response\ErrorResponse;

/**
 * Class SimpleCommandBus
 */
class SimpleCommandBus implements ICommandBus
{
    /**
     * @var IHandlerResolver
     */
    protected $resolver;

    /**
     * @var bool
     */
    protected $throwErrors = true;

    /**
     * SimpleCommandBus constructor.
     *
     * @param IHandlerResolver $resolver
     */
    public function __construct(IHandlerResolver $resolver) {
        $this->resolver = $resolver;

    }


    /**
     * @param IRequest $request
     *
     * @return IResponse
     * @throws ErrorResponse
     */
    public function execute(IRequest $request)
    {
        $response = $this->resolver->getHandler($request)->handle($request);
        if($response instanceof ErrorResponse ) {
            throw $response;
        }

        return $response;
    }
}