<?php
/**
 * TranslateRequest.php
 * words
 * Date: 08.01.18
 */

namespace Components\Interaction\Translations\Translate;


use AppBundle\Localization\Message;
use Components\Interaction\Resource\ResourceRequest;
use Components\Localization\IMessageCatalogue;
use Components\Model\Project;
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

    /**
     * @var string
     */
    protected $catalogue;

    /**
     * @var string
     */
    protected $project;
    /** @var string */
    protected $key;

    public function __construct(
        $key = null,
        $locale = null,
        $localeString = null,
        $catalogue = IMessageCatalogue::__DEFAULT,
        $project = Project::__DEFAULT,
        $state = Message::STATE_TRANSLATED
    ) {
        parent::__construct(null);
        $this->key          = $key;
        $this->locale       = $locale;
        $this->localeString = $localeString;
        $this->state        = $state;
        $this->catalogue    = $catalogue;
        $this->project      = $project;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     *
     * @return $this
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
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
    public function getCatalogue()
    {
        return $this->catalogue;
    }

    /**
     * @param string $catalogue
     *
     * @return $this
     */
    public function setCatalogue($catalogue)
    {
        $this->catalogue = $catalogue;

        return $this;
    }

    /**
     * @return string
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param string $project
     *
     * @return $this
     */
    public function setProject($project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * @return string
     */
    public function getIntention()
    {
        return 'translate';
    }

    /**
     * @return string
     */
    public function getResourceName()
    {
        return 'trans.unit';
    }
}