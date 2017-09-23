<?php
/**
 * RequestHandlerResolverTest.php
 * restfully
 * Date: 23.09.17
 */

namespace Components\Tests\Infrastructure\Command\Resolver;


use Components\Infrastructure\Command\Handler\ICommandHandler;
use Components\Infrastructure\Command\Resolver\RequestHandlerResolver;
use Components\Infrastructure\Exception\HandlerNotFoundException;
use Components\Infrastructure\Request\IRequest;
use Components\Infrastructure\Response\IResponse;
use Components\Infrastructure\Response\Response;
use Components\Tests\TestCase;

class TestHandlerImpl implements ICommandHandler {

    /** @inheritdoc */
    public function handle(IRequest $request)
    {
        return null;
    }
}

class TestRequestImpl implements IRequest {}


class RequestHandlerResolverTest extends TestCase
{

    /**
     * @param $container
     *
     * @return RequestHandlerResolver
     */
    protected function createSubject($container)
    {
        return new RequestHandlerResolver($container);
    }

    /**
     */
    public function testItShouldResolveHandlersByRequest()
    {
        $subject = $this->createSubject($this->createContainer());
        $handler = $subject->getHandler(new TestRequestImpl());

        $this->assertInstanceOf(TestHandlerImpl::class, $handler);
    }

    /**
     */
    public function testItShouldLoadHandlersFromContainer()
    {
        $target    = $this->prophesize(ICommandHandler::class)->reveal();
        $container = $this->createContainer(['different_handler' => $target]);

        $subject = $this->createSubject($container);
        $subject->setHandlers([TestHandlerImpl::class => 'different_handler']);
        $handler = $subject->getHandler(new TestRequestImpl());
        $this->assertSame($target, $handler);
    }


    /**
     * @expectedException Components\Infrastructure\Exception\HandlerNotFoundException
     */
    public function testItShouldThrowNotFoundException()
    {
        $subject = $this->createSubject($this->createContainer());
        $subject->getHandler($this->prophesize(IRequest::class)->reveal());
    }


}