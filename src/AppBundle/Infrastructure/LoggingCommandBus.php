<?php
/**
 * LoggingCommandBus.php
 * restfully
 * Date: 16.09.17
 */

namespace AppBundle\Infrastructure;


use Components\Infrastructure\CommandBus;
use Components\Infrastructure\Request\CommandRequest;
use Components\Infrastructure\Response\ErrorCommandResponse;
use Psr\Log\LoggerInterface;

class LoggingCommandBus implements CommandBus
{
    /**
     * @var CommandBus
     */
    protected $bus;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * LoggingCommandBus constructor.
     *
     * @param CommandBus      $bus
     * @param LoggerInterface $logger
     */
    public function __construct(CommandBus $bus, LoggerInterface $logger)
    {
        $this->bus    = $bus;
        $this->logger = $logger;
    }


    public function execute(CommandRequest $request)
    {
        $this->logger->debug(sprintf('Request received: %s', get_class($request)), [$request]);

        try {
            $response = $this->bus->execute($request);

        } catch(ErrorCommandResponse $e) {
            $this->logger->error(sprintf('Command failed: %s', $e->getMessage()), [$e]);
            throw $e;
        }

        $this->logger->debug(sprintf('Command returned successfully: %s', get_class($response)), [$response]);

        return $response;

    }


}