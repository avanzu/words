<?php
/**
 * CatalogueSelectionType.php
 * words
 * Date: 08.01.18
 */

namespace AppBundle\Form;


use Components\DataAccess\CatalogueSelection;
use Components\Resource\ITransUnitManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Form\Extension\Core\Type\LocaleType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CatalogueSelectionType extends AbstractType
{

    /**
     * @var ITransUnitManager
     */
    protected $manager;

    /**
     * ExportCatalogueRequestType constructor.
     *
     * @param ITransUnitManager $manager
     */
    public function __construct(ITransUnitManager $manager) {
        $this->manager = $manager;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('locale', LocaleType::class, [
                'label'             => 'language',
                'preferred_choices' => $this->manager->loadLanguages(),
            ])
            ->add('catalogue', CatalogueChoiceType::class, [
                'label'             => 'catalogue',
            ])
            ->add('project', ProjectChoiceType::class, [
                'label'    => 'project',
            ])
        ;

        if( false == $options['switch_project']) {
            $builder->remove('project');
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'      => CatalogueSelection::class,
                'csrf_protection' => false,
                'switch_project'  => true
            ]
        );
    }

    public function getBlockPrefix()
    {
        return '';
    }

}