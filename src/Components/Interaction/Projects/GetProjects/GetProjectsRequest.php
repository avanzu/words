<?php
/**
 * GetProjectsRequest.php
 * words
 * Date: 07.01.18
 */

namespace Components\Interaction\Projects\GetProjects;


use Components\Interaction\Resource\GetCollection\GetCollectionRequest;

class GetProjectsRequest extends GetCollectionRequest
{
    public function getResourceName()
    {
        return 'project';
    }


}