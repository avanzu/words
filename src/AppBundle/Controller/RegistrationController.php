<?php
/**
 * RegistrationController.php
 * restfully
 * Date: 29.04.17
 */

namespace AppBundle\Controller;


use AppBundle\Form\RegisterRequestType;
use AppBundle\Traits\AutoLogin;
use AppBundle\Traits\Flasher;
use AppBundle\Traits\TemplateAware as TemplateTrait;
use AppBundle\Presentation\ViewHandlerTemplate as TemplateView;
use Components\Interaction\Users\Activate\ActivateRequest;
use Components\Interaction\Users\Register\RegisterRequest;
use Components\Resource\IUserManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RegistrationController
 * @method IUserManager getManager
 */
class RegistrationController extends ResourceController implements ITemplateAware, IFlashing
{
    use TemplateTrait,
        Flasher,
        AutoLogin;

    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function registerAction(Request $request)
    {

        $command = new RegisterRequest();
        $form    = $this->createForm(RegisterRequestType::class);
        $result  = $this->getInteractionResponse($form, $request, $command);
        if ($result->isSuccessful()) {
            $this->flash($result);
            return $this->redirectToRoute('app_homepage');
        }

        $view = new TemplateView($this->getTemplate(), $request, [
            'form'    => $form->createView(),
            'command' => $command,
            'result'  => $result,
        ]);
        return $this->createResponse($view);
    }

    /**
     * @param         $token
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function activateAction($token, Request $request)
    {

        $user = $this->getManager()->loadUserByToken($token);

        $this->throw404Unless($user);

        $command = new ActivateRequest($user);
        $result  = $this->executeCommand($command);
        if ($result->isSuccessful()) {

            $this->executeAutoLogin($user);
            $this->flash($result);
            return $this->redirectToRoute('app_homepage');

        }

        return new Response($result->getMessage(), $result->getStatus());
    }

}