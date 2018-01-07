<?php
/**
 * Message.php
 * words
 * Date: 07.01.18
 */

namespace AppBundle\Localization;


use Components\Localization\IMessage;
use JMS\TranslationBundle\Model\Message\XliffMessage;
use JMS\TranslationBundle\Model\Message\XliffMessageState;

class Message implements IMessage
{
    /**
     * @var  XliffMessage
     */
    protected $message;

    /**
     * Message constructor.
     *
     * @param XliffMessage $message
     */
    public function __construct(XliffMessage $message) {
        $this->message = $message;
    }


    /**
     * @return string
     */
    public function getId()
    {
        return $this->message->getId();
    }

    /**
     * This will return:
     * 1) the localeString, ie the translated string
     * 2) description (if new)
     * 3) id (if new)
     * 4) empty string.
     *
     * @return string
     */
    public function getLocaleString()
    {
        return $this->message->getLocaleString();
    }

    /**
     * Returns the string from which to translate.
     *
     * This typically is the description, but we will fallback to the id
     * if that has not been given.
     *
     * @return string
     */
    public function getSourceString()
    {
        return $this->message->getSourceString();
    }

    /**
     * @return string
     */
    public function getMeaning()
    {
        return $this->message->getMeaning();
    }

    /**
     * @return string
     */
    public function getDesc()
    {
        return $this->message->getDesc();
    }


    /**
     * Return true if we have a translated string. This is not the same as running:
     *   $str = $message->getLocaleString();
     *   $bool = !empty($str);.
     *
     * The $message->getLocaleString() will return a description or an id if the localeString does not exist.
     *
     * @return bool
     */
    public function hasLocaleString()
    {
        return $this->message->hasLocaleString();
    }

    /**
     * @return bool
     */
    public function isApproved()
    {
        return $this->message->isApproved();
    }

    /**
     * @return bool
     */
    public function hasState()
    {
        return $this->message->hasState();
    }

    /**
     * @return XliffMessageState|string
     */
    public function getState()
    {
        return $this->message->getState();
    }

    /**
     * @return bool
     */
    public function isNew()
    {
        return $this->message->isNew();
    }

    /**
     * @return bool
     */
    public function isWritable()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function hasNotes()
    {
        return $this->message->hasNotes();
    }

    /**
     * @return array
     */
    public function getNotes()
    {
        return $this->message->getNotes();
    }
}