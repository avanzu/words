<?php
/**
 * GetCompletionRequest.php
 * words
 * Date: 09.01.18
 */

namespace Components\Interaction\Statistics\GetCompletion;


use Components\Infrastructure\Request\IRequest;

/**
 * Class GetCompletionRequest
 */
class GetCompletionRequest implements IRequest
{

    /**
     * @var
     */
    protected $catalogue;
    /**
     * @var
     */
    protected $locale;
    /**
     * @var null
     */
    protected $project;

    /**
     * GetCompletionRequest constructor.
     *
     * @param $catalogue
     * @param $locale
     * @param $project
     */
    public function __construct( $locale, $catalogue = null, $project = null)
    {
        $this->catalogue = $catalogue;
        $this->locale    = $locale;
        $this->project   = $project;
    }

    /**
     * @return mixed
     */
    public function getCatalogue()
    {
        return $this->catalogue;
    }

    /**
     * @param mixed $catalogue
     *
     * @return $this
     */
    public function setCatalogue($catalogue)
    {
        $this->catalogue = $catalogue;

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
     * @return null
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param null $project
     *
     * @return $this
     */
    public function setProject($project)
    {
        $this->project = $project;

        return $this;
    }

}