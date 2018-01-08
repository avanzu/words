<?php
/**
 * ExportCatalogueHandler.php
 * words
 * Date: 07.01.18
 */

namespace Components\Interaction\Translations\ExportCatalogue;


use AppBundle\Manager\ResourceManager;
use Components\Infrastructure\Command\Handler\ICommandHandler;
use Components\Infrastructure\Request\IRequest;
use Components\Localization\IMessageWriter;
use Components\Resource\ITransUnitManager;

class ExportCatalogueHandler implements ICommandHandler
{

    /**
     * @var IMessageWriter
     */
    protected $writer;

    /**
     * @var ITransUnitManager|ResourceManager
     */
    protected $manager;

    /**
     * ExportCatalogueHandler constructor.
     *
     * @param IMessageWriter                    $writer
     * @param ResourceManager|ITransUnitManager $manager
     */
    public function __construct(IMessageWriter $writer, ITransUnitManager $manager)
    {
        $this->writer  = $writer;
        $this->manager = $manager;
    }


    /**
     * @param IRequest|ExportCatalogueRequest $request
     *
     * @return mixed
     */
    public function handle(IRequest $request)
    {
        $selection = $request->getSelection();
        $catalogue = $this->manager->loadTranslations(
            $selection->getLocale(),
            $selection->getCatalogue(),
            $selection->getProject()
        );

        $content   = $this->writer->createWriter($catalogue, 'php://output');
        return new ExportCatalogueResponse($content);
    }
}