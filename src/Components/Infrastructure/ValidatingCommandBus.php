<?php
/**
 * ValidatingCommandBus.php
 * restfully
 * Date: 16.09.17
 */

namespace Components\Infrastructure;


use Components\Infrastructure\Request\CommandRequest;
use Components\Infrastructure\Response\CommandResponse;
use Components\Infrastructure\Response\ValidationFailedResponse;
use Components\Resource\Validator\Validator;

class ValidatingCommandBus implements CommandBus
{
    /**
     * @var CommandBus
     */
    protected $bus;

    /**
     * @var Validator
     */
    protected $validator;

    /**
     * ValidatingCommandBus constructor.
     *
     * @param CommandBus $bus
     * @param Validator  $validator
     */
    public function __construct(CommandBus $bus, Validator $validator)
    {
        $this->bus       = $bus;
        $this->validator = $validator;
    }

    /**
     * @param CommandRequest $request
     *
     * @return CommandResponse
     * @throws ValidationFailedResponse
     */
    public function execute(CommandRequest $request)
    {
        $result = $this->validator->validate($request);
        if( ! $result->isValid() ) {
            return new ValidationFailedResponse($result);
        }

        return $this->bus->execute($request);
    }


}