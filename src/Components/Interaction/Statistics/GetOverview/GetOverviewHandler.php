<?php
/**
 * GetOverviewHandler.phpp
 * words
 * Date: 09.01.18
 */

namespace Components\Interaction\Statistics\GetOverview;


use Components\Infrastructure\Command\Handler\ICommandHandler;
use Components\Infrastructure\Request\IRequest;
use Components\Resource\IProjectManager;
use Components\Resource\ITransUnitManager;

class GetOverviewHandler implements ICommandHandler
{

    /**
     * @var ITransUnitManager
     */
    protected $transUnitManager;

    /**
     * @var IProjectManager
     */
    protected $projectManager;

    /**
     * GetOverviewHandler constructor.
     *
     * @param ITransUnitManager $transUnitManager
     * @param IProjectManager   $projectManager
     */
    public function __construct(ITransUnitManager $transUnitManager, IProjectManager $projectManager)
    {
        $this->transUnitManager = $transUnitManager;
        $this->projectManager   = $projectManager;
    }


    /**
     * @param IRequest|GetOverviewRequest $request
     *
     * @return GetOverviewResponse
     */
    public function handle(IRequest $request)
    {
        $languages  = $this->transUnitManager->loadLanguages();
        $catalogues = $this->transUnitManager->loadCatalogues();
        $projects   = $this->projectManager->loadProjects();

        return new GetOverviewResponse($languages, $catalogues, $projects);
    }
}