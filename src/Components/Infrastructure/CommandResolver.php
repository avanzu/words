<?php
/**
 * CommandResolver.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Infrastructure;


use Components\Infrastructure\Request\CommandRequest;

interface CommandResolver
{
    /**
     * @param CommandRequest $request
     *
     * @return CommandHandler
     *
     */
    public function getHandler(CommandRequest $request);
}