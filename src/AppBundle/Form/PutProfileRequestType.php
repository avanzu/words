<?php
/**
 * PutProfileRequestType.php
 * words
 * Date: 14.01.18
 */

namespace AppBundle\Form;


use Components\Interaction\Users\PutProfile\PutProfileRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PutProfileRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('payload', ProfileType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => PutProfileRequest::class
            ]
        );
    }

    public function getBlockPrefix()
    {
        return '';
    }


}