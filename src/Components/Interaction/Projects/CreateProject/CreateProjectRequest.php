<?php
/**
 * CreateProjectRequest.php
 * words
 * Date: 07.01.18
 */

namespace Components\Interaction\Projects\CreateProject;


use Components\Interaction\Resource\CreateResource\CreateResourceRequest;

class CreateProjectRequest extends CreateResourceRequest
{

    /**
     * @return string
     */
    public function getResourceName()
    {
        return 'project';
    }
}