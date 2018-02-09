<?php
/**
 * ExportLocaleResponse.php
 * words
 * Date: 09.02.18
 */

namespace Components\Interaction\Translations\ExportLocale;


use Components\Infrastructure\Response\IResponse;
use Components\Infrastructure\Response\Response;

class ExportLocaleResponse extends Response
{

    protected $status = IResponse::STATUS_CREATED;

    protected $content;

    protected $fileName;

    /**
     * ExportCatalogueResponse constructor.
     *
     * @param $fileName
     * @param $content
     */
    public function __construct($fileName, $content) {
        $this->content = $content;
        $this->fileName = $fileName;
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->fileName;
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