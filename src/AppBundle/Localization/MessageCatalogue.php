<?php
/**
 * MessageCatalogue.php
 * words
 * Date: 07.01.18
 */

namespace AppBundle\Localization;


use Components\Localization\IMessage;
use Components\Localization\IMessageCatalogue;
use JMS\TranslationBundle\Model\Message as JmsMessage;
use JMS\TranslationBundle\Model\MessageCatalogue as JmsMessages;


class MessageCatalogue extends  JmsMessages implements IMessageCatalogue
{

    /**
     * @var string
     */
    protected $catalog;

    /**
     * @var JmsMessages
     */
    protected $messages;


    /**
     * MessageCatalogue constructor.
     *
     * @param string      $catalog
     * @param JmsMessages $messages
     */
    public function __construct($catalog, JmsMessages $messages)
    {
        $this->catalog  = $catalog;
        $this->messages = $messages;
    }

    /**
     * @return \Generator|IMessage[]
     */
    public function getMessages()
    {
        foreach($this->messages->getDomain($this->getCatalog())->all() as $message) {
            yield new Message($message);
        }

    }

    /**
     * @return string
     */
    public function getCatalog()
    {
        return $this->catalog;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->messages->getLocale();

    }

    public function setLocale($locale)
    {
        $this->messages->setLocale($locale);
        return $this;
    }

    public function add(JmsMessage $message)
    {
        $this->messages->add($message);
        return $this;

    }

    public function set(JmsMessage $message, $force = false)
    {
        $this->messages->set($message, $force);
        return $this;
    }

    public function get($id, $domain = 'messages')
    {
        return $this->messages->get($id, $domain);
    }

    public function has(JmsMessage $message)
    {
        return $this->messages->has($message);
    }

    public function merge(JmsMessages $catalogue)
    {
        $this->messages->merge($catalogue);

        return $this;
    }

    public function hasDomain($domain)
    {
        return $this->messages->hasDomain($domain);
    }

    public function getDomain($domain)
    {
        return $this->messages->getDomain($domain);
    }

    public function getDomains()
    {
        return $this->messages->getDomains();
    }


}