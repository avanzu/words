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
use Components\Interaction\Translations\ImportCatalogue\ImportCatalogueRequest;
use Components\Interaction\Translations\LoadFile\LoadFileRequest;
use Components\Interaction\Translations\LoadFile\LoadFileResponse;
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

    protected function handleUpload(FormInterface $form, Request $request, callable  $next)
    {
        $form->handleRequest($request);

        if( ! $form->isSubmitted() ) {
            return new ContinueCommandResponse();
        }
        if( ! $form->isValid() ) {
            return new ContinueCommandResponse();
        }
        try {
            /** @var UploadedFile $upload */
            $upload   = $form->get('catalog')->getData();
            $tempFile = $upload->move(sprintf('%s/catalog', sys_get_temp_dir()), $upload->getClientOriginalName());

            return $next($tempFile->getRealPath());
        } catch(\Exception $e) {
            return new ErrorResponse('File upload failed.', IResponse::STATUS_BAD_REQUEST, $e);
        }
    }

    /**
     * @param          $fileName
     *
     * @param callable $next
     *
     * @return \Components\Infrastructure\Response\IResponse|LoadFileResponse
     */
    protected function loadFile($fileName, callable $next)
    {
        $command  = new LoadFileRequest($fileName);
        $response = $this->commandBus->execute($command);
        return $response->isSuccessful() ? $next($response) : $response;
    }

    protected function importFile(MessageCatalogue $catalogue, Project $project = null)
    {
        $command  = new ImportCatalogueRequest($catalogue, $project);
        $response = $this->commandBus->execute($command);
        return $response;
    }

    public function uploadCatalogAction(Request $request)
    {
        $form = $this
            ->createForm(FormType::class)
            ->add('catalog', FileType::class)
        ;

        $command = $response = false;

        $response = $this->handleUpload($form, $request, function($fileName){
                return $this->loadFile($fileName, function(LoadFileResponse $response){
                    return $this->importFile($response->getCatalog());
                });
            });

        if( $response->isSuccessful() ) {
            $this->flash($response);
            return $this->redirectToRoute('app_translation_upload');
        }

        return $this->createResponse(
            new ViewHandlerTemplate(
                $this->getTemplate(),
                $request,
                ['form' => $form, 'command' => $command, 'result' => $response]
            )
        );

    }

    protected function generateExportUrl(ExportCatalogueRequest $command)
    {
        $params = [
            'locale'    => $command->getLocale(),
            'catalogue' => $command->getCatalogue()
        ];
        if( $command->getProject()) {
            return $this->redirectToRoute('app_translation_export_project', array_merge($params, ['project' => $command->getProject()]));
        }
        return $this->redirectToRoute('app_translation_export', $params);
    }

    public function selectCatalogAction(Request $request)
    {
        $command  = new ExportCatalogueRequest();
        $form     = $this->createForm(ExportCatalogueRequestType::class, $command, ['method' => 'GET']);

        $form->handleRequest($request);
        if( $form->isSubmitted() ) {
            if( $form->isValid() ) {
                return $this->generateExportUrl($command);
            }
        }

        /** @var ExportCatalogueResponse $response */
        $response = $this->getInteractionResponse($form, $request, $command);

        if( $response->isSuccessful() ) {
            return new StreamedResponse($response->getContent(), 200, ['Content-Type' => 'text/xml']);
        }

        return $this->createResponse(
            new ViewHandlerTemplate(
                $this->getTemplate(),
                $request,
                ['form' => $form, 'command' => $command, 'result' => $response]
            )
        );

    }


    public function exportCatalogAction($locale, $catalogue, $project = null,  Request $request)
    {
        $command  = new ExportCatalogueRequest();
        $command->setCatalogue($catalogue)->setLocale($locale)->setProject($project);
        $response = $this->commandBus->execute($command);
        if( $response->isSuccessful() ) {
            return new StreamedResponse($response->getContent(), 200, ['Content-Type' => 'text/xml']);
        }

        return $this->createResponse(
            new ViewHandlerTemplate(
                $this->getTemplate(),
                $request,
                ['command' => $command, 'result' => $response]
            )
        );
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