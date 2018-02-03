<?php
/**
 * UpdateProjectRequestType.php
 * words
 * Date: 07.01.18
 */

namespace AppBundle\Form;


use Components\Interaction\Projects\UpdateProject\UpdateProjectRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateProjectRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('payload', ProjectType::class, ['label' => false]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'         => UpdateProjectRequest::class,
                'allow_extra_fields' => true,
            ]
        );
    }

    public function getBlockPrefix()
    {
        return '';
    }


}