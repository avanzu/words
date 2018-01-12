<?php
/**
 * ChangePasswordHandler.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Interaction\Users\ChangePassword;


use Components\Infrastructure\Exception\ResourceNotFoundException;
use Components\Resource\IUserManager;
use Components\Infrastructure\Events\INotifier;
use Components\Infrastructure\Events\ResourceMessage;
use Components\Infrastructure\Request\IRequest;
use Components\Infrastructure\Response\IResponse;
use Components\Infrastructure\Response\ErrorResponse;
use Components\Interaction\Resource\ResourceHandler;
use Components\Model\User;

/**
 * @method IUserManager getManager()
 */
class ChangePasswordHandler extends ResourceHandler
{

    /**
     * @var INotifier
     */
    protected $notifier;

    /**
     * ChangePasswordHandler constructor.
     *
     * @param INotifier $notifier
     */
    public function __construct(INotifier $notifier) {
        $this->notifier = $notifier;
    }


    /**
     * @param IRequest|ChangePasswordRequest $request
     *
     * @return mixed
     */
    public function handle(IRequest $request)
    {
        $manager = $this->getManager();
        $manager->startTransaction();

        try {
            $user          = $request->getPayload();
            $plainPassword = $request->getPlainPassword();
            $encoded       = $this->getManager()->encodePassword($user, $plainPassword);
            $response      = new ChangePasswordResponse($user, $request, IResponse::STATUS_ACCEPTED);

            $user->setPassword($encoded)->setToken(null);
            $manager->save($user);

            $this->notifier->notify(new ResourceMessage($request, $response));

            $manager->commitTransaction();

            return $response;


        } catch(\Exception $exception) {

            $manager->cancelTransaction();

            return new ErrorResponse(
                'Password change failed.',
                IResponse::STATUS_INTERNAL_SERVER_ERROR,
                $exception
            );
        }

    }
}