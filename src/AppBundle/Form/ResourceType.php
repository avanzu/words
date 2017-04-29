<?php
/**
 * ResourceType.php
 * restfully
 * Date: 29.04.17
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResourceType extends AbstractType
{

    protected $dataClass;

    /**
     * @return mixed
     */
    public function getDataClass()
    {
        return $this->dataClass;
    }

    /**
     * @param mixed $dataClass
     *
     * @return $this
     */
    public function setDataClass($dataClass)
    {
        $this->dataClass = $dataClass;

        return $this;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', $this->getDataClass());
    }

}