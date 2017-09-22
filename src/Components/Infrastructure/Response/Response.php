<?php
/**
 * Response.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Infrastructure\Response;


abstract class Response implements IResponse
{

    protected $status;

    /**
     * Is response informative?
     *
     * @return bool
     *
     * @final since version 3.3
     */
    public function isInformational()
    {
        return $this->status >= 100 && $this->status < 200;
    }

    /**
     * Is response successful?
     *
     * @return bool
     *
     * @final since version 3.2
     */
    public function isSuccessful()
    {
        return $this->status >= 200 && $this->status < 300;
    }

    /**
     * Is the response a redirect?
     *
     * @return bool
     *
     * @final since version 3.2
     */
    public function isRedirection()
    {
        return $this->status >= 300 && $this->status < 400;
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

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

}