<?php
/**
 * RegistrationController.php
 * restfully
 * Date: 29.04.17
 */

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Event\UserEvent;
use AppBundle\Form\RegisterType;
use AppBundle\Manager\UserManager;
use AppBundle\Traits\AutoLogin;
use AppBundle\Traits\TemplateAware as TemplateTrait;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

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

        return $this->render($this->getTemplate(), [
            'form'  => $form->createView(),
            'model' => $user,
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