<?php
/**
 * ProjectController.php
 * words
 * Date: 07.01.18
 */

namespace AppBundle\Controller;
use AppBundle\Form\CreateProjectRequestType;
use AppBundle\Form\UpdateProjectRequestType;
use AppBundle\Manager\ProjectManager;
use AppBundle\Presentation\ViewHandlerTemplate;
use AppBundle\Traits\TemplateAware;
use AppBundle\Traits\Flasher;
use Components\Infrastructure\Response\ErrorResponse;
use Components\Interaction\Projects\CreateProject\CreateProjectRequest;
use Components\Interaction\Projects\UpdateProject\UpdateProjectRequest;
use Components\Interaction\Resource\UpdateResource\UpdateResourceResponse;
use Components\Interaction\Statistics\ProjectStats\GetProjectStatsRequest;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ProjectController
 * @method  ProjectManager getManager()
 */
class ProjectController extends ResourceController implements ITemplateAware, IFlashing
{
    use TemplateAware,
        Flasher;


    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $command = new CreateProjectRequest();
        $form    = $this->createForm(CreateProjectRequestType::class, $command);
        $result  = $this->getInteractionResponse($form, $request, $command);
        if ($result->isSuccessful()) {

            if( $request->isXmlHttpRequest() ) {
                return $this->createResponse(
                    new ViewHandlerTemplate(
                        $this->getTemplate(),
                        $request,
                        ['result' => $result->getResource()]
                    )
                );
            }

            $this->flash($result);
            return $this->redirectToRoute('app_projects_list');
        }

        return $this->createResponse(
            new ViewHandlerTemplate(
                $this->getTemplate(),
                $request,
                ['form' => $form, 'command' => $command, 'result' => $result],
                $result->getStatus()
            ));
    }


    /**
     * @param         $slug
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateAction($slug, Request $request)
    {
        $model = $this->getManager()->loadProjectBySlug($slug);
        $this->throw404Unless($model);
        $command = new UpdateProjectRequest($model);
        $form    = $this->createForm(UpdateProjectRequestType::class, $command, [
            'method' => 'PUT',
            'csrf_protection' => (! $request->isXmlHttpRequest() )
        ]);

        /** @var UpdateResourceResponse|ErrorResponse $result */
        $result = $this->getInteractionResponse($form, $request, $command);

        if ($result->isSuccessful()) {

            if( $request->isXmlHttpRequest() ) {
                return $this->createResponse(
                    new ViewHandlerTemplate(
                        $this->getTemplate(),
                        $request,
                        ['result' => $result->getResource()]
                    )
                );
            }


            $this->flash($result);
            return $this->redirectToRoute('app_projects_list');
        }

        return $this->createResponse(
            new ViewHandlerTemplate(
                $this->getTemplate(),
                $request,
                ['form' => $form, 'command' => $command, 'result' => $result],
                $result->getStatus()
            ));
    }

    /**
     * @param         $slug
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function completionAction($slug, Request $request)
    {
        $command = new GetProjectStatsRequest($slug);
        $result  = $this->commandBus->execute($command);

        return $this->createResponse(
            new ViewHandlerTemplate(
                $this->getTemplate(),
                $request,
                ['result' => $result]
            )
        );
    }

    public function showAction($slug, Request $request)
    {
        $model = $this->getManager()->loadProjectBySlug($slug);
        $this->throw404Unless($model);
        return $this->createResponse(
            new ViewHandlerTemplate(
                $this->getTemplate(),
                $request,
                ['result' => $model]
            )
        );
    }

}