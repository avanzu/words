<?php
/**
 * TransUnitController.php
 * words
 * Date: 07.01.18
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Project;
use AppBundle\Form\CreateTranslationRequestType;
use AppBundle\Form\ExportCatalogueRequestType;
use AppBundle\Form\UpdateTranslationRequestType;
use AppBundle\Localization\MessageCatalogue;
use AppBundle\Presentation\ViewHandlerTemplate;
use AppBundle\Traits\Flasher;
use AppBundle\Traits\TemplateAware;
use Components\Infrastructure\Response\ContinueCommandResponse;
use Components\Infrastructure\Response\ErrorResponse;
use Components\Infrastructure\Response\IResponse;
use Components\Interaction\Translations\CreateTranslation\CreateTranslationRequest;
use Components\Interaction\Translations\ExportCatalogue\ExportCatalogueRequest;
use Components\Interaction\Translations\ExportCatalogue\ExportCatalogueResponse;
use Components\Interaction\Translations\GetCollection\GetCollectionRequest;
use Components\Interaction\Translations\GetCollection\GetCollectionResponse;
use Components\Interaction\Translations\ImportCatalogue\ImportCatalogueRequest;
use Components\Interaction\Translations\LoadFile\LoadFileRequest;
use Components\Interaction\Translations\LoadFile\LoadFileResponse;
use Components\Interaction\Translations\Translate\TranslateRequest;
use Components\Interaction\Translations\UpdateTranslation\UpdateTranslationRequest;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TransUnitController extends ResourceController implements ITemplateAware, IFlashing
{
    use TemplateAware,
        Flasher;



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