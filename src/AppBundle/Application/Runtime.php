<?php
/**
 * Runtime.php
 * words
 * Date: 13.01.18
 */

namespace AppBundle\Application;
use Components\Application\Runtime as SimpleRuntime;
use Components\Model\Project;

class Runtime extends SimpleRuntime
{
    /**
     * @var Project
     */
    protected $project;

    /**
     * @return Project|null
     */
    public function getProject()
    {
        if( is_callable($this->project))
            $this->project = call_user_func($this->project);

        return $this->project;
    }

    /**
     * @param Project|callable $project
     *
     * @return $this
     */
    public function setProject($project)
    {
        $this->project = $project;

        return $this;
    }

    public function hasProject()
    {
        return ! is_null($this->getProject());
    }

}