<?php
/**
 * ResetController.php
 * restfully
 * Date: 29.04.17
 */

namespace AppBundle\Controller;
use AppBundle\Form\ChangePasswordRequestType;
use AppBundle\Form\ResetPasswordRequestType;
use AppBundle\Form\ResetPasswordType;
use AppBundle\Form\ResetType;
use AppBundle\Form\UserLookupType;
use AppBundle\Manager\UserManager;
use AppBundle\Traits\AutoLogin;
use AppBundle\Traits\TemplateAware as TemplateTrait;
use Components\Infrastructure\ContinueCommandResponse;
use Components\Interaction\Users\ResetPassword\ChangePasswordRequest;
use Components\Interaction\Users\ResetPassword\ResetPasswordRequest;
use Components\Interaction\Users\ResetPassword\ResetPasswordResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ResetController
 * @method UserManager getManager
 */
class ResetController extends ResourceController implements TemplateAware
{
    use TemplateTrait,
        AutoLogin;


    public function resetAction(Request $request)
    {

        $command = new ResetPasswordRequest();
        $form    = $this->createForm(ResetPasswordRequestType::class, $command, [ 'manager' => $this->getManager() ]);

        /** @var ResetPasswordResponse|ContinueCommandResponse $result */
        $result = $this->getInteractionResponse($form, $request, $command);

        if( ! $result->isSuccessful() ) {
            return $this->render($this->getTemplate(), [
                'form'    => $form->createView(),
                'command' => $command,
                'result'  => $result
            ]);
        }

        $this->addFlash('success', $this->trans($result->getMessage()));
        return $this->redirectToRoute('app_homepage');
    }

    public function changePasswordAction($token, Request $request) {

        $user = $this->getManager()->loadUserByToken($token);
        $this->throw404Unless($user);

        $command = new ChangePasswordRequest($user);
        $form    = $this->createForm(ChangePasswordRequestType::class, $command);

        $result = $this->getInteractionResponse($form, $request, $command);
        if( ! $result->isSuccessful() ) {
            return $this->render($this->getTemplate(), [
                'form'    => $form->createView(),
                'command' => $command,
                'result'  => $result
            ]);
        }

        $this->addFlash('success', $this->trans($result->getMessage()));
        return $this->redirectToRoute('app_homepage');
    }

    public function __changePasswordAction($token, Request $request)
    {

        $user = $this->getManager()->loadUserByToken($token);
        $this->throw404Unless($user);
        $form = $this->createForm(ResetPasswordType::class, $user);
        if( $this->handleForm( $request, $form) ) {
            $this->getManager()->resetUser($user);

            $this->executeAutoLogin($user);

            $message = $this->trans('user.reset.done');
            $this->addFlash('success', $message);

            return $this->redirectToRoute('app_homepage');

        }

        return $this->render($this->getTemplate(), [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

}