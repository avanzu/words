<?php
/**
 * ResourceController.php
 * restfully
 * Date: 29.04.17
 */

namespace AppBundle\Controller;


use AppBundle\Manager\ResourceManager;
use Components\Infrastructure\Request\CommandRequest;
use Components\Infrastructure\Response\CommandResponse;
use Components\Infrastructure\Response\ContinueCommandResponse;
use Components\Infrastructure\Response\ErrorCommandResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class ResourceController extends Controller
{

    /**
     * @var ResourceManager
     */
    protected $manager;

    /**
     * ResourceController constructor.
     *
     * @param ResourceManager $manager
     */
    public function __construct(ResourceManager $manager) {
        $this->manager = $manager;
    }

    /**
     * @return ResourceManager
     */
    protected function getManager()
    {
        return $this->manager;
    }

    /**
     * @param        $condition
     * @param string $message
     *
     * @return mixed
     */
    protected function throw404Unless($condition, $message = 'Not Found')
    {
        if( ! $condition ) {
            throw $this->createNotFoundException($message);
        }

        return $condition;
    }


    /**
     * @param         $model
     * @param Request $request
     * @param         $intent
     */
    protected function saveModel($model, Request $request, $intent)
    {
        $this->preSaveModel($model, $request, $intent);
        $this->getManager()->save($model, true, $intent);
        $this->postSaveModel($model, $request, $intent);
    }

    /**
     * @param Request $request
     * @param Form    $form
     * @param         $model
     * @param null    $intent
     *
     * @return bool
     */
    protected function handleForm(Request $request, Form $form, $model = null, $intent = null)
    {
        $form->handleRequest($request);

        if( ! $form->isSubmitted() ) {
            return false;
        }

        if( ! $form->isValid() ) {
            return false;
        }

        return true;
    }

    /**
     * @param         $model
     * @param Request $request
     * @param null    $intent
     */
    protected function preSaveModel($model, Request $request, $intent = null)
    {}

    /**
     * @param         $model
     * @param Request $request
     * @param null    $intent
     */
    protected function postSaveModel($model, Request $request, $intent = null)
    {}

    /**
     * Translator shorthand method
     *
     * @param        $token
     * @param array  $args
     * @param string $catalog
     *
     * @return string
     */
    protected function trans($token, $args = [], $catalog = 'messages')
    {
        return $this->get('translator')->trans($token, $args, $catalog);
    }

    /**
     * Translator shorthand method
     *
     * @param        $token
     * @param        $num
     * @param        $args
     * @param string $catalog
     *
     * @return string
     */
    protected function transChoice($token, $num, $args, $catalog = 'messages')
    {
        return $this->get('translator')->transChoice($token, $num, $args, $catalog);
    }

    /**
     * @param Form                   $form
     * @param CommandRequest|Request $request
     * @param CommandRequest         $command
     *
     * @return CommandResponse
     */
    protected function getInteractionResponse(Form $form, Request $request, CommandRequest $command)
    {
        $form->handleRequest($request);
        if( ! $form->isSubmitted() ) {
            return new ContinueCommandResponse();
        }
        try {
            return $this->get('app.command_bus')->execute($form->getData());
        }  catch(ErrorCommandResponse $error) {
            return $error;
        }

    }

}