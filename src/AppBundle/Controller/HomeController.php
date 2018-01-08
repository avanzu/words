<?php
/**
 * HomeController.php
 * words
 * Date: 08.01.18
 */

namespace AppBundle\Controller;


use AppBundle\Manager\ProjectManager;
use AppBundle\Presentation\ViewHandlerTemplate;
use AppBundle\Traits\Flasher;
use AppBundle\Traits\TemplateAware;
use Components\Infrastructure\Presentation\IPresenter;
use Components\Infrastructure\Presentation\TemplateView;
use Components\Localization\ILocalizer;
use Components\Resource\ITransUnitManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
     * @var ITransUnitManager
     */
    protected $manager;
    /**
     * @var ProjectManager
     */
    private $projectManager;

    /**
     * HomeController constructor.
     *
     * @param IPresenter        $presenter
     * @param ILocalizer        $localizer
     * @param ITransUnitManager $manager
     * @param ProjectManager    $projectManager
     */
    public function __construct(IPresenter $presenter, ILocalizer $localizer, ITransUnitManager $manager, ProjectManager $projectManager)
    {
        $this->presenter = $presenter;
        $this->localizer = $localizer;
        $this->manager   = $manager;
        $this->projectManager = $projectManager;
    }

    /**
     * @param TemplateView $view
     *
     * @return Response
     */
    protected function createResponse(TemplateView $view)
    {
        $result = $this->presenter->show($view);
        return  $result instanceof Response ? $result : new Response($result);
    }


    public function indexAction(Request $request)
    {

        $languages  = $this->manager->loadLanguages();
        $catalogues = $this->manager->loadCatalogues();
        $projects   = $this->projectManager->loadProjects();

        return $this->createResponse(
            new ViewHandlerTemplate(
                $this->getTemplate(),
                $request,
                [ 'languages' => $languages, 'catalogues' => $catalogues, 'projects' => $projects ]
            )
        );
    }
}