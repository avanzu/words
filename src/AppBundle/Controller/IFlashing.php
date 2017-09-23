<?php
/**
 * IFlashing.php
 * restfully
 * Date: 23.09.17
 */

namespace AppBundle\Controller;


use AppBundle\Presentation\ResultFlashBuilder;

interface IFlashing
{
    /**
     * @param ResultFlashBuilder $builder
     */
    public function setFlasher(ResultFlashBuilder $builder);

    /**
     * @return ResultFlashBuilder
     */
    public function getFlasher();

}