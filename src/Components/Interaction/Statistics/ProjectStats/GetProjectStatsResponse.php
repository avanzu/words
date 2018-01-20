<?php
/**
 * GetProjectStatsResponse.php
 * words
 * Date: 20.01.18
 */

namespace Components\Interaction\Statistics\ProjectStats;


use Components\Infrastructure\Response\IResponse;
use Components\Infrastructure\Response\Response;

class GetProjectStatsResponse extends Response
{

    protected $resource;
    /**
     * @var string
     */
    private $message;

    /**
     * GetProjectStatsResponse constructor.
     *
     * @param        $result
     * @param int    $status
     * @param string $message
     */
    public function __construct($result, $status = IResponse::STATUS_OK, $message = '')
    {
        $this->resource = $result;
        $this->status   = $status;
        $this->message  = $message;
    }

    /**
     * @return mixed
     */
    public function getResource()
    {
        return iterator_to_array($this->resource, false);
    }


    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}