<?php
/**
 * MessageWriter.php
 * words
 * Date: 07.01.18
 */

namespace AppBundle\Localization;


use Components\Localization\IMessageCatalogue;
use Components\Localization\IMessageWriter;
use JMS\TranslationBundle\Translation\FileWriter;

class MessageWriter implements IMessageWriter
{

    /**
     * @var  FileWriter
     */
    protected $writer;

    /**
     * MessageWriter constructor.
     *
     * @param FileWriter $writer
     */
    public function __construct(FileWriter $writer) {
        $this->writer = $writer;
    }


    /**
     * @param IMessageCatalogue|MessageCatalogue $catalogue
     * @param                   $file
     *
     * @return mixed
     */
    public function write(IMessageCatalogue $catalogue, $file )
    {
        $this->writer->write($catalogue, $catalogue->getCatalog(), $file, 'xliff');
        return $file;
    }

    /**
     * @param IMessageCatalogue|MessageCatalogue $catalogue
     * @param                   $file
     *
     * @return callable|\Closure
     */
    public function createWriter(IMessageCatalogue $catalogue, $file)
    {
        return function() use($catalogue, $file) {
            $this->writer->write($catalogue, $catalogue->getCatalog() , $file, 'xlf');
        };
    }


}