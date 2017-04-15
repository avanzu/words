<?php
/**
 * RelationProviderInterface.php
 * restfully
 * Date: 14.04.17
 */

namespace Components\Hateoas;


interface RelationProviderInterface
{

    /**
     * @param $object
     *
     * @return array
     */
    public function decorate($object);

    /**
     * @param $object
     *
     * @return bool
     */
    public function isSupported($object);

}