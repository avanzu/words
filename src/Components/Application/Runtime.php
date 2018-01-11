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
class Runtime implements \ArrayAccess
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

    /**
     * Whether a offset exists
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     *
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * Offset to retrieve
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $offset <p>
     *                      The offset to retrieve.
     *                      </p>
     *
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * Offset to set
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset <p>
     *                      The offset to assign the value to.
     *                      </p>
     * @param mixed $value  <p>
     *                      The value to set.
     *                      </p>
     *
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * Offset to unset
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed $offset <p>
     *                      The offset to unset.
     *                      </p>
     *
     * @return void
     * @since 5.0.0
     */public function offsetUnset($offset) {
        if( $this->has($offset)) unset($this->vars[$offset]);
    }
}