<?php
/**
 * ProjectController.php
 * words
 * Date: 07.01.18
 */

namespace AppBundle\Controller;
use AppBundle\Form\CreateProjectRequestType;
use AppBundle\Presentation\ViewHandlerTemplate;
use AppBundle\Traits\TemplateAware;
use AppBundle\Traits\Flasher;
use Components\Infrastructure\Presentation\TemplateView;
use Components\Interaction\Projects\CreateProject\CreateProjectRequest;
use Symfony\Component\HttpFoundation\Request;

class ProjectController extends ResourceController implements ITemplateAware, IFlashing
{
    use TemplateAware,
        Flasher;


    public function createAction(Request $request)
    {
        $command = new CreateProjectRequest();
        $form    = $this->createForm(CreateProjectRequestType::class, $command);
        $result  = $this->getInteractionResponse($form, $request, $command);
        if ($result->isSuccessful()) {
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


}