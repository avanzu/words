<?php
/**
 * RegistrationController.php
 * restfully
 * Date: 29.04.17
 */

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Form\RegisterType;
use AppBundle\Manager\UserManager;
use AppBundle\Traits\TemplateAware as TemplateTrait;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends ResourceController implements TemplateAware
{
    use TemplateTrait;

    public function registerAction(Request $request)
    {
        $user = $this->getManager()->createNew();
        $form = $this->createForm(RegisterType::class, $user);

        if( $this->handleForm( $request, $form, $user , UserManager::INTENT_REGISTER ) ) {

            $this->addFlash('success', 'Welcome aboard');
            return $this->redirectToRoute('app_homepage');

        }

        return $this->render($this->getTemplate(), [
            'form'  => $form->createView(),
            'model' => $user,
        ]);
    }


    public function activateAction(Request $request) {}
}