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
     * GetOverviewHandler constructor.
     *
     * @param ITransUnitManager $transUnitManager
     */
    public function __construct(ITransUnitManager $transUnitManager)
    {
        $this->transUnitManager = $transUnitManager;
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

        return new GetOverviewResponse($languages, $catalogues);
    }
}