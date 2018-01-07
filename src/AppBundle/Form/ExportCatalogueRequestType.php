<?php
/**
 * ExportCatalogueRequestType.php
 * words
 * Date: 07.01.18
 */

namespace AppBundle\Form;


use Components\Interaction\Translations\ExportCatalogue\ExportCatalogueRequest;
use Components\Resource\ITransUnitManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExportCatalogueRequestType extends AbstractType
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
            ->add('locale', LanguageType::class, [
                'label'             => 'language',
                'preferred_choices' => $this->manager->loadLanguages(),
            ])
            ->add('catalogue', CatalogueChoiceType::class, [
                'label'             => 'catalogue',

            ])
            ->add('project', ProjectChoiceType::class, [
                'label'    => 'project',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'      => ExportCatalogueRequest::class,
                'csrf_protection' => false,
            ]
        );
    }

    public function getBlockPrefix()
    {
        return '';
    }


}