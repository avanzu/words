<?php
/**
 * CommandResolver.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Infrastructure\Command\Resolver;


use Components\Infrastructure\Command\Handler\CommandHandler;
use Components\Infrastructure\Request\CommandRequest;

interface CommandHandlerResolver
{
    /**
     * @param CommandRequest $request
     *
     * @return CommandHandler
     *
     */
    public function getHandler(CommandRequest $request);
}