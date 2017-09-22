<?php
/**
 * LoggingCommandBus.php
 * restfully
 * Date: 16.09.17
 */

namespace AppBundle\Infrastructure;


use Components\Infrastructure\ICommandBus;
use Components\Infrastructure\Request\IRequest;
use Components\Infrastructure\Response\ErrorResponse;
use Psr\Log\LoggerInterface;

class LoggingCommandBus implements ICommandBus
{
    /**
     * @var ICommandBus
     */
    protected $bus;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * LoggingCommandBus constructor.
     *
     * @param ICommandBus     $bus
     * @param LoggerInterface $logger
     */
    public function __construct(ICommandBus $bus, LoggerInterface $logger)
    {
        $this->bus    = $bus;
        $this->logger = $logger;
    }


    public function execute(IRequest $request)
    {
        $this->logger->debug(sprintf('Request received: %s', get_class($request)), [$request]);

        try {
            $response = $this->bus->execute($request);

        } catch(ErrorResponse $e) {
            $this->logger->error(sprintf('Command failed: %s', $e->getMessage()), [$e]);
            throw $e;
        }

        $this->logger->debug(sprintf('Command returned successfully: %s', get_class($response)), [$response]);

        return $response;

    }


}