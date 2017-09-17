<?php
/**
 * CommandHandler.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Infrastructure\Command\Handler;


use Components\Infrastructure\Request\CommandRequest;

interface CommandHandler
{
    /**
     * @param CommandRequest $request
     *
     * @return mixed
     */
    public function handle(CommandRequest $request);
}