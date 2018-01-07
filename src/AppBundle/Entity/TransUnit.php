<?php
/**
 * TransUnit.php
 * words
 * Date: 07.01.18
 */

namespace AppBundle\Entity;
use Components\Model\TransUnit as TransUnitModel;
use Doctrine\Common\Collections\ArrayCollection;

class TransUnit extends TransUnitModel
{

    /**
     * TransUnit constructor.
     */
    public function __construct() {
        $this->translations = new ArrayCollection();
    }

    /**
     * @return string
     */
    protected function getTransValueClass()
    {
        return TransValue::class;
    }


}