<?php
/**
 * UrlGenerator.php
 * words
 * Date: 13.01.18
 */

namespace Components\Hateoas;


interface IUrlGenerator
{
    /**
     * @param mixed $name
     * @param array $parameters
     *
     * @return string
     */
    public function generate($name, $parameters = array());

    /**
     * @param mixed $candidate
     *
     * @return bool
     */
    public function supports($candidate);
}