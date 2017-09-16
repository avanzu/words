<?php
/**
 * CreateResourceResponse.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Interaction\Resource\CreateResource;


use Components\Infrastructure\CommandResponse;
use Components\Interaction\Resource\ResourceCommandRequest;
use Components\Interaction\Resource\ResourceResponse;

class CreateResourceResponse extends ResourceResponse
{
    public function __construct($resource, ResourceCommandRequest $request, $status = CommandResponse::STATUS_CREATED)
    {
        parent::__construct($resource, $request, $status);
    }


}