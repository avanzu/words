<?php
/**
 * HomeController.php
 * words
 * Date: 08.01.18
 */

namespace AppBundle\Controller;


use AppBundle\Presentation\ViewHandlerTemplate;
use AppBundle\Traits\Flasher;
use AppBundle\Traits\TemplateAware;
use Components\Infrastructure\ICommandBus;
use Components\Infrastructure\Presentation\IPresenter;
use Components\Infrastructure\Presentation\TemplateView;
use Components\Interaction\Environment\GetEnvironmentRequest;
use Components\Interaction\Projects\GetProjects\GetProjectsRequest;
use Components\Interaction\Statistics\GetCompletion\GetCompletionRequest;
use Components\Interaction\Statistics\GetCompletion\GetCompletionResponse;
use Components\Interaction\Statistics\GetOverview\GetOverviewRequest;
use Components\Localization\ILocalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Intl\Intl;

class HomeController extends AbstractController implements ITemplateAware, IFlashing
{
    use TemplateAware,
        Flasher;

    /**
     * @var IPresenter
     */
    protected $presenter;

    /**
     * @var  ILocalizer
     */
    protected $localizer;

    /**
     * @var ICommandBus
     */
    protected $commandBus;

    /**
     * HomeController constructor.
     *
     * @param IPresenter  $presenter
     * @param ILocalizer  $localizer
     * @param ICommandBus $commandBus
     */
    public function __construct(
        IPresenter $presenter,
        ILocalizer $localizer,
        ICommandBus $commandBus
    ) {
        $this->presenter      = $presenter;
        $this->localizer      = $localizer;
        $this->commandBus     = $commandBus;
    }

    public function indexAction(Request $request)
    {

        $command = new GetProjectsRequest();
        $result  = $this->commandBus->execute($command);

        return $this->createResponse(
            new ViewHandlerTemplate(
                $this->getTemplate(),
                $request,
                [
                    'result' => $result,
                ]
            )
        );

    }

    public function projectIndexAction($project, Request $request)
    {
        $command = new GetOverviewRequest();
        $result  = $this->commandBus->execute($command);

        return $this->createResponse(
            new ViewHandlerTemplate(
                $this->getTemplate(),
                $request,
                [
                    'result'    => $result,
                    'project'   => $project,
                ]
            )
        );
    }

    public function completionAction($project, $locale, Request $request)
    {
        $command = new GetCompletionRequest($locale, $project);
        /** @var GetCompletionResponse $result */
        $result  = $this->commandBus->execute($command);

        return $this->createResponse(
            new ViewHandlerTemplate(
                $this->getTemplate(),
                $request,
                ['result' => $result, 'project' => $project]
            )
        );
    }


    public function environmentAction(Request $request)
    {
        $command = new GetEnvironmentRequest();
        $result = $this->commandBus->execute($command);
        return $this->createResponse(
            new ViewHandlerTemplate(
                $this->getTemplate(),
                $request,
                ['result' => $result]
            )
        );
    }

    /**
     * @param TemplateView $view
     *
     * @return Response
     */
    protected function createResponse(TemplateView $view)
    {
        $result = $this->presenter->show($view);

        return $result instanceof Response ? $result : new Response($result);
    }
}