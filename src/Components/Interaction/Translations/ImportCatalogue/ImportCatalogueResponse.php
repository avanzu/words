<?php
/**
 * ImportCatalogueResponse.php
 * words
 * Date: 07.01.18
 */

namespace Components\Interaction\Translations\ImportCatalogue;


use Components\Infrastructure\Response\IResponse;
use Components\Infrastructure\Response\Response;

class ImportCatalogueResponse extends Response
{
    /**
     * @var int
     */
    protected $status = IResponse::STATUS_CREATED;

    /**
     * @var string
     */
    protected $message;


    /**
     * ImportCatalogueResponse constructor.
     *
     * @param $message
     */
    public function __construct($message, $args = []) {
        $this->message = $message;
        $this->arguments = $args;
    }


    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

}