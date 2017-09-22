<?php
/**
 * SimpleCommandBusTest.php
 * restfully
 * Date: 19.09.17
 */

namespace Components\Tests\Infrastructure;

use Components\Infrastructure\Command\Handler\ICommandHandler;
use Components\Infrastructure\Command\Resolver\IHandlerResolver;
use Components\Infrastructure\Request\IRequest;
use Components\Infrastructure\Response\IResponse;
use Components\Infrastructure\SimpleCommandBus;
use Components\Tests\TestCase;

class SimpleCommandBusTest extends TestCase
{


    /**
     * @test
     */
    public function itShouldExecuteCommands()
    {
        $resolverProphecy = $this->prophesize(IHandlerResolver::class);
        $handlerProphecy  = $this->prophesize(ICommandHandler::class);
        $requestProphecy  = $this->prophesize(IRequest::class);

        $request = $requestProphecy->reveal();
        $handlerProphecy->handle($request)->willReturn($this->prophesize(IResponse::class)->reveal());
        $resolverProphecy->getHandler($request)->willReturn($handlerProphecy);

        $bus      = new SimpleCommandBus($resolverProphecy->reveal());
        $result   = $bus->execute($requestProphecy->reveal());

        $this->assertInstanceOf(IResponse::class, $result);
    }


}
