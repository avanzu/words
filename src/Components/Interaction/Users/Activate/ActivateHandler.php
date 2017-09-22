<?php
/**
 * ActivateHandler.php
 * restfully
 * Date: 17.09.17
 */

namespace Components\Interaction\Users\Activate;


use Components\Resource\IUserManager;
use Components\Infrastructure\Request\IRequest;
use Components\Infrastructure\Response\IResponse;
use Components\Infrastructure\Response\ErrorResponse;
use Components\Interaction\Resource\ResourceHandler;
use Components\Model\User;

/**
 * Class ActivateHandler
 * @method IUserManager getManager()
 */
class ActivateHandler extends ResourceHandler
{

    /**
     * @param IRequest|ActivateRequest $request
     *
     * @return mixed
     */
    public function handle(IRequest $request)
    {
        /** @var User $user */
        $user     = $request->getDao();
        $manager  = $this->getManager();
        $response = new ActivateResponse($user, $request);
        $manager->startTransaction();
        try {
            $user->setToken(null)->setIsActive(true);
            $manager->save($user);

            return $response;

        } catch(\Exception $e) {
            $manager->cancelTransaction();
            return new ErrorResponse('Activation failed.', IResponse::STATUS_INTERNAL_SERVER_ERROR, $e);
        }

    }
}