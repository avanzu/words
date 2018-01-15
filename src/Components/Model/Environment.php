<?php
/**
 * Environment.php
 * words
 * Date: 15.01.18
 */

namespace Components\Model;


class Environment
{
    protected $projects;

    protected $catalogues;

    protected $languages;

    /**
     * Environment constructor.
     *
     * @param $projects
     * @param $catalogues
     * @param $languages
     */
    public function __construct($projects, $catalogues, $languages)
    {
        $this->projects   = $projects;
        $this->catalogues = $catalogues;
        $this->languages  = $languages;
    }

    /**
     * @return mixed
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * @return mixed
     */
    public function getCatalogues()
    {
        return $this->catalogues;
    }

    /**
     * @return mixed
     */
    public function getLanguages()
    {
        return $this->languages;
    }


}