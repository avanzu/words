<?php
/**
 * ProjectManager.php
 * words
 * Date: 07.01.18
 */

namespace AppBundle\Manager;

use Components\Model\Project;

class ProjectManager extends ResourceManager
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
}