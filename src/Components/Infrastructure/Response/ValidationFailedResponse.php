<?php
/**
 * ValidationFailedResponse.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Infrastructure\Response;


use Components\Resource\Validator\Result;
use Throwable;

class ValidationFailedResponse extends ErrorCommandResponse
{
    const COMPONENT_KEY = 101;

    /**
     * @var Result
     */
    protected $result;


    public function __construct(Result $result, $message = "", $code = CommandResponse::STATUS_UNPROCESSABLE_ENTITY, Throwable $previous = null)
    {
        parent::__construct($message,$code,$previous);
        $this->result = $result;
    }

    /**
     * @return Result
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @return mixed
     */
    public function getViolations()
    {
        return $this->result->getViolations();
    }

    /**
     * @return array
     */
    public function getViolationMessages()
    {
        return $this->result->getMessages();
    }

    public function getResponseText()
    {
        return (string)$this->result->getViolations();
    }


}