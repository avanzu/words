<?php
/**
 * InteractiveTrait.php
 * words
 * Date: 14.01.18
 */

namespace AppBundle\Traits;


use Components\Infrastructure\ICommandBus;
use Components\Infrastructure\Request\IRequest;
use Components\Infrastructure\Response\ContinueCommandResponse;
use Components\Infrastructure\Response\ErrorResponse;
use Components\Infrastructure\Response\IResponse;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

trait InteractiveTrait
{
    /**
     * @var ICommandBus
     */
    protected $commandBus;

    /**
     * @param Form|FormInterface $form
     * @param IRequest|Request   $request
     * @param IRequest           $command
     *
     * @return IResponse
     */
    protected function getInteractionResponse(Form $form, Request $request, IRequest $command)
    {
        $form->handleRequest($request);

        if( ! $form->isSubmitted() ) {
            return new ContinueCommandResponse();
        }

        return $this->executeCommand($form->getData());

    }

    /**
     * @param IRequest $request
     *
     * @return IResponse|ErrorResponse|\Exception
     */
    public function executeCommand(IRequest $request)
    {
        try {
            return $this->commandBus->execute($request);
        }  catch(ErrorResponse $error) {
            return $error;
        }
    }
}