<?php
/**
 * ResourceHandler.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Interaction\Resource;


use Components\Infrastructure\Command\Handler\CommandHandler;
use Components\Resource\Manager;

abstract class ResourceHandler implements CommandHandler
{
    /**
     * @var Manager
     */
    protected $manager;

    /**
     * @return Manager
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * @param Manager $manager
     *
     * @return $this
     */
    public function setManager($manager)
    {
        $this->manager = $manager;

        return $this;
    }

}