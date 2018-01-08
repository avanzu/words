<?php
/**
 * TransUnit.php
 * words
 * Date: 07.01.18
 */

namespace AppBundle\Entity;
use Components\Model\TransUnit as TransUnitModel;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

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

    public function getTranslation($locale)
    {
        $criteria  = Criteria::create();
        $criteria->where(Criteria::expr()->eq('locale', $locale));
        return $this->translations->matching($criteria)->first();
    }


}