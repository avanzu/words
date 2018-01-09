<?php
/**
 * GetCompletionResponse.php
 * words
 * Date: 09.01.18
 */

namespace Components\Interaction\Statistics\GetCompletion;


use Components\Infrastructure\Response\IResponse;
use Components\Infrastructure\Response\Response;
use Components\Model\Completion;

class GetCompletionResponse extends Response
{

    /**
     * @var Completion
     */
    protected $completions;
    /**
     * @var string
     */
    private $message;

    /**
     * GetCompletionResponse constructor.
     *
     * @param Completion[] $completions
     * @param string     $message
     * @param int        $status
     */
    public function __construct( $completions, $message = '', $status = IResponse::STATUS_OK) {
        $this->completions = $completions;
        $this->message = $message;
        $this->status = $status;
    }


    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return Completion
     */
    public function getCompletions()
    {
        return $this->completions;
    }

}