<?php
/**
 * CommandResolver.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Infrastructure\Command\Resolver;


use Components\Infrastructure\Command\Handler\ICommandHandler;
use Components\Infrastructure\Request\IRequest;

interface IHandlerResolver
{
    /**
     * @param IRequest $request
     *
     * @return ICommandHandler
     *
     */
    public function getHandler(IRequest $request);
}