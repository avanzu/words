<?php
/**
 * Flasher.php
 * restfully
 * Date: 23.09.17
 */

namespace AppBundle\Traits;


use AppBundle\Presentation\ResultFlashBuilder;
use Components\Infrastructure\Response\IResponse;

trait Flasher
{
    /**
     * @var ResultFlashBuilder
     */
    protected $flasher;

    /**
     * @return ResultFlashBuilder
     */
    public function getFlasher()
    {
        return $this->flasher;
    }

    /**
     * @param ResultFlashBuilder $flasher
     *
     * @return $this
     */
    public function setFlasher(ResultFlashBuilder $flasher)
    {
        $this->flasher = $flasher;

        return $this;
    }

    protected function flash(IResponse $response)
    {
        $this->flasher->buildFlash($response);
    }
}