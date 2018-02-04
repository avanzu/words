<?php
/**
 * IMessageCatalogue.php
 * words
 * Date: 07.01.18
 */

namespace Components\Localization;

interface IMessageCatalogue
{
    const __DEFAULT = 'messages';

    /**
     * @return IMessage[]
     */
    public function getMessages();

    /**
     * @return string
     */
    public function getLocale();

    /**
     * @return string
     */
    public function getCatalog();

}