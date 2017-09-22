<?php
/**
 * ResourceHandler.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Interaction\Resource;


use Components\Infrastructure\Command\Handler\ICommandHandler;
use Components\Resource\IManager;

abstract class ResourceHandler implements ICommandHandler
{
    /**
     * @var IManager
     */
    protected $manager;

    /**
     * @return IManager
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * @param IManager $manager
     *
     * @return $this
     */
    public function setManager($manager)
    {
        $this->manager = $manager;

        return $this;
    }

}