<?php
/**
 * MessageLoader.php
 * words
 * Date: 07.01.18
 */

namespace AppBundle\Localization;

use Components\Localization\IMessageLoader;
use JMS\TranslationBundle\Translation\Loader\LoaderInterface;

class MessageLoader implements IMessageLoader
{
    /**
     * @var LoaderInterface
     */
    protected $loader;

    /**
     * MessageLoader constructor.
     *
     * @param LoaderInterface $loader
     */
    public function __construct(LoaderInterface $loader) {
        $this->loader = $loader;
    }

    public function loadCatalogue($file)
    {
        $resource = new FileResource($file);
        $messages = $this->loader->load($resource->getFileName(), $resource->getLocale(), $resource->getCatalog());
        return new MessageCatalogue($resource->getCatalog(), $messages);

    }

}