<?php
/**
 * GetEnvironmentHandler.php
 * words
 * Date: 15.01.18
 */

namespace Components\Interaction\Environment;


use Components\Infrastructure\Command\Handler\ICommandHandler;
use Components\Infrastructure\Request\IRequest;
use Components\Model\Environment;
use Components\Resource\IProjectManager;
use Components\Resource\ITransUnitManager;

class GetEnvironmentHandler implements ICommandHandler
{

    /**
     * @var IProjectManager
     */
    protected $projectManager;

    /**
     * @var ITransUnitManager
     */
    protected $transUnitManager;

    /**
     * GetEnvironmentHandler constructor.
     *
     * @param IProjectManager   $projectManager
     * @param ITransUnitManager $transUnitManager
     */
    public function __construct(IProjectManager $projectManager, ITransUnitManager $transUnitManager)
    {
        $this->projectManager   = $projectManager;
        $this->transUnitManager = $transUnitManager;
    }


    /**
     * @param IRequest $request
     *
     * @return mixed
     */
    public function handle(IRequest $request)
    {

        $projects   = $this->projectManager->loadProjects();
        $catalogues = $this->transUnitManager->loadCatalogues();
        $languages  = $this->transUnitManager->loadLanguages();

        return new GetEnvironmentResponse(new Environment($projects, $catalogues, $languages));

    }
}