<?php
/**
 * Runtime.php
 * words
 * Date: 11.01.18
 */

namespace Components\Application;


/**
 * Class Runtime
 */
class Runtime
{
    /**
     * @var array
     */
    private $vars;

    /**
     * Runtime constructor.
     *
     * @param array $vars
     */
    public function __construct(array $vars = []) {
        $this->vars = $vars;
    }


    /**
     * @param      $name
     * @param null $default
     *
     * @return mixed
     */
    public function get($name, $default = null)
    {
        if( ! $this->has($name) ) return $default;

        $value = $this->vars[$name];
        if ( is_callable($value) ) {
            $this->vars[$name] = call_user_func($value);
        }

        return $this->vars[$name];
    }

    /**
     * @param $name
     * @param $value
     */
    public function set($name, $value)
    {
        $this->vars[$name] = $value;
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function has($name)
    {
        return isset($this->vars[$name]);
    }

}