<?php
/**
 * TranslateRequest.php
 * words
 * Date: 08.01.18
 */

namespace Components\Interaction\Translations\Translate;


use Components\Interaction\Resource\ResourceRequest;
use Components\Model\TransUnit;

/**
 * Class TranslateRequest
 * @method TransUnit getDao
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

    public function __construct($dao = null, $locale = null, $localeString = null) {
        $this->locale       = $locale;
        $this->localeString = $localeString;
        parent::__construct($dao);
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