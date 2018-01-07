<?php
/**
 * TransValueType.php
 * words
 * Date: 07.01.18
 */

namespace AppBundle\Form;


use AppBundle\Entity\TransUnit;
use AppBundle\Entity\TransValue;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransValueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextareaType::class, [
                /** @Desc('Translated message') */
                'label' => 'trans.value.label.content'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => TransValue::class
            ]
        );
    }


}