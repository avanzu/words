<?php
/**
 * ProjectManager.php
 * words
 * Date: 07.01.18
 */

namespace AppBundle\Manager;

use Components\Model\Project;
use Components\Resource\IProjectManager;

class ProjectManager extends ResourceManager implements IProjectManager
{

    /**
     * @param $slug
     *
     * @return Project|null
     */
    public function loadProjectBySlug($slug)
    {
        return $this->getRepository()->findOneBy(['canonical' => $slug]);
    }


    public function loadProjects()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * @param $candidate
     *
     * @return Project|null
     */
    public function getProject($candidate)
    {
        if( $candidate instanceof Project ) return $candidate;
        return $this->loadProjectBySlug($candidate);
    }
}