<?php
/**
 * ValidatingCommandBus.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Infrastructure;


use Components\Infrastructure\Request\IRequest;
use Components\Infrastructure\Response\IResponse;
use Components\Infrastructure\Response\ValidationFailedResponse;
use Components\Resource\Validator\IValidator;

class ValidatingCommandBus implements ICommandBus
{
    /**
     * @var ICommandBus
     */
    protected $bus;

    /**
     * @var IValidator
     */
    protected $validator;

    /**
     * ValidatingCommandBus constructor.
     *
     * @param ICommandBus $bus
     * @param IValidator  $validator
     */
    public function __construct(ICommandBus $bus, IValidator $validator)
    {
        $this->bus       = $bus;
        $this->validator = $validator;
    }

    /**
     * @param IRequest $request
     *
     * @return IResponse
     * @throws ValidationFailedResponse
     */
    public function execute(IRequest $request)
    {
        $result = $this->validator->validate($request);
        if( ! $result->isValid() ) {
            return new ValidationFailedResponse($result);
        }

        return $this->bus->execute($request);
    }


}