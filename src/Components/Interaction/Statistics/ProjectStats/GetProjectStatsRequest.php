<?php
/**
 * GetProjectStatsRequest.php
 * words
 * Date: 20.01.18
 */

namespace Components\Interaction\Statistics\ProjectStats;


use Components\Infrastructure\Request\IRequest;

class GetProjectStatsRequest implements IRequest
{
    protected $project;

    /**
     * GetProjectStatsRequest constructor.
     *
     * @param $project
     */
    public function __construct($project) {
        $this->project = $project;
    }

    /**
     * @return mixed
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param mixed $project
     *
     * @return $this
     */
    public function setProject($project)
    {
        $this->project = $project;

        return $this;
    }



}