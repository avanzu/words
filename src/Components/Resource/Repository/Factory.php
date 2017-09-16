<?php
/**
 * Factory.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Resource\Repository;


interface Factory
{
    /**
     * @param $className
     *
     * @return Repository
     */
    public function getRepository($className);
}