<?php
/**
 * ProjectResolver.php
 * words
 * Date: 09.01.18
 */

namespace AppBundle\EventListener;


use Components\Resource\IProjectManager;

class ProjectResolver
{
    /**
     * @var  IProjectManager
     */
    protected $manager;

    /**
     * ProjectResolver constructor.
     *
     * @param IProjectManager $manager
     */
    public function __construct(IProjectManager $manager)
    {
        $this->manager   = $manager;
    }



    public function createResolver($canonical)
    {
        return function() use ($canonical) {
            return $this->manager->loadProjectBySlug($canonical);
        };
    }
}