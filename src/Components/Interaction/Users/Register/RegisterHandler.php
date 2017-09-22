<?php
/**
 * RegisterHandler.php
 * restfully
 * Date: 17.09.17
 */

namespace Components\Interaction\Users\Register;


use Components\Resource\UserManager;
use Components\Infrastructure\Events\Notifier;
use Components\Infrastructure\Events\ResourceMessage;
use Components\Infrastructure\Request\CommandRequest;
use Components\Infrastructure\Response\ErrorCommandResponse;
use Components\Infrastructure\Response\Response;
use Components\Infrastructure\Response\ValidationFailedResponse;
use Components\Interaction\Resource\ResourceHandler;

/**
 * Class RegisterHandler
 * @method UserManager getManager()
 */
class RegisterHandler extends ResourceHandler
{

    /**
     * @var Notifier
     */
    protected $notifier;

    /**
     * RegisterHandler constructor.
     *
     * @param Notifier $notifier
     */
    public function __construct(Notifier $notifier) {
        $this->notifier = $notifier;
    }

    /**
     * @param CommandRequest|RegisterRequest $request
     *
     * @return mixed
     */
    public function handle(CommandRequest $request)
    {
        $manager  = $this->getManager();
        $resource = $request->getDao();
        $result   = $manager->validate($resource, ['Default', $request->getIntention()]);
        $response = new RegisterResponse($resource, $request);

        if( ! $result->isValid() ) {
            return new ValidationFailedResponse($result);
        }

        $manager->startTransaction();
        try {
            $password = $manager->encodePassword($resource, $resource->getPlainPassword());
            $token    = uniqid($request->getIntention());

            $resource->setPassword($password)->setToken($token);

            $manager->save($resource);
            $this->notifier->notify(new ResourceMessage($request, $response));
            $manager->commitTransaction();

        } catch(\Exception $e) {
            $manager->cancelTransaction();
            return new ErrorCommandResponse('Registration failed.', Response::STATUS_INTERNAL_SERVER_ERROR, $e);
        }

        return $response;
    }
}