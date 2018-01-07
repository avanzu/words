<?php
/**
 * CatalogueChoiceType.php
 * words
 * Date: 07.01.18
 */

namespace AppBundle\Form;

use Components\Resource\ITransUnitManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CatalogueChoiceType extends AbstractType
{
    /**
     * @var ITransUnitManager
     */
    protected $manager;

    /**
     * CatalogueChoiceType constructor.
     *
     * @param ITransUnitManager $manager
     */
    public function __construct(ITransUnitManager $manager) {
        $this->manager = $manager;
    }

    protected function getChoices()
    {
        $catalogues = $this->manager->loadCatalogues();
        $choices    = [];
        foreach($catalogues as $catalogue) {
            $choices[$catalogue] = $catalogue;
        }
        return $choices;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults(
                [
                    'choices' => $this->getChoices()
                ]
            );
    }

    public function getParent()
    {
        return ChoiceType::class;
    }


}