<?php
/**
 * LoadFileHandler.php
 * words
 * Date: 07.01.18
 */

namespace Components\Interaction\Translations\LoadFile;


use Components\Infrastructure\Command\Handler\ICommandHandler;
use Components\Infrastructure\Request\IRequest;
use Components\Infrastructure\Response\ErrorResponse;
use Components\Infrastructure\Response\IResponse;
use Components\Localization\IMessageLoader;

class LoadFileHandler implements ICommandHandler
{

    /**
     * @var IMessageLoader
     */
    protected $loader;

    /**
     * LoadFileHandler constructor.
     *
     * @param IMessageLoader $loader
     */
    public function __construct(IMessageLoader $loader) {
        $this->loader = $loader;
    }


    /**
     * @param IRequest|LoadFileRequest $request
     *
     * @return LoadFileResponse|ErrorResponse
     */
    public function handle(IRequest $request)
    {
        try {
            $messages  = $this->loader->loadCatalogue($request->getFileName());
            return new LoadFileResponse($messages);
        } catch(\Exception $e) {
            return new ErrorResponse('Unable to load file.', IResponse::STATUS_INTERNAL_SERVER_ERROR, $e);
        }

    }
}