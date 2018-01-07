<?php
/**
 * LoadFileResponse.php
 * words
 * Date: 07.01.18
 */

namespace Components\Interaction\Translations\LoadFile;


use Components\Infrastructure\Response\IResponse;
use Components\Infrastructure\Response\Response;
use Components\Localization\IMessageCatalogue;

class LoadFileResponse extends Response
{

    /**
     * @var string
     */
    protected $message;

    /**
     * @var IMessageCatalogue
     */
    protected $catalog;

    /**
     * @var int
     */
    protected $status = IResponse::STATUS_NO_CONTENT;

    /**
     * LoadFileResponse constructor.
     *
     * @param string            $message
     * @param IMessageCatalogue $catalog
     */
    public function __construct(IMessageCatalogue $catalog, $message = '')
    {
        $this->message = $message;
        $this->catalog = $catalog;
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
    public function getCatalog()
    {
        return $this->catalog;
    }

}