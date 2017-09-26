<?php
/**
 * AbstractLocalizer.php
 * restfully
 * Date: 26.09.17
 */

namespace Components\Localization;


use Components\Infrastructure\IContainer;

/**
 * Class AbstractLocalizer
 */
class Localizer implements ILocalizer
{
    /**
     * @var ITranslator
     */
    protected $translator;

    /**
     * AbstractLocalizer constructor.
     *
     * @param ITranslator $translator
     */
    public function __construct(ITranslator $translator) {
        $this->translator = $translator;
    }


    /**
     * @param        $token
     * @param array  $arguments
     * @param string $catalog
     *
     * @return string
     */
    public function translate($token, array $arguments = [], $catalog = 'messages')
    {
        return $this->translator->translate($token, $arguments, $catalog);
    }

    /**
     * @param        $token
     * @param        $count
     * @param array  $arguments
     * @param string $catalog
     *
     * @return string
     */
    public function pluralize($token, $count, array $arguments = [], $catalog = 'messages')
    {
        return $this->translator->pluralize($token, $arguments, $catalog);
    }




}