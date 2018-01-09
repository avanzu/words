<?php
/**
 * TransUnitType.php
 * words
 * Date: 07.01.18
 */

namespace AppBundle\Form;


use AppBundle\Entity\TransUnit;
use AppBundle\Manager\TransUnitManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransUnitType extends AbstractType
{

    /**
     * @var  TransUnitManager
     */
    protected $manager;

    /**
     * TransUnitType constructor.
     *
     * @param TransUnitManager $manager
     */
    public function __construct(TransUnitManager $manager) {
        $this->manager = $manager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('key', TextType::class, [
                /** @Desc(Translation key) */
                'label' => 'trans.unit.label.key'
            ])
            ->add('sourceString', TextareaType::class, [
                /** @Desc("Source string") */
                'label'    => 'trans.unit.source.string',
                'required' => false,
            ])
            ->add('description', TextareaType::class, [
                /** @Desc("Description or meaning") */
                'label'    => 'trans.unit.label.description',
                'required' => false,
            ])
            ->add('catalogue', TextType::class, [
                /** @Desc("Message catalogue") */
                'label' => 'trans.unit.label.catalogue',
            ])
            ->add('project', ProjectChoiceType::class, [
                /** @Desc("Project") */
                'label'       => 'trans.unit.label.project',
            ])
            ;
    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => TransUnit::class
            ]
        );

    }


}