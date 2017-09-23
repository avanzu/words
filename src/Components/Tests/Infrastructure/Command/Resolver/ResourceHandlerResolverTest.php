<?php
/**
 * ResourceHandlerResolverTest.php
 * restfully
 * Date: 23.09.17
 */

namespace Components\Tests\Infrastructure\Command\Resolver;

use Components\Infrastructure\Command\Handler\ICommandHandler;
use Components\Infrastructure\Command\Resolver\ResourceHandlerResolver;
use Components\Infrastructure\Request\IRequest;
use Components\Interaction\Resource\ResourceHandler;
use Components\Interaction\Resource\ResourceRequest;
use Components\Interaction\Resource\ResourceResponse;
use Components\Resource\IManager;
use Components\Tests\TestCase;

class ResourceTestHandlerImpl extends ResourceHandler {
    public function handle(IRequest $request) { return new ResourceResponse(__CLASS__ , $request); }
}

class ResourceTestHandlerImpl2 extends ResourceTestHandlerImpl {
    public function handle(IRequest $request) { return new ResourceResponse(__CLASS__ , $request); }
}

class ResourceTestRequestImpl extends ResourceRequest {
    public function getResourceName() { return 'resource'; }
    public function getIntention() { return 'test'; }
}

class ResourceTestRequestImpl2 extends ResourceTestRequestImpl {
}

class ResourceTestRequestImpl3 extends ResourceTestRequestImpl2 {

}



class ResourceHandlerResolverTest extends RequestHandlerResolverTest
{
    /**
     * @param $container
     *
     * @return ResourceHandlerResolver
     */
    protected function createSubject($container)
    {
        return new ResourceHandlerResolver($container);
    }


    /**
     */
    public function testItShouldResolveAndConfigure()
    {
        $manager = $this->prophesize(IManager::class)->reveal();
        $subject = $this->createSubject($this->createContainer( ['app.manager.resource' => $manager] ));
        $handler = $subject->getHandler(new ResourceTestRequestImpl2());

        $this->assertInstanceOf(ResourceTestHandlerImpl2::class, $handler);
        $this->assertSame($manager, $handler->getManager());

    }

    /**
     */
    public function testItShouldResolveParentHandlerAndConfigure()
    {
        $manager = $this->prophesize(IManager::class)->reveal();
        $subject = $this->createSubject($this->createContainer( ['app.manager.resource' => $manager] ));
        $handler = $subject->getHandler(new ResourceTestRequestImpl3());

        $this->assertInstanceOf(ResourceTestHandlerImpl2::class, $handler);
        $this->assertSame($manager, $handler->getManager());
    }




}
