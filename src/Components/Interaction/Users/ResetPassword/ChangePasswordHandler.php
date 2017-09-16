<?php
/**
 * ChangePasswordHandler.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Interaction\Users\ResetPassword;


use AppBundle\Manager\UserManager;
use Components\Infrastructure\Request\CommandRequest;
use Components\Infrastructure\Response\CommandResponse;
use Components\Infrastructure\Response\ErrorCommandResponse;
use Components\Interaction\Resource\ResourceHandler;
use Components\Model\User;

/**
 * @method UserManager getManager()
 */
class ChangePasswordHandler extends ResourceHandler
{

    /**
     * @param CommandRequest|ChangePasswordRequest $request
     *
     * @return mixed
     */
    public function handle(CommandRequest $request)
    {
        $manager = $this->getManager();
        $manager->startTransaction();

        try {
            /** @var User $user */
            $user          = $request->getDao();
            $plainPassword = $request->getPlainPassword();
            $encoded       = $this->getManager()->encodePassword($user, $plainPassword);

            $user->setPassword($encoded)->setToken(null);
            $manager->save($user);

            $manager->commitTransaction();

            return new ChangePasswordResponse($user, $request, CommandResponse::STATUS_ACCEPTED);

        } catch(\Exception $exception) {

            $manager->cancelTransaction();

            return new ErrorCommandResponse(
                'Password change failed.',
                CommandResponse::STATUS_INTERNAL_SERVER_ERROR,
                $exception
            );
        }

    }
}