<?php
/**
 * LazyMessageCatalogue.php
 * words
 * Date: 07.01.18
 */

namespace AppBundle\Localization;


use Components\Localization\IMessage;
use Components\Localization\IMessageCatalogue;
use JMS\TranslationBundle\Model\MessageCatalogue as JmsMessages;
use JMS\TranslationBundle\Model\MessageCollection;

class LazyMessageCatalogue extends JmsMessages implements IMessageCatalogue
{
    /**
     * @var string
     */
    protected $locale;
    /**
     * @var string
     */
    protected $catalog;

    /**
     * @var
     */
    protected $messages;

    /**
     * LazyMessageCatalogue constructor.
     *
     * @param string $locale
     * @param string $catalog
     * @param        $messages
     */
    public function __construct($locale, $catalog, $messages)
    {
        $this->locale   = $locale;
        $this->catalog  = $catalog;
        $this->messages = $messages;

    }


    /**
     * @return IMessage[]
     */
    public function getMessages()
    {
        if( is_callable($this->messages)) {
            $this->messages = iterator_to_array(call_user_func($this->messages));
        }
        return $this->messages;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @return string
     */
    public function getCatalog()
    {
        return $this->catalog;
    }

    public function hasDomain($domain)
    {
        return $this->catalog === $domain;
    }

    public function getDomain($domain)
    {
        if( $this->catalog !== $domain )
            return null;

        $collection = new MessageCollection();
        $collection->setCatalogue($this);
        $collection->replace($this->getMessages());
        return $collection;
    }


    /**
     * @return array
     */
    public function getDomains()
    {
        return [$this->catalog];
    }


}