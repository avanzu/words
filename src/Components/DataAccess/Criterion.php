<?php
/**
 * Criterion.php
 * restfully
 * Date: 17.09.17
 */

namespace Components\DataAccess;


class Criterion
{
    protected $property;

    protected $value;

    protected $comparison;

    /**
     * Criterion constructor.
     *
     * @param $property
     * @param $value
     * @param $comparison
     */
    public function __construct($property = null, $value = null, $comparison = 'eq')
    {
        $this->property   = $property;
        $this->value      = $value;
        $this->comparison = $comparison;
    }

    /**
     * @return null
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @param null $property
     *
     * @return $this
     */
    public function setProperty($property)
    {
        $this->property = $property;

        return $this;
    }

    /**
     * @return null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param null $value
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getComparison()
    {
        return $this->comparison;
    }

    /**
     * @param string $comparison
     *
     * @return $this
     */
    public function setComparison($comparison)
    {
        $this->comparison = $comparison;

        return $this;
    }

}