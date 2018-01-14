<?php
/**
 * ProfileType.php
 * words
 * Date: 14.01.18
 */

namespace AppBundle\Form;


use AppBundle\Entity\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gender', GenderChoiceType::class, [
                /** @Desc("Gender") */
                'label' => 'profile.label.gender'
            ])
            ->add('firstName', TextType::class, [
                /** @Desc("Firstname") */
                'label' => 'profile.label.first_name'
            ])
            ->add('lastName', TextType::class, [
                /** @Desc("Lastname") */
                'label' => 'profile.label.last_name'
            ])
            ->add('avatar', AvatarChoiceType::class, [
                /** @Desc("Avatar") */
                'label' => 'profile.label.avatar'
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Profile::class
            ]
        );
    }


}