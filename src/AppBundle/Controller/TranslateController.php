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
            'catalogue' => $command->getCatalogue()
        ];
        if( $command->getProject()) {
            return $this->redirectToRoute(
                'app_translation_translate_project_catalogue',
                array_merge($params, ['project' => $command->getProject()])
            );
        }
        return $this->redirectToRoute(
            'app_translation_translate_catalogue',
            $params
        );
    }

    public function selectCatalogAction(Request $request)
    {
        $command  = new CatalogueSelection();
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

    protected function translateCatalogue($locale, $catalogue, Request $request, $project = null)
    {
        $command = new GetCollectionRequest(
            null,
            'trans.unit',
            $request->get('limit', 10),
            $request->get('offset')
        );

        $command->setLocale($locale)->setCatalogue($catalogue)->setProject($project);

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

    public function translateCatalogueAction($locale, $catalogue, Request $request)
    {
        return $this->translateCatalogue($locale,$catalogue, $request);

    }


    public function translateProjectCatalogueAction($locale, $catalogue, $project, Request $request)
    {

        return $this->translateCatalogue($locale,$catalogue, $request, $project);

    }


    public function translateUnitAction($locale, $catalogue, $id, Request $request)
    {
        $dao = $this->manager->find($id);
        $this->throw404Unless($dao);
        $command = new TranslateRequest($dao, $locale, $request->get('content'));
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