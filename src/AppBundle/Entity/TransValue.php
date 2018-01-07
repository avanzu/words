<?php
/**
 * TransValue.php
 * words
 * Date: 07.01.18
 */

namespace AppBundle\Entity;
use Components\Model\TransValue as TransValueModel;


class TransValue extends TransValueModel
{

    /**
     * @var  int
     */
    protected $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

}