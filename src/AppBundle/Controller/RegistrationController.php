<?php
/**
 * RegistrationController.php
 * restfully
 * Date: 29.04.17
 */

namespace AppBundle\Controller;


use AppBundle\Form\RegisterRequestType;
use AppBundle\Manager\UserManager;
use AppBundle\Traits\AutoLogin;
use AppBundle\Traits\TemplateAware as TemplateTrait;
use Components\Interaction\Users\Register\RegisterRequest;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RegistrationController
 * @method UserManager getManager
 */
class RegistrationController extends ResourceController implements TemplateAware
{
    use TemplateTrait,
        AutoLogin;

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request)
    {

        $command = new RegisterRequest();
        $form    = $this->createForm(RegisterRequestType::class);
        $result  = $this->getInteractionResponse($form, $request, $command);
        if( $result->isSuccessful() ) {
            $this->addFlash('success', $this->trans($result->getMessage()));
            return $this->redirectToRoute('app_homepage');
        }

        /*

        $user = $this->getManager()->createNew();
        $form = $this->createForm(RegisterType::class, $user);

        if( $this->handleForm( $request, $form, $user ) ) {

            $this->getManager()->registerUser($user);

            $message = $this->trans(
                'user.registration.success', [
                    '%username%' => $user->getUsername(),
                    '%email%'    => $user->getEmail()
            ]);

            $this->addFlash('success', $message);
            return $this->redirectToRoute('app_homepage');

        }
        */

        return $this->render($this->getTemplate(), [
            'form'    => $form->createView(),
            'command' => $command,
            'result'  => $result,
        ]);
    }

    /**
     * @param         $token
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function activateAction($token, Request $request) {

        $user = $this->getManager()->loadUserByToken($token);
        $this->throw404Unless($user);
        $this->getManager()->activateUser($user);

        $this->executeAutoLogin($user);

        $message = $this->trans('user.activation.success', [
            '%username%' => $user->getUsername(),
        ]);

        $this->addFlash('success', $message);

        return $this->redirectToRoute('app_homepage');

    }

}