<?php
/**
 * Translator.php
 * restfully
 * Date: 26.09.17
 */

namespace AppBundle\Localization;


use Components\Localization\ITranslator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Translation\TranslatorInterface;

class Translator implements ITranslator
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Translator constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container) { $this->container = $container; }


    /**
     * @param        $token
     * @param array  $arguments
     * @param string $catalog
     *
     * @return string
     */
    public function translate($token, array $arguments = [], $catalog = 'messages')
    {
        return $this->getTranslator()->trans($token, $arguments, $catalog);
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
        return $this->getTranslator()->transChoice($token, $count, $arguments, $catalog);
    }

    /**
     * @return TranslatorInterface
     */
    protected function getTranslator()
    {
        return $this->container->get('translator');
    }
}

