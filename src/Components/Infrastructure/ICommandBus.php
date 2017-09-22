<?php
/**
 * CommandBus.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Infrastructure;


use Components\Infrastructure\Request\IRequest;
use Components\Infrastructure\Response\IResponse;

interface ICommandBus
{
    /**
     * @param IRequest $request
     *
     * @return IResponse
     */
    public function execute(IRequest $request);
}