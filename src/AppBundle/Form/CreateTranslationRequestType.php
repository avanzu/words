<?php
/**
 * CreateTranslationRequestType.php
 * words
 * Date: 07.01.18
 */

namespace AppBundle\Form;


use Components\Interaction\Translations\CreateTranslation\CreateTranslationRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateTranslationRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dao', TransUnitType::class, ['label' => false]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => CreateTranslationRequest::class
            ]
        );
    }


}