<?php
/**
 * Project.php
 * words
 * Date: 07.01.18
 */

namespace Components\Model;


class Project
{

    const __DEFAULT = 'common';

  //  protected $id;

    protected $name;

    protected $canonical;

    protected $description;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCanonical()
    {
        return $this->canonical;
    }

    /**
     * @param mixed $canonical
     *
     * @return $this
     */
    public function setCanonical($canonical)
    {
        $this->canonical = $canonical;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function __toString()
    {
        return (string)$this->getName();
    }

    /**
     * @param $candidate
     *
     * @return bool
     */
    public static function isDefault($candidate)
    {
        $canonical = $candidate instanceof Project ? $candidate->getCanonical() : $candidate;
        return ($canonical === static::__DEFAULT);
    }

}