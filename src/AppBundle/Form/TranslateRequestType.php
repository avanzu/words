<?php
/**
 * TranslateRequestType.php
 * words
 * Date: 08.01.18
 */

namespace AppBundle\Form;


use Components\Interaction\Translations\Translate\TranslateRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TranslateRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('locale')
            ->add('localeString')
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => TranslateRequest::class
            ]
        );
    }


}