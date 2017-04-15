<?php
/**
 * HateoasSerializationSubscriber.php
 * restfully
 * Date: 14.04.17
 */

namespace AppBundle\EventListener;


use Components\Hateoas\RelationProviderInterface;
use JMS\Serializer\EventDispatcher\Events;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use JMS\Serializer\EventDispatcher\PreSerializeEvent;
use JMS\Serializer\GenericSerializationVisitor;
use JMS\Serializer\SerializationContext;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class HateoasSerializationSubscriber implements EventSubscriberInterface, ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var RelationProviderInterface[]
     */
    protected $providers = [];

    /**
     * @param RelationProviderInterface[] $providers
     *
     * @return $this
     */
    public function setProviders($providers = [])
    {
        $this->providers = [];
        foreach ($providers as $provider) {
            $this->addProvider($provider);
        }

        return $this;
    }

    /**
     * @param RelationProviderInterface $provider
     *
     * @return $this
     */
    public function addProvider(RelationProviderInterface $provider)
    {
        $this->providers[] = $provider;

        return $this;
    }

    /**
     * @return RelationProviderInterface[]
     */
    public function getProviders()
    {
        return $this->providers;
    }



    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function onPostSerialize(ObjectEvent $event)
    {
        /** @var SerializationContext $context */
        $context = $event->getContext();
        $object  = $event->getObject();
        /** @var GenericSerializationVisitor $visitor */
        $visitor = $event->getVisitor();
        $links   = [];
        foreach ($this->getProvidersFor($object) as $provider) {
            $links = array_merge($links, (array) $provider->decorate($object));
        }

        $context->startVisiting($object);
        $visitor->setData('_links', $links);
        $context->stopVisiting($object);
    }

    /**
     * {@inheritdoc}
     */
    public function onPreSerialize(PreSerializeEvent $event)
    {
    }

    /** @inheritdoc */
    public static function getSubscribedEvents()
    {
        return [
            ['event' => Events::POST_SERIALIZE, 'method' => 'onPostSerialize'],
            ['event' => Events::PRE_SERIALIZE, 'method' => 'onPreSerialize'],
        ];
    }

    /**
     * @param $object
     *
     * @return RelationProviderInterface[]
     */
    protected function getProvidersFor($object)
    {
        $providers = [];
        foreach ($this->providers as $provider) {
            if ($provider->isSupported($object)) {
                $providers[] = $provider;
            }
        }

        return $providers;
    }
}