<?php
/**
 * ProjectChoiceType.php
 * words
 * Date: 07.01.18
 */

namespace AppBundle\Form;


use AppBundle\Entity\Project;
use AppBundle\Repository\ResourceRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectChoiceType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'class'         => Project::class,
                'query_builder' => function(ResourceRepository $repository) {
                    return $repository->createQueryBuilder('project')->addOrderBy('project.name');
                }
            ]
        );
    }

    public function getParent()
    {
        return EntityType::class;
    }


}