<?php
/**
 * GetProjectStatsHandler.php
 * words
 * Date: 20.01.18
 */

namespace Components\Interaction\Statistics\ProjectStats;


use Components\Infrastructure\Command\Handler\ICommandHandler;
use Components\Infrastructure\Request\IRequest;
use Components\Model\Completion;
use Components\Resource\ITransUnitManager;

class GetProjectStatsHandler implements ICommandHandler
{

    /**
     * @var  ITransUnitManager
     */
    protected $transUnitManager;

    /**
     * GetProjectStatsHandler constructor.
     *
     * @param ITransUnitManager $transUnitManager
     */
    public function __construct(ITransUnitManager $transUnitManager) {
        $this->transUnitManager = $transUnitManager;
    }


    /**
     * @param IRequest|GetProjectStatsRequest $request
     *
     * @return mixed
     */
    public function handle(IRequest $request)
    {
        $languages  = $this->transUnitManager->loadLanguages();
        return new GetProjectStatsResponse($this->createResult($languages, $request->getProject()));
    }

    protected function createResult($languages, $project)
    {
        foreach ($languages as $language){
            yield from $this->transUnitManager->getCompletion($language, $project);
        }
    }
}