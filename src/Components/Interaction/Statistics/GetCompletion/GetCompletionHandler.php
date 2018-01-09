<?php
/**
 * GetCompletionHandler.php
 * words
 * Date: 09.01.18
 */

namespace Components\Interaction\Statistics\GetCompletion;


use Components\Infrastructure\Command\Handler\ICommandHandler;
use Components\Infrastructure\Request\IRequest;
use Components\Resource\ITransUnitManager;

class GetCompletionHandler implements ICommandHandler
{
    /**
     * @var  ITransUnitManager
     */
    protected $manager;

    /**
     * GetCompletionHandler constructor.
     *
     * @param ITransUnitManager $manager
     */
    public function __construct(ITransUnitManager $manager) {
        $this->manager = $manager;
    }

    /**
     * @param IRequest|GetCompletionRequest $request
     *
     * @return GetCompletionResponse
     */
    public function handle(IRequest $request)
    {
        $completion = $this->manager->getCompletion($request->getLocale(), $request->getCatalogue(), $request->getProject());

        return new GetCompletionResponse($completion);
    }
}