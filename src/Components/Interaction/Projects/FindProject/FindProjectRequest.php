<?php
/**
 * FindProjectRequest.php
 * words
 * Date: 04.02.18
 */

namespace Components\Interaction\Projects\FindProject;


use Components\Interaction\Resource\ResourceRequest;

class FindProjectRequest extends ResourceRequest
{

    /**
     * @return string
     */
    public function getResourceName()
    {
        return 'project';
    }

    /**
     * @return string
     */
    public function getIntention()
    {
        return 'show';
    }
}