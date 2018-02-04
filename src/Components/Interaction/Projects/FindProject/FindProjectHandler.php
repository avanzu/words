<?php
/**
 * FindProjectHandler.php
 * words
 * Date: 04.02.18
 */

namespace Components\Interaction\Projects\FindProject;


use Components\Infrastructure\Request\IRequest;
use Components\Infrastructure\Response\ErrorResponse;
use Components\Infrastructure\Response\IResponse;
use Components\Interaction\Resource\ResourceHandler;
use Components\Resource\IProjectManager;

/**
 * Class FindProjectHandler
 * @property IProjectManager $manager
 */
class FindProjectHandler extends ResourceHandler
{

    /**
     * @param FindProjectRequest|IRequest $request
     *
     * @return mixed
     */
    public function handle(IRequest $request)
    {
        if( ! $match = $this->manager->getProject($request->getPayload())) {
            return new ErrorResponse('Unable to find project', IResponse::STATUS_NOT_FOUND);
        }

        return new FindProjectResponse($match, $request);
    }
}