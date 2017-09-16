<?php
/**
 * ResetType.php
 * restfully
 * Date: 29.04.17
 */

namespace AppBundle\Form;


use AppBundle\Entity\User;
use AppBundle\Form\DataTransformer\UserCriteriaTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserLookupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /*
        $builder
            ->add(
                $builder->create('user', TextType::class, [
                'label'       => 'label.username_or_email',
                'required'    => true,
                'constraints' => [new NotBlank(['message' => 'constraint.error.user_not_found'])],
                'mapped'      => false,
                ])
                ->addModelTransformer(new UserCriteriaTransformer($options['manager']))
            );
        */
            $builder->addModelTransformer(new UserCriteriaTransformer($options['manager']));


    }

    public function getParent()
    {
        return TextType::class;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

               'label'       => 'label.username_or_email',
               'required'    => true,

            // 'data_class' => User::class,
            //'mapped'     => false
        ]);

        $resolver->setDefined('manager')->setRequired('manager');
    }

}