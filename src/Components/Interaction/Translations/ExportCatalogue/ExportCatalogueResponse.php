<?php
/**
 * ExportCatalogueResponse.php
 * words
 * Date: 07.01.18
 */

namespace Components\Interaction\Translations\ExportCatalogue;


use Components\Infrastructure\Response\IResponse;
use Components\Infrastructure\Response\Response;

class ExportCatalogueResponse extends Response
{
    protected $status = IResponse::STATUS_CREATED;

    protected $content;

    /**
     * ExportCatalogueResponse constructor.
     *
     * @param $content
     */
    public function __construct($content) {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }


    /**
     * @return string
     */
    public function getMessage()
    {
        return '';
    }
}