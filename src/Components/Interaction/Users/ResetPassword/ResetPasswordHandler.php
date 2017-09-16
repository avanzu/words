<?php
/**
 * ResetPasswordHandler.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Interaction\Users\ResetPassword;


use AppBundle\Manager\UserManager;
use Components\Infrastructure\Events\MessageSender;
use Components\Infrastructure\Events\Notifier;
use Components\Infrastructure\Request\CommandRequest;
use Components\Infrastructure\Response\CommandResponse;
use Components\Infrastructure\Response\ErrorCommandResponse;
use Components\Interaction\Resource\ResourceHandler;

/**
 * Class ResetPasswordHandler
 * @method UserManager getManager()
 */
class ResetPasswordHandler extends ResourceHandler implements MessageSender
{
    /**
     * @var Notifier
     */
    protected $notifier;

    /**
     * @param CommandRequest|ResetPasswordRequest $request
     *
     * @return mixed
     */
    public function handle(CommandRequest $request)
    {
        $manager = $this->getManager();
        $manager->startTransaction();
        try {
            $user = $request->getUser();
            $user->setToken(uniqid($request->getIntention()));
            $this->getManager()->save($user);

            $manager->commitTransaction();

            return new ResetPasswordResponse($user, $request);

        }
        catch (\Exception $exception) {

            $manager->cancelTransaction();

            return new ErrorCommandResponse(
                'Reset token assignment failed.',
                CommandResponse::STATUS_INTERNAL_SERVER_ERROR,
                $exception
            );
        }

    }

    public function setNotifier(Notifier $notifier)
    {
        $this->notifier = $notifier;
    }
}