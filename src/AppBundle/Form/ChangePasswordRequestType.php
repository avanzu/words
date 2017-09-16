<?php
/**
 * ChangePasswordRequestType.php
 * restfully
 * Date: 16.09.17
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ChangePasswordRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('plainPassword', ResetPasswordType::class, ['inherit_data' => true]);
    }


}