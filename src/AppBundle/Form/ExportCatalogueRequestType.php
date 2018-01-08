<?php
/**
 * ExportCatalogueRequestType.php
 * words
 * Date: 07.01.18
 */

namespace AppBundle\Form;


use Components\Interaction\Translations\ExportCatalogue\ExportCatalogueRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExportCatalogueRequestType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           ->add('selection', CatalogueSelectionType::class, ['label' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'      => ExportCatalogueRequest::class,
            ]
        );
    }

    public function getBlockPrefix()
    {
        return 'export_catalogue';
    }


}