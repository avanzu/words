<?php
/**
 * GenderChoiceType.php
 * words
 * Date: 14.01.18
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GenderChoiceType extends AbstractType
{

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'choices' => ['choice.label.female' => 'f', 'choice.label.male' => 'm']
            ]
        );
    }

    public function getParent()
    {
        return ChoiceType::class;
    }


}