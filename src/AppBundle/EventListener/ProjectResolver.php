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

    protected $canonical = null;

    /**
     * ProjectResolver constructor.
     *
     * @param IProjectManager $manager
     * @param null            $canonical
     */
    public function __construct(IProjectManager $manager, $canonical = null)
    {
        $this->manager   = $manager;
        $this->canonical = $canonical;
    }


    public function __toString()
    {
        if( $this->canonical ) {
            return (string)$this->manager->loadProjectBySlug($this->canonical);
        }
        return '';


    }

    public function createResolver($canonical)
    {
        return new static($this->manager, $canonical);
    }
}