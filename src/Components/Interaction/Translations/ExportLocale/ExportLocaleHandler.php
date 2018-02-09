<?php
/**
 * ExportLocaleHandler.php
 * words
 * Date: 09.02.18
 */

namespace Components\Interaction\Translations\ExportLocale;


use AppBundle\Manager\ResourceManager;
use Components\Infrastructure\Command\Handler\ICommandHandler;
use Components\Infrastructure\Request\IRequest;
use Components\Infrastructure\Response\ErrorResponse;
use Components\Localization\IMessageWriter;
use Components\Resource\ITransUnitManager;
use ZipArchive as Zip;

class ExportLocaleHandler implements ICommandHandler
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
     * @param ExportLocaleRequest|IRequest $request
     *
     * @return ExportLocaleResponse|ErrorResponse
     */
    public function handle(IRequest $request)
    {
        $tempFile    = tempnam(sys_get_temp_dir(), "zip");
        $archiveName = sprintf('%s-%s.zip', $request->getProject(), $request->getLocale());
        $archive     = new Zip();

        $archive->open($tempFile, Zip::CREATE);
        foreach ($this->getCatalogues($request) as $catalogueName => $catalogue) {

            $archive->addFromString(
                $this->getFileName($catalogueName, $request->getLocale()),
                $this->createContent($catalogue)
            );

        }

        $archive->close();

        $callback = function() use ($tempFile) {
            file_put_contents('php://output', file_get_contents($tempFile));
            unlink($tempFile);
        };

        return new ExportLocaleResponse($archiveName, $callback);

    }

    protected function getFileName($catalogueName, $locale)
    {
        return sprintf('%s.%s.xlf', $catalogueName, $locale);
    }

    /**
     * @param $catalogue
     *
     * @return string
     */
    protected function createContent($catalogue)
    {
        ob_start();
        $this->writer->write($catalogue, 'php://output');
        return ob_get_clean();
    }

    protected function getCatalogues(ExportLocaleRequest $request)
    {
        foreach ($this->manager->loadCatalogues() as $catalogue) {
            yield $catalogue => $this->manager->loadTranslations($request->getLocale(), $catalogue, $request->getProject());
        }
    }
}