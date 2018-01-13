<?php
/**
 * ProjectRelationProvider.php
 * words
 * Date: 13.01.18
 */

namespace AppBundle\Hateoas;


use Components\Hateoas\RelationProviderInterface;
use Components\Model\Project;

class ProjectRelationProvider implements RelationProviderInterface
{

    /**
     * @param $object
     *
     * @return array
     */
    public function decorate($object)
    {

    }

    /**
     * @param $object
     *
     * @return bool
     */
    public function isSupported($object)
    {
        return ($object instanceof Project);
    }
}