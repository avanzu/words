<?php
/**
 * Container.php
 * restfully
 * Date: 17.09.17
 */

namespace Components\Infrastructure;


/**
 * Interface Container
 *
 * @package Components\Infrastructure
 */
interface IContainer
{
    /**
     * @param $id
     *
     * @return object
     */
    public function acquire($id);

    /**
     * @param $id
     *
     * @return bool
     */
    public function exists($id);
}