<?php
/**
 * SimpleMessage.php
 * words
 * Date: 07.01.18
 */

namespace AppBundle\Localization;


use Components\Localization\IMessage;
use JMS\TranslationBundle\Model\Message\XliffMessageState;

class SimpleMessage implements IMessage
{
    /**
     * @var string
     */
    protected $id;
    /**
     * @var string
     */
    protected $desc;
    /**
     * @var string
     */
    protected $localeString;

    /**
     * @var string
     */
    protected $sourceString;

    /**
     * @var string
     */
    protected $notes;

    /**
     * @var int
     */
    protected $entityId;
    /**
     * @var string
     */
    protected $state;

    /**
     * SimpleMessage constructor.
     *
     * @param        $entityId
     * @param string $id
     * @param string $desc
     * @param string $localeString
     * @param string $sourceString
     * @param string $description
     * @param null   $state
     */
    public function __construct( $entityId, $id, $desc, $localeString, $sourceString = '', $description = '', $state = Message::STATE_NONE)
    {
        $this->entityId     = $entityId;
        $this->id           = $id;
        $this->desc         = $desc;
        $this->sourceString = $sourceString ?: $desc;
        $this->localeString = $localeString;
        $this->notes        = $description;
        $this->state        = $state ?: $this->localeString ? Message::STATE_TRANSLATED : Message::STATE_NEEDS_TRANSLATION;

    }

    /**
     * @return mixed
     */
    public function getEntityId()
    {
        return $this->entityId;
    }


    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     * @return string
     */
    public function getLocaleString()
    {
        return $this->localeString;
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
        return $this->sourceString;
    }

    /**
     * @return string
     */
    public function getMeaning()
    {
        return '';
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
        return strlen($this->localeString);
    }

    /**
     * @return bool
     */
    public function isApproved()
    {
        return null;
    }

    /**
     * @return bool
     */
    public function hasState()
    {
        return !!$this->state;
    }

    /**
     * @return XliffMessageState|string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return bool
     */
    public function isNew()
    {
        return false;
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
        return strlen($this->notes);
    }

    /**
     * @return array
     */
    public function getNotes()
    {
        return [$this->notes];
    }

    public function getSources()
    {
        return [];
    }


}