<?php
/**
 * RemoveProjectRequest.php
 * words
 * Date: 07.01.18
 */

namespace Components\Interaction\Projects\RemoveProject;


use Components\Interaction\Resource\RemoveResource\RemoveResourceRequest;

class RemoveProjectRequest extends RemoveResourceRequest
{

    /**
     * @return string
     */
    public function getResourceName()
    {
        return 'project';
    }
}