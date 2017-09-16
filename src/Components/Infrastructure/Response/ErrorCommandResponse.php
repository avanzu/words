<?php
/**
 * ErrorResponse.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Infrastructure\Response;


use Throwable;

class ErrorCommandResponse extends \Exception implements CommandResponse
{
    const COMPONENT_KEY   = 100;
    const INTERACTION_KEY = 000;
    /**
     * @var int
     */
    protected $status;

    public function __construct($message = "", $code = CommandResponse::STATUS_BAD_REQUEST, Throwable $previous = null)
    {
        parent::__construct( $message, $this->getErrorCode($code), $previous );
        $this->status = $code;
    }


    protected function getErrorCode($code)
    {
        return (int)sprintf('%d%d%d', static::COMPONENT_KEY, static::INTERACTION_KEY, $code);
    }

    /**
     * @return string
     */
    public function getResponseText()
    {
        return $this->getMessage();
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function isSuccessful()
    {
        return false;
    }

    public function isInformational()
    {
        return false;
    }

    /**
     * Is there a client error?
     *
     * @return bool
     *
     * @final since version 3.2
     */
    public function isClientError()
    {
        return $this->status >= 400 && $this->status < 500;
    }

    /**
     * Was there a server side error?
     *
     * @return bool
     *
     * @final since version 3.3
     */
    public function isServerError()
    {
        return $this->status >= 500 && $this->status < 600;
    }


}