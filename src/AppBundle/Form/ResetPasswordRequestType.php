<?php
/**
 * ResetPasswordRequestType.php
 * restfully
 * Date: 16.09.17
 */

namespace AppBundle\Form;


use Components\Interaction\Users\ResetPassword\ResetPasswordRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResetPasswordRequestType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dao', UserLookupType::class, [
            'manager' => $options['manager'],
        ]);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => ResetPasswordRequest::class,
                'label'      => false,
                'manager'    => null,
            ]
        );
    }


}