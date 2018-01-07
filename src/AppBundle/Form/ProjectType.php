<?php
/**
 * ProjectType.php
 * words
 * Date: 07.01.18
 */

namespace AppBundle\Form;


use AppBundle\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                /* @Desc("Project name") */
                'label' => 'project.label.name',
            ])
            ->add('description', TextareaType::class, [
                /** @Desc("Project description") */
                'label'    => 'project.label.description',
                'required' => false
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Project::class
            ]
        );

    }


}