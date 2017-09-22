<?php
/**
 * ResetPasswordHandler.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Interaction\Users\ResetPassword;


use Components\Resource\UserManager;
use Components\Infrastructure\Events\Notifier;
use Components\Infrastructure\Events\ResourceMessage;
use Components\Infrastructure\Request\CommandRequest;
use Components\Infrastructure\Response\CommandResponse;
use Components\Infrastructure\Response\ErrorCommandResponse;
use Components\Interaction\Resource\ResourceHandler;

/**
 * Class ResetPasswordHandler
 * @method UserManager getManager()
 */
class ResetPasswordHandler extends ResourceHandler
{

    /**
     * @var Notifier
     */
    protected $notifier;

    /**
     * ResetPasswordHandler constructor.
     *
     * @param Notifier $notifier
     */
    public function __construct(Notifier $notifier) {
        $this->notifier = $notifier;
    }


    /**
     * @param CommandRequest|ResetPasswordRequest $request
     *
     * @return mixed
     */
    public function handle(CommandRequest $request)
    {
        $manager  = $this->getManager();
        $manager->startTransaction();
        try {
            $user     = $request->getUser();
            $response = new ResetPasswordResponse($user, $request);
            $user->setToken(uniqid($request->getIntention()));
            $this->getManager()->save($user);

            $this->notifier->notify(new ResourceMessage($request, $response));

            $manager->commitTransaction();

            return $response;

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

}