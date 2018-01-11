<?php
/**
 * TransValue.php
 * words
 * Date: 07.01.18
 */

namespace Components\Model;


class TransValue
{

    const STATE_NONE                     = null;
    const STATE_FINAL                    = 'final';
    const STATE_NEEDS_ADAPTATION         = 'needs-adaptation';
    const STATE_NEEDS_L10N               = 'needs-l10n';
    const STATE_NEEDS_REVIEW_ADAPTATION  = 'needs-review-adaptation';
    const STATE_NEEDS_REVIEW_L10N        = 'needs-review-l10n';
    const STATE_NEEDS_REVIEW_TRANSLATION = 'needs-review-translation';
    const STATE_NEEDS_TRANSLATION        = 'needs-translation';
    const STATE_NEW                      = 'new';
    const STATE_SIGNED_OFF               = 'signed-off';
    const STATE_TRANSLATED               = 'translated';

    protected $unit;

    protected $locale;

    protected $content;

    protected $state;

    /**
     * TransValue constructor.
     *
     * @param $locale
     * @param $content
     * @param $state
     */
    public function __construct($locale = null, $content = '', $state = TransValue::STATE_NONE)
    {
        $this->locale  = $locale;
        $this->content = $content;
        $this->state   = $state;
    }


    /**
     * @return mixed
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param mixed $unit
     *
     * @return $this
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param mixed $locale
     *
     * @return $this
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     *
     * @return $this
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    public function __toString()
    {
        return (string)$this->getContent();
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     *
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }


}