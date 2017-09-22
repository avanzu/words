<?php
/**
 * ChangePasswordHandler.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Interaction\Users\ChangePassword;


use Components\Resource\UserManager;
use Components\Infrastructure\Events\Notifier;
use Components\Infrastructure\Events\ResourceMessage;
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
     * @var Notifier
     */
    protected $notifier;

    /**
     * ChangePasswordHandler constructor.
     *
     * @param Notifier $notifier
     */
    public function __construct(Notifier $notifier) {
        $this->notifier = $notifier;
    }


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
            $response      = new ChangePasswordResponse($user, $request, CommandResponse::STATUS_ACCEPTED);

            $user->setPassword($encoded)->setToken(null);
            $manager->save($user);

            $this->notifier->notify(new ResourceMessage($request, $response));

            $manager->commitTransaction();

            return $response;


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