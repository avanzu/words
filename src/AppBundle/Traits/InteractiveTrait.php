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
use Symfony\Component\HttpFoundation\Response;

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

    protected function createSuccessResponse(IResponse $response, Request $request)
    {

        if(! $response->isSuccessful()) {
            return null;
        }
        // ignore GET and HEAD which will be handled by outer flow
        if( in_array($request->getMethod(), [Request::METHOD_GET, Request::METHOD_HEAD])){
            return null;
        }

        if( $request->isXmlHttpRequest() ) {
            return new Response('', Response::HTTP_NO_CONTENT);
        }

        $this->flash($response);
        return $this->redirectToRoute($this->getRedirect());

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