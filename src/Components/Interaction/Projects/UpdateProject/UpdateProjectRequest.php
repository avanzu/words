<?php
/**
 * UpdateProjectRequest.php
 * words
 * Date: 07.01.18
 */

namespace Components\Interaction\Projects\UpdateProject;


use Components\Interaction\Resource\UpdateResource\UpdateResourceRequest;

class UpdateProjectRequest extends UpdateResourceRequest
{

    /**
     * @return string
     */
    public function getResourceName()
    {
        return 'project';
    }
}