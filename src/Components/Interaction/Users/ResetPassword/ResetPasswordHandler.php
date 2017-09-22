<?php
/**
 * ResetPasswordHandler.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Interaction\Users\ResetPassword;


use Components\Resource\IUserManager;
use Components\Infrastructure\Events\INotifier;
use Components\Infrastructure\Events\ResourceMessage;
use Components\Infrastructure\Request\IRequest;
use Components\Infrastructure\Response\IResponse;
use Components\Infrastructure\Response\ErrorResponse;
use Components\Interaction\Resource\ResourceHandler;

/**
 * Class ResetPasswordHandler
 * @method IUserManager getManager()
 */
class ResetPasswordHandler extends ResourceHandler
{

    /**
     * @var INotifier
     */
    protected $notifier;

    /**
     * ResetPasswordHandler constructor.
     *
     * @param INotifier $notifier
     */
    public function __construct(INotifier $notifier) {
        $this->notifier = $notifier;
    }


    /**
     * @param IRequest|ResetPasswordRequest $request
     *
     * @return mixed
     */
    public function handle(IRequest $request)
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

            return new ErrorResponse(
                'Reset token assignment failed.',
                IResponse::STATUS_INTERNAL_SERVER_ERROR,
                $exception
            );
        }

    }

}