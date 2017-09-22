<?php
/**
 * CommandHandler.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Infrastructure\Command\Handler;


use Components\Infrastructure\Request\IRequest;

interface ICommandHandler
{
    /**
     * @param IRequest $request
     *
     * @return mixed
     */
    public function handle(IRequest $request);
}