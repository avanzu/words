<?php
/**
 * ResetController.php
 * restfully
 * Date: 29.04.17
 */

namespace AppBundle\Controller;
use AppBundle\Form\ResetPasswordType;
use AppBundle\Form\ResetType;
use AppBundle\Form\UserLookupType;
use AppBundle\Manager\UserManager;
use AppBundle\Traits\AutoLogin;
use AppBundle\Traits\TemplateAware as TemplateTrait;
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
        $form = $this->createForm(UserLookupType::class, null, ['manager' => $this->getManager() ]);
        if( $this->handleForm($request, $form) ) {
            $this->getManager()->enableReset($form->get('user')->getData());
            $message = $this->trans('user.reset.initialized');
            $this->addFlash('success', $message);
            return $this->redirectToRoute('app_homepage');
        }

        return $this->render($this->getTemplate(), [
           'form' => $form->createView()
        ]);

    }

    public function changePasswordAction($token, Request $request)
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