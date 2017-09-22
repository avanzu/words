<?php
/**
 * ValidationFailedResponse.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Infrastructure\Response;


use Components\Resource\Validator\IResult;
use Throwable;

class ValidationFailedResponse extends ErrorResponse
{
    const COMPONENT_KEY = 101;

    /**
     * @var IResult
     */
    protected $result;


    public function __construct(IResult $result, $message = "", $code = IResponse::STATUS_UNPROCESSABLE_ENTITY, Throwable $previous = null)
    {
        parent::__construct($message,$code,$previous);
        $this->result = $result;
    }

    /**
     * @return IResult
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