<?php
/**
 * ExportLocaleRequest.php
 * words
 * Date: 09.02.18
 */

namespace Components\Interaction\Translations\ExportLocale;


use Components\Infrastructure\Request\IRequest;

class ExportLocaleRequest implements IRequest
{
    protected $project;

    protected $locale;

    /**
     * @return mixed
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param mixed $project
     *
     * @return $this
     */
    public function setProject($project)
    {
        $this->project = $project;

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



}