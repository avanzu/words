<?php
/**
 * ApplicationRelationProvider.php
 * words
 * Date: 13.01.18
 */

namespace AppBundle\Hateoas;


use Components\Hateoas\RelationProviderInterface;

class ApplicationRelationProvider implements RelationProviderInterface
{

    /**
     * @param $object
     *
     * @return array
     */
    public function decorate($object)
    {
        // TODO: Implement decorate() method.
    }

    /**
     * @param $object
     *
     * @return bool
     */
    public function isSupported($object)
    {
        // TODO: Implement isSupported() method.
    }
}