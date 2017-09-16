<?php
/**
 * CommandBus.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Infrastructure;


use Components\Infrastructure\Request\CommandRequest;
use Components\Infrastructure\Response\CommandResponse;

interface CommandBus
{
    /**
     * @param CommandRequest $request
     *
     * @return CommandResponse
     */
    public function execute(CommandRequest $request);
}