<?php
/**
 * TransUnitController.php
 * words
 * Date: 07.01.18
 */

namespace AppBundle\Controller;


use AppBundle\Form\CreateTranslationRequestType;
use AppBundle\Form\UpdateTranslationRequestType;
use AppBundle\Presentation\ViewHandlerTemplate;
use AppBundle\Traits\Flasher;
use AppBundle\Traits\TemplateAware;
use Components\Interaction\Translations\CreateTranslation\CreateTranslationRequest;
use Components\Interaction\Translations\UpdateTranslation\UpdateTranslationRequest;
use Symfony\Component\HttpFoundation\Request;

class TransUnitController extends ResourceController implements ITemplateAware, IFlashing
{
    use TemplateAware,
        Flasher;


    public function indexAction($project, Request $request)
    {

        return $this->createResponse(
            new ViewHandlerTemplate(
                $this->getTemplate(),
                $request,
                []
            )
        )
            ;
    }

    public function createAction(Request $request)
    {
        $command = new CreateTranslationRequest();
        $form    = $this->createForm(CreateTranslationRequestType::class, $command);
        $result  = $this->getInteractionResponse($form, $request, $command);
        if ($result->isSuccessful()) {
            $this->flash($result);
            return $this->redirectToRoute('app_translations_list');
        }

        return $this->createResponse(
            new ViewHandlerTemplate(
                $this->getTemplate(),
                $request,
                ['form' => $form, 'command' => $command, 'result' => $result],
                $result->getStatus()
            ));
    }



    public function updateAction($slug, Request $request)
    {
        $model = $this->getManager()->find($slug);
        $this->throw404Unless($model);
        $command = new UpdateTranslationRequest($model);
        $form    = $this->createForm(UpdateTranslationRequestType::class, $command);

        $result = $this->getInteractionResponse($form, $request, $command);
        if ($result->isSuccessful()) {
            $this->flash($result);
            return $this->redirectToRoute('app_translations_list');
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