<?php
/**
 * ICommandRunner.php
 * restfully
 * Date: 22.09.17
 */

namespace Components\Infrastructure\Controller;


use Components\Infrastructure\Request\IRequest;
use Components\Infrastructure\Response\IResponse;

interface ICommandRunner
{
    /**
     * @param IRequest $request
     *
     * @return IResponse
     */
    public function executeCommand(IRequest $request);

}