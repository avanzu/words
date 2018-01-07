<?php
/**
 * ResetController.php
 * restfully
 * Date: 29.04.17
 */

namespace AppBundle\Controller;

use AppBundle\Form\ChangePasswordRequestType;
use AppBundle\Form\ResetPasswordRequestType;
use AppBundle\Presentation\ResultFlashBuilder;
use AppBundle\Traits\AutoLogin;
use AppBundle\Traits\Flasher;
use AppBundle\Traits\TemplateAware as TemplateTrait;
use AppBundle\Presentation\ViewHandlerTemplate as TemplateView;
use Components\Infrastructure\Response\ContinueCommandResponse;
use Components\Interaction\Users\ChangePassword\ChangePasswordRequest;
use Components\Interaction\Users\ResetPassword\ResetPasswordRequest;
use Components\Interaction\Users\ResetPassword\ResetPasswordResponse;
use Components\Resource\IUserManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ResetController
 * @method IUserManager getManager
 */
class ResetController extends ResourceController implements ITemplateAware, IFlashing
{
    use TemplateTrait,
        Flasher,
        AutoLogin;



    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function resetAction(Request $request)
    {

        $command = new ResetPasswordRequest();
        $form    = $this->createForm(
            ResetPasswordRequestType::class,
            $command,
            ['manager' => $this->getManager()]
        );

        /** @var ResetPasswordResponse|ContinueCommandResponse $result */
        $result = $this->getInteractionResponse($form, $request, $command);

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
    public function changePasswordAction($token, Request $request)
    {

        $user = $this->getManager()->loadUserByToken($token);
        $this->throw404Unless($user);

        $command = new ChangePasswordRequest($user);
        $form    = $this->createForm(ChangePasswordRequestType::class, $command);

        $result = $this->getInteractionResponse($form, $request, $command);

        if ($result->isSuccessful()) {
            $this->executeAutoLogin($user);
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


}