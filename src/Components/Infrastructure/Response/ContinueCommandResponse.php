<?php
/**
 * ContinueCommandResponse.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Infrastructure\Response;


class ContinueCommandResponse extends Response
{

    protected $payload;

    /**
     * ContinueCommandResponse constructor.
     *
     * @param $payload
     */
    public function __construct(array $payload = []) {
        $this->payload = $payload;
    }


    /**
     * @return int
     */
    public function getStatus()
    {
        return CommandResponse::STATUS_CONTINUE;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return '';
    }

    /**
     * @return mixed
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param mixed $payload
     *
     * @return $this
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;

        return $this;
    }

}