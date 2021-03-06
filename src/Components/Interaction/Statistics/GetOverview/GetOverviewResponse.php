<?php
/**
 * GetOverviewResponse.php
 * words
 * Date: 09.01.18
 */

namespace Components\Interaction\Statistics\GetOverview;



use Components\Infrastructure\Response\IResponse;
use Components\Infrastructure\Response\Response;

class GetOverviewResponse extends Response
{

    /**
     * @var
     */
    protected $languages;

    /**
     * @var
     */
    protected $catalogues;


    /**
     * @var
     */
    protected $message;

    /**
     * @var int
     */
    protected $status = IResponse::STATUS_OK;

    /**
     * GetOverviewResponse constructor.
     *
     * @param     $languages
     * @param     $catalogues
     * @param     $message
     * @param int $status
     */
    public function __construct($languages, $catalogues, $message = '', $status = IResponse::STATUS_OK)
    {
        $this->languages  = $languages;
        $this->catalogues = $catalogues;
        $this->message    = $message;
        $this->status     = $status;
    }


    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * @return mixed
     */
    public function getCatalogues()
    {
        return $this->catalogues;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }


}