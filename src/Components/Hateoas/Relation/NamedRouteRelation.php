<?php
/**
 * NamedRouteRelation.php
 * words
 * Date: 13.01.18
 */

namespace Components\Hateoas\Relation;

/**
 * Class NamedRouteRelation
 */
class NamedRouteRelation
{
    /**
     * @var string
     */
    protected $routeName;

    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * RouteRelation constructor.
     *
     * @param       $routeName
     * @param array $parameters
     * @param array $attributes
     */
    public function __construct($routeName, array $parameters = [], array $attributes = [])
    {
        $this->routeName  = $routeName;
        $this->parameters = $parameters;
        $this->attributes = $attributes;
    }

    /**
     * @return mixed
     */
    public function getRouteName()
    {
        return $this->routeName;
    }

    /**
     * @param mixed $routeName
     *
     * @return $this
     */
    public function setRouteName($routeName)
    {
        $this->routeName = $routeName;

        return $this;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     *
     * @return $this
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     *
     * @return $this
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }
}