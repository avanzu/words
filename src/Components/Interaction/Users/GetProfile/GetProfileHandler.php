<?php
/**
 * GetProfileHandler.php
 * words
 * Date: 14.01.18
 */

namespace Components\Interaction\Users\GetProfile;


use Components\Infrastructure\Request\IRequest;
use Components\Infrastructure\Response\ErrorResponse;
use Components\Infrastructure\Response\IResponse;
use Components\Interaction\Resource\ResourceHandler;
use Components\Resource\IUserManager;

/**
 * Class GetProfileHandler
 * @method IUserManager getManager
 */
class GetProfileHandler extends ResourceHandler
{

    /**
     * @param IRequest|GetProfileRequest $request
     *
     * @return mixed
     */
    public function handle(IRequest $request)
    {
        $user = $request->getPayload();
        try {
            $profile = $this->getManager()->loadUserProfile($user);
            return new GetProfileResponse($profile, $request);
        } catch(\Exception $e) {
            return new ErrorResponse('Activation failed.', IResponse::STATUS_INTERNAL_SERVER_ERROR, $e);
        }
    }
}