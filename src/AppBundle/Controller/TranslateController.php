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
use Components\Infrastructure\Response\ErrorResponse;
use Components\Interaction\Projects\FindProject\FindProjectRequest;
use Components\Interaction\Projects\FindProject\FindProjectResponse;
use Components\Interaction\Translations\GetCollection\GetCollectionRequest;
use Components\Interaction\Translations\GetCollection\GetCollectionResponse;
use Components\Interaction\Translations\Translate\TranslateRequest;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TranslateController
 */
class TranslateController extends ResourceController implements ITemplateAware, IFlashing
{
    use TemplateAware,
        Flasher;


    /**
     * @param CatalogueSelection $command
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
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

    /**
     * @param         $project
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
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

    /**
     * @param         $project
     * @param         $locale
     * @param         $catalogue
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
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


    /**
     * @param         $project
     * @param         $locale
     * @param         $catalogue
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function translateUnitAction($project, $locale, $catalogue, Request $request)
    {

        /** @var FindProjectResponse|ErrorResponse $projectResponse */
        $projectResponse = $this->executeCommand(new FindProjectRequest($project));

        $command = new TranslateRequest(
            $request->get('key'),
            $locale,
            $request->get('content'),
            $catalogue,
            $projectResponse->getResource(),
            $request->get('state')
        );

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