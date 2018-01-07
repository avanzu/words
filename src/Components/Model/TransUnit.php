<?php
/**
 * TransUnit.php
 * words
 * Date: 07.01.18
 */

namespace Components\Model;


/**
 * Class TransUnit
 */
class TransUnit
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var  string
     */
    protected $catalogue = 'messages';
    /**
     * @var string
     */
    protected $description;

    /**
     * @var  Project
     */
    protected $project;

    /**
     * @var TransValue[]
     */
    protected $translations;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param TransValue $value
     *
     * @return $this
     */
    public function addTranslation(TransValue $value)
    {
        $this->translations[$value->getLocale()] = $value;

        return $this;
    }

    /**
     * @param TransValue $value
     *
     * @return $this|void
     */
    public function removeTranslation(TransValue $value)
    {
        if (!isset($this->translations[$value->getLocale()])) {
            return;
        }
        unset($this->translations[$value->getLocale()]);
        return $this;
    }

    /**
     * @return TransValue[]
     */
    public function getTranslations()
    {
        return $this->translations;
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param Project $project
     *
     * @return $this
     */
    public function setProject($project)
    {
        $this->project = $project;

        return $this;
    }


}