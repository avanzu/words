<?php
/**
 * CreateProjectRequestType.php
 * words
 * Date: 07.01.18
 */

namespace AppBundle\Form;


use Components\Interaction\Projects\CreateProject\CreateProjectRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateProjectRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('payload', ProjectType::class, ['label' => false])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => CreateProjectRequest::class,
                'validation_groups' => ["Default", "create"]
            ]
        );
    }

    public function getBlockPrefix()
    {
        return '';
    }


}