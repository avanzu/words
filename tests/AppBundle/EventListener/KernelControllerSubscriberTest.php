<?php
/**
 * KernelControllerSubscriberTest.php
 * restfully
 * Date: 09.04.17
 */

namespace AppBundle\EventListener;


use AppBundle\Controller\ITemplateAware;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\Tests\Debug\EventSubscriber;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\KernelEvents;

class KernelControllerSubscriberTest extends TestCase
{

    /**
     * @test
     */
    public function itShouldSubscribeToKernelEvents()
    {
        $this->assertTrue(is_a(KernelControllerSubscriber::class, EventSubscriberInterface::class, true));
        $this->assertArrayHasKey(KernelEvents::CONTROLLER, KernelControllerSubscriber::getSubscribedEvents());
    }

    /**
     * @test
     */
    public function itShouldAssignTheConfiguredTemplateToTemplateAwareControllers()
    {
        $kernel     = $this->prophesize(Kernel::class);
        $controller = $this->prophesize(ITemplateAware::class);
        $controller->setTemplate('@Test/template.html.twig')->shouldBeCalled();
        $request    = new Request();
        $request->attributes->set('_template', '@Test/template.html.twig');
        $event = new FilterControllerEvent($kernel->reveal(), [$controller->reveal(), 'myAction'], $request, HttpKernel::MASTER_REQUEST );

        $listener = new KernelControllerSubscriber();
        $listener->onKernelController($event);

    }



}
