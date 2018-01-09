<?php
/**
 * CatalogueSelection.php
 * words
 * Date: 08.01.18
 */

namespace Components\DataAccess;

class CatalogueSelection
{

    protected $project;

    protected $catalogue;

    protected $locale;

    /**
     * CatalogueSelection constructor.
     *
     * @param $project
     * @param $catalogue
     * @param $locale
     */
    public function __construct($project = null, $catalogue = null, $locale = null)
    {
        $this->project   = $project;
        $this->catalogue = $catalogue;
        $this->locale    = $locale;
    }


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
}