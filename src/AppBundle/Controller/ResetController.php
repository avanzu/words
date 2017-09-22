<?php
/**
 * ResetController.php
 * restfully
 * Date: 29.04.17
 */

namespace AppBundle\Controller;
use AppBundle\Form\ChangePasswordRequestType;
use AppBundle\Form\ResetPasswordRequestType;
use Components\Resource\UserManager;
use AppBundle\Traits\AutoLogin;
use AppBundle\Traits\TemplateAware as TemplateTrait;
use Components\Infrastructure\Response\ContinueCommandResponse;
use Components\Interaction\Users\ChangePassword\ChangePasswordRequest;
use Components\Interaction\Users\ResetPassword\ResetPasswordRequest;
use Components\Interaction\Users\ResetPassword\ResetPasswordResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ResetController
 * @method UserManager getManager
 */
class ResetController extends ResourceController implements TemplateAware
{
    use TemplateTrait,
        AutoLogin;


    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
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

    /**
     * @param         $token
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
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

        $this->executeAutoLogin($user);

        $this->addFlash('success', $this->trans($result->getMessage()));
        return $this->redirectToRoute('app_homepage');
    }


}