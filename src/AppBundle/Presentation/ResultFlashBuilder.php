<?php
/**
 * ResultFlashBuilder.php
 * restfully
 * Date: 23.09.17
 */

namespace AppBundle\Presentation;


use Components\Infrastructure\Response\IResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class ResultFlashBuilder
 */
class ResultFlashBuilder
{

    /**
     *
     */
    const FLASH_TYPE_SUCCESS = 'success';
    /**
     *
     */
    const FLASH_TYPE_WARNING = 'warning';
    /**
     *
     */
    const FLASH_TYPE_NOTICE = 'info';
    /**
     *
     */
    const FLASH_TYPE_ERROR = 'danger';

    /**
     * @var FlashBagInterface
     */
    protected $flashBag;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * ResultFlashBuilder constructor.
     *
     * @param FlashBagInterface   $flashBag
     * @param TranslatorInterface $translator
     */
    public function __construct(FlashBagInterface $flashBag, TranslatorInterface $translator)
    {
        $this->flashBag   = $flashBag;
        $this->translator = $translator;
    }


    /**
     * @param IResponse $response
     */
    public function buildFlash(IResponse $response)
    {
        $message = $this->translator->trans($response->getMessage(), $response->getArguments());
        $this->flashBag->add($this->getFlashType($response), $message);
    }

    /**
     * @param IResponse $response
     *
     * @return string
     */
    protected function getFlashType(IResponse $response) {
        if( $response->isSuccessful() ) return static::FLASH_TYPE_SUCCESS;
        if( $response->isInformational() ) return static::FLASH_TYPE_NOTICE;
        return static::FLASH_TYPE_ERROR;
    }
}