<?php
/**
 * FileController.php
 * words
 * Date: 08.01.18
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Project;
use AppBundle\Form\CatalogueSelectionType;
use AppBundle\Form\ExportCatalogueRequestType;
use AppBundle\Localization\MessageCatalogue;
use AppBundle\Presentation\ViewHandlerTemplate;
use AppBundle\Traits\Flasher;
use AppBundle\Traits\TemplateAware;
use Components\DataAccess\CatalogueSelection;
use Components\Infrastructure\Response\ContinueCommandResponse;
use Components\Infrastructure\Response\ErrorResponse;
use Components\Infrastructure\Response\IResponse;
use Components\Interaction\Translations\ExportCatalogue\ExportCatalogueRequest;
use Components\Interaction\Translations\ExportCatalogue\ExportCatalogueResponse;
use Components\Interaction\Translations\ImportCatalogue\ImportCatalogueRequest;
use Components\Interaction\Translations\LoadFile\LoadFileRequest;
use Components\Interaction\Translations\LoadFile\LoadFileResponse;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController extends ResourceController implements ITemplateAware, IFlashing
{
    use TemplateAware,
        Flasher;


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

    protected function importFile(MessageCatalogue $catalogue,  $project )
    {
        $command  = new ImportCatalogueRequest($catalogue, $project);
        $response = $this->commandBus->execute($command);
        return $response;
    }

    public function uploadCatalogAction($project, Request $request)
    {
        $form = $this
            ->createForm(FormType::class)
            ->add('catalog', FileType::class)
        ;

        $command = $response = false;

        $response = $this->handleUpload($form, $request, function($fileName) use ($project){
            return $this->loadFile($fileName, function(LoadFileResponse $response) use ($project) {
                return $this->importFile($response->getCatalog(), $project);
            });
        });

        if( $response->isSuccessful() ) {
            $this->flash($response);
            return $this->redirectToRoute('app_translation_upload_file', ['project' => $project ]);
        }

        return $this->createResponse(
            new ViewHandlerTemplate(
                $this->getTemplate(),
                $request,
                ['form' => $form, 'command' => $command, 'result' => $response]
            )
        );

    }

    protected function generateExportUrl(CatalogueSelection $command)
    {
        $params = [
            'locale'    => $command->getLocale(),
            'catalogue' => $command->getCatalogue(),
            'project'   => $command->getProject()
        ];

        return $this->redirectToRoute(
            'app_translation_export_file',
            $params
        );
    }

    public function selectCatalogAction($project, Request $request)
    {
        $command  = new CatalogueSelection($project);
        $form     = $this->createForm(CatalogueSelectionType::class, $command, ['method' => 'GET']);

        $form->handleRequest($request);
        if( $form->isSubmitted() ) {
            if( $form->isValid() ) {
                return $this->generateExportUrl($command);
            }
        }

        return $this->createResponse(
            new ViewHandlerTemplate(
                $this->getTemplate(),
                $request,
                ['form' => $form]
            )
        );

    }


    public function exportCatalogAction($locale, $catalogue, $project,  Request $request)
    {
        $command   = new ExportCatalogueRequest();
        $selection = new CatalogueSelection();
        $selection->setCatalogue($catalogue)->setLocale($locale)->setProject($project);
        $command->setSelection($selection);
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

}