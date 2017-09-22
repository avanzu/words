<?php
/**
 * Factory.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Resource\Repository;


interface IFactory
{
    /**
     * @param $className
     *
     * @return IRepository
     */
    public function getRepository($className);
}