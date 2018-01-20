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
    protected $locale;
    /**
     * @var null
     */
    protected $project;

    /**
     * GetCompletionRequest constructor.
     *
     * @param $locale
     * @param $project
     */
    public function __construct( $locale, $project = null)
    {
        $this->locale    = $locale;
        $this->project   = $project;
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