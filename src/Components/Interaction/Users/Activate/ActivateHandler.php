<?php
/**
 * ActivateHandler.php
 * restfully
 * Date: 17.09.17
 */

namespace Components\Interaction\Users\Activate;


use Components\Resource\UserManager;
use Components\Infrastructure\Request\CommandRequest;
use Components\Infrastructure\Response\CommandResponse;
use Components\Infrastructure\Response\ErrorCommandResponse;
use Components\Interaction\Resource\ResourceHandler;
use Components\Model\User;

/**
 * Class ActivateHandler
 * @method UserManager getManager()
 */
class ActivateHandler extends ResourceHandler
{

    /**
     * @param CommandRequest|ActivateRequest $request
     *
     * @return mixed
     */
    public function handle(CommandRequest $request)
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
            return new ErrorCommandResponse('Activation failed.', CommandResponse::STATUS_INTERNAL_SERVER_ERROR, $e);
        }

    }
}