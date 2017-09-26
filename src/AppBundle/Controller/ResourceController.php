<?php
/**
 * ResourceController.php
 * restfully
 * Date: 29.04.17
 */

namespace AppBundle\Controller;


use Components\Infrastructure\Controller\ICommandRunner;
use Components\Infrastructure\Presentation\IPresenter;
use Components\Infrastructure\Presentation\TemplateView;
use Components\Localization\ILocalizer;
use Components\Resource\IManager;
use Components\Infrastructure\Request\IRequest;
use Components\Infrastructure\Response\IResponse;
use Components\Infrastructure\Response\ContinueCommandResponse;
use Components\Infrastructure\Response\ErrorResponse;
use Components\Interaction\Resource\GetCollection\GetCollectionRequest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ResourceController
 */
class ResourceController extends Controller implements ICommandRunner, IPresenter
{

    /**
     * @var IManager
     */
    protected $manager;

    /**
     * @var IPresenter
     */
    protected $presenter;
    /**
     * @var ILocalizer
     */
    private $localizer;

    /**
     * ResourceController constructor.
     *
     * @param IManager   $manager
     * @param IPresenter $presenter
     * @param ILocalizer $localizer
     */
    public function __construct(IManager $manager, IPresenter $presenter, ILocalizer $localizer) {
        $this->manager   = $manager;
        $this->presenter = $presenter;
        $this->localizer = $localizer;
    }

    /**
     * @return IPresenter
     */
    public function getPresenter()
    {
        return $this->presenter;
    }

    /**
     * @return IManager
     */
    protected function getManager()
    {
        return $this->manager;
    }


    /**
     * @param TemplateView $view
     *
     * @return Response
     */
    protected function createResponse(TemplateView $view)
    {
        return new Response($this->getPresenter()->show($view));
    }




    /**
     * @param         $resource
     * @param Request $request
     *
     * @return Response
     */
    public function getCollectionAction($resource, Request $request)
    {
        $command = new GetCollectionRequest(
            null,
            $resource,
            $request->get('limit', 10),
            $request->get('offset')
        );

        $result = $this->executeCommand($command);
        return new Response($this->get('serializer')->serialize($result, 'json'));

    }




    /**
     * @param        $condition
     * @param string $message
     *
     * @return mixed
     */
    protected function throw404Unless($condition, $message = 'Not Found')
    {
        if( ! $condition ) {
            throw $this->createNotFoundException($message);
        }

        return $condition;
    }


    /**
     * @param Request $request
     * @param Form    $form
     * @param         $model
     * @param null    $intent
     *
     * @return bool
     */
    protected function handleForm(Request $request, Form $form, $model = null, $intent = null)
    {
        $form->handleRequest($request);

        if( ! $form->isSubmitted() ) {
            return false;
        }

        if( ! $form->isValid() ) {
            return false;
        }

        return true;
    }

    /**
     * @param         $model
     * @param Request $request
     * @param null    $intent
     */
    protected function preSaveModel($model, Request $request, $intent = null)
    {}

    /**
     * @param         $model
     * @param Request $request
     * @param null    $intent
     */
    protected function postSaveModel($model, Request $request, $intent = null)
    {}


    /**
     * @param Form             $form
     * @param IRequest|Request $request
     * @param IRequest         $command
     *
     * @return IResponse
     */
    protected function getInteractionResponse(Form $form, Request $request, IRequest $command)
    {
        $form->handleRequest($request);

        if( ! $form->isSubmitted() ) {
            return new ContinueCommandResponse();
        }

        return $this->executeCommand($form->getData());

    }

    /**
     * @param IRequest $request
     *
     * @return IResponse|ErrorResponse|\Exception
     */
    public function executeCommand(IRequest $request)
    {
        try {
            return $this->get('app.command_bus')->execute($request);
        }  catch(ErrorResponse $error) {
            return $error;
        }
    }

    /**
     * @param TemplateView $view
     *
     * @return string
     */
    public function show(TemplateView $view)
    {
        return $this->getPresenter()->show($view);
    }
}