<?php
/**
 * Project.php
 * words
 * Date: 07.01.18
 */

namespace AppBundle\Entity;

use Components\Model\Project as ProjectModel;

class Project extends ProjectModel
{
    /**
     * @var  int
     */
    protected $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

}