<?php
/**
 * GetUsersRequest.php
 * restfully
 * Date: 17.09.17
 */

namespace Components\Interaction\Users\GetCollection;


use Components\Interaction\Resource\GetCollection\GetCollectionRequest;

class GetUsersRequest extends GetCollectionRequest
{


    /**
     * @return string
     */
    public function getResourceName()
    {
        return 'user';
    }

}