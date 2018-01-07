<?php
/**
 * XliffMessage.php
 * words
 * Date: 07.01.18
 */

namespace Components\Localization;

use JMS\TranslationBundle\Model\Message;
use JMS\TranslationBundle\Model\Message\XliffMessageState;


/**
 *
 */
interface IMessage
{
    /**
     * @return string
     */
    public function getId();

    /**
     * This will return:
     * 1) the localeString, ie the translated string
     * 2) description (if new)
     * 3) id (if new)
     * 4) empty string.
     *
     * @return string
     */
    public function getLocaleString();

    /**
     * Returns the string from which to translate.
     *
     * This typically is the description, but we will fallback to the id
     * if that has not been given.
     *
     * @return string
     */
    public function getSourceString();

    /**
     * @return string
     */
    public function getMeaning();

    /**
     * @return string
     */
    public function getDesc();


    /**
     * Return true if we have a translated string. This is not the same as running:
     *   $str = $message->getLocaleString();
     *   $bool = !empty($str);.
     *
     * The $message->getLocaleString() will return a description or an id if the localeString does not exist.
     *
     * @return bool
     */
    public function hasLocaleString();

    /**
     * @return bool
     */
    public function isApproved();



    /**
     * @return bool
     */
    public function hasState();


    /**
     * @return XliffMessageState|string
     */
    public function getState();

    /**
     * @return bool
     */
    public function isNew();


    /**
     * @return bool
     */
    public function isWritable();

    /**
     * @return bool
     */
    public function hasNotes();

    /**
     * @return array
     */
    public function getNotes();

}