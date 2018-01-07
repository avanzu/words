<?php
/**
 * IMessageWriter.php
 * words
 * Date: 07.01.18
 */

namespace Components\Localization;


interface IMessageWriter
{
    /**
     * @param IMessageCatalogue $catalogue
     * @param                   $file
     *
     * @return mixed
     */
    public function write(IMessageCatalogue $catalogue, $file);

    /**
     * @param IMessageCatalogue $catalogue
     * @param                   $file
     *
     * @return callable
     */
    public function createWriter(IMessageCatalogue $catalogue, $file);
}