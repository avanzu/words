<?php
/**
 * LoadFileRequest.php
 * words
 * Date: 07.01.18
 */

namespace Components\Interaction\Translations\LoadFile;


use Components\Infrastructure\Request\IRequest;

class LoadFileRequest implements IRequest
{

    protected $fileName;

    /**
     * LoadFileRequest constructor.
     *
     * @param $fileName
     */
    public function __construct($fileName) {
        $this->fileName = $fileName;
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->fileName;
    }


}