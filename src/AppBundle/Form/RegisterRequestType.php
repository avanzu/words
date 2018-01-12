<?php
/**
 * RegisterRequestType.php
 * restfully
 * Date: 17.09.17
 */

namespace AppBundle\Form;


use Components\Interaction\Users\Register\RegisterRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('payload', RegisterType::class, [ 'label' => false ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'        => RegisterRequest::class,
                'validation_groups' => ['Default', 'register'],
            ]
        );
    }


}