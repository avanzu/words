<?php
/**
 * HateoasSerializationSubscriberTest.php
 * restfully
 * Date: 14.04.17
 */

namespace AppBundle\EventListener;


use Components\Hateoas\RelationProviderInterface;
use JMS\Serializer\EventDispatcher\Events;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use JMS\Serializer\GenericSerializationVisitor;
use JMS\Serializer\SerializationContext;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;


class HateoasSerializationSubscriberTest extends \PHPUnit_Framework_TestCase
{


    /**
     * @test
     */
    public function itShouldRegisterProviders()
    {
        $subscriber = new HateoasSerializationSubscriber();
        $this->assertCount(0, $subscriber->getProviders());
        $subscriber->addProvider($this->getProvider()->reveal());
        $this->assertCount(1, $subscriber->getProviders());
    }

    /**
     * @test
     */
    public function itShouldCallProvidersOnPostSerialize()
    {
        $object = (object)['somekey' => 'somevalue'];
        $provider = $this->getProvider();
        $provider->isSupported($object)->willReturn(true);
        $provider->decorate($object)->willReturn(['_self' => '/item']);

        $subscriber = new HateoasSerializationSubscriber();
        $subscriber->addProvider($provider->reveal());

        $visitor = $this->prophesize(GenericSerializationVisitor::class);
        $visitor->setData('_links', ['_self' => '/item'])->shouldBeCalled();
        $context = $this->prophesize(SerializationContext::class);
        $context->startVisiting($object)->shouldBeCalled();
        $context->stopVisiting($object)->shouldBeCalled();

        $event = $this->prophesize(ObjectEvent::class);
        $event->getContext()->willReturn($context);
        $event->getObject()->willReturn($object);
        $event->getVisitor()->willReturn($visitor);

        $subscriber->onPostSerialize($event->reveal());
    }

    /**
     * @test
     */
    public function itShouldBeASubscriber()
    {
       $subscriber = new HateoasSerializationSubscriber();
       $this->assertInstanceOf(EventSubscriberInterface::class, $subscriber);
    }

    /**
     * @param $event
     * @dataProvider provideSubscribedEvents
     * @test
     */
    public function itShouldSubscribeTo($event)
    {
        $events = array_map(
            function($registered){ return $registered['event']; },
            HateoasSerializationSubscriber::getSubscribedEvents()
        );

        $this->assertTrue(in_array($event, $events));
    }


    public function provideSubscribedEvents()
    {
        return array(
            'post' => [Events::POST_SERIALIZE],
            'pre'  => [Events::PRE_SERIALIZE]
        );
    }


    private function getProvider()
    {
        /** @var RelationProviderInterface|ObjectProphecy $provider */
        $provider = $this->prophesize(RelationProviderInterface::class);

        return $provider;
    }
}
