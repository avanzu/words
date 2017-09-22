<?php
/**
 * RegistrationController.php
 * restfully
 * Date: 29.04.17
 */

namespace AppBundle\Controller;


use AppBundle\Form\RegisterRequestType;
use AppBundle\Traits\AutoLogin;
use AppBundle\Traits\TemplateAware as TemplateTrait;
use Components\Infrastructure\Presentation\TemplateView;
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
class RegistrationController extends ResourceController implements ITemplateAware
{
    use TemplateTrait,
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
            $this->addFlash('success', $this->trans($result->getMessage()));

            return $this->redirectToRoute('app_homepage');
        }

        $view = new TemplateView($this->getTemplate(), [
            'form'    => $form->createView(),
            'command' => $command,
            'result'  => $result,
        ]);
        return new Response($this->getPresenter()->show($view));
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
            $this->addFlash('success', $result->getMessage());

            return $this->redirectToRoute('app_homepage');
        }

        return new Response($result->getMessage(), $result->getStatus());
    }

}