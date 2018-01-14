<?php
/**
 * TranslateController.php
 * words
 * Date: 08.01.18
 */

namespace AppBundle\Controller;

use AppBundle\Form\CatalogueSelectionType;
use AppBundle\Presentation\ViewHandlerTemplate;
use AppBundle\Traits\Flasher;
use AppBundle\Traits\TemplateAware;
use Components\DataAccess\CatalogueSelection;
use Components\Interaction\Translations\GetCollection\GetCollectionRequest;
use Components\Interaction\Translations\GetCollection\GetCollectionResponse;
use Components\Interaction\Translations\Translate\TranslateRequest;
use Symfony\Component\HttpFoundation\Request;

class TranslateController extends ResourceController implements ITemplateAware, IFlashing
{
    use TemplateAware,
        Flasher;


    protected function generateExportUrl(CatalogueSelection $command)
    {
        $params = [
            'locale'    => $command->getLocale(),
            'catalogue' => $command->getCatalogue(),
            'project'   => $command->getProject()
        ];

        return $this->redirectToRoute(
            'app_translation_translate_catalogue',
            $params
        );
    }

    public function selectCatalogAction($project, Request $request)
    {
        $command  = new CatalogueSelection($project);
        $form     = $this->createForm(CatalogueSelectionType::class, $command, [
            'method'         => 'GET',
            'switch_project' => false,
        ]);

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

    public function translateCatalogueAction($project, $locale, $catalogue, Request $request)
    {
        $command = new GetCollectionRequest(
            null,
            'trans.unit',
            $request->get('limit', 10),
            $request->get('page', 1)
        );

        // configure
        $command
            ->setLocale($locale)
            ->setCatalogue($catalogue)
            ->setProject($project)
        ;



        /** @var GetCollectionResponse $result */
        $result = $this->executeCommand($command);

        return $this->createResponse(
            new ViewHandlerTemplate(
                $this->getTemplate(),
                $request,
                ['command' => $command, 'result' => $result]
            )
        );

    }



    public function translateUnitAction($locale, $catalogue, $id, Request $request)
    {
        $payload = $this->manager->find($id);
        $this->throw404Unless($payload);
        $command = new TranslateRequest($payload, $locale, $request->get('content'));
        $result  = $this->executeCommand($command);


        return $this->createResponse(
            new ViewHandlerTemplate(
                (string)$this->getTemplate(),
                $request,
                ['result' => $result],
                $result->getStatus()
            )

        );
    }

}