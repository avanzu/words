<?php
/**
 * TranslateRequest.php
 * words
 * Date: 08.01.18
 */

namespace Components\Interaction\Translations\Translate;


use AppBundle\Localization\Message;
use Components\Interaction\Resource\ResourceRequest;
use Components\Model\TransUnit;

/**
 * Class TranslateRequest
 * @method TransUnit getPayload
 */
class TranslateRequest extends ResourceRequest
{

    /**
     * @var string
     */
    protected $locale;

    /**
     * @var string
     */
    protected $localeString;

    /**
     * @var string
     */
    protected $state;

    public function __construct($payload = null, $locale = null, $localeString = null, $state = Message::STATE_TRANSLATED) {
        $this->locale       = $locale;
        $this->localeString = $localeString;
        $this->state        = $state;
        parent::__construct($payload);
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     *
     * @return $this
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocaleString()
    {
        return $this->localeString;
    }

    /**
     * @param string $localeString
     *
     * @return $this
     */
    public function setLocaleString($localeString)
    {
        $this->localeString = $localeString;

        return $this;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getResourceName()
    {
        return 'trans.unit';
    }

    /**
     * @return string
     */
    public function getIntention()
    {
        return 'translate';
    }
}