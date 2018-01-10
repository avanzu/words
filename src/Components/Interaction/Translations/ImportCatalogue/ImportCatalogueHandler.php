<?php
/**
 * ImportCatalogueHandler.php
 * words
 * Date: 07.01.18
 */

namespace Components\Interaction\Translations\ImportCatalogue;


use Components\Infrastructure\Command\Handler\ICommandHandler;
use Components\Infrastructure\Request\IRequest;
use Components\Resource\IManager;
use Components\Resource\IProjectManager;
use Components\Resource\ITransUnitManager;

class ImportCatalogueHandler implements ICommandHandler
{

    /**
     * @var ITransUnitManager|IManager
     */
    protected $manager;

    /**
     * @var IProjectManager
     */
    protected $projectManager;

    /**
     * ImportCatalogueHandler constructor.
     *
     * @param ITransUnitManager $manager
     * @param IProjectManager   $projectManager
     */
    public function __construct(ITransUnitManager $manager, IProjectManager $projectManager) {
        $this->manager        = $manager;
        $this->projectManager = $projectManager;
    }

    /**
     * @param ImportCatalogueRequest|IRequest $request
     *
     * @return mixed
     */
    public function handle(IRequest $request)
    {
        $project   = $this->projectManager->getProject($request->getProject());
        $catalogue = $request->getCatalogue();
        $units     = [];
        $loop      = 0;

        foreach ( $catalogue->getMessages() as $message ) {
            $unit = $this->manager->loadOrCreate($message->getId(), $catalogue->getCatalog(), $project);
            $unit->setSourceString($message->getSourceString())
                 ->setDescription(implode(PHP_EOL, $message->getNotes()));

            if( ! $value = $unit->getTranslation($catalogue->getLocale())) {
                $value = $unit->createTranslation($catalogue->getLocale());
            }

            $value->setContent($message->getLocaleString());

            $units[] = $unit;
            if( count($units) % 50 === 0 ) {
                $this->manager->save($units);
                $units = [];
            }

        }

        if( count($units) ) {
            $this->manager->save($units);
        }

        return new ImportCatalogueResponse(
            'translation.import.success',
            ['%catalog%' => $catalogue->getCatalog(), '%locale%' => $catalogue->getLocale(), '%project%' => $project]
        );
    }
}