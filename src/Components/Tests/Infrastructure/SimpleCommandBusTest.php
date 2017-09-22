<?php
/**
 * SimpleCommandBusTest.php
 * restfully
 * Date: 19.09.17
 */

namespace Components\Tests\Infrastructure;

use Components\Infrastructure\Command\Handler\CommandHandler;
use Components\Infrastructure\Command\Resolver\CommandHandlerResolver;
use Components\Infrastructure\Request\CommandRequest;
use Components\Infrastructure\Response\CommandResponse;
use Components\Infrastructure\SimpleCommandBus;
use Components\Tests\TestCase;

class SimpleCommandBusTest extends TestCase
{


    /**
     * @test
     */
    public function itShouldExecuteCommands()
    {
        $resolverProphecy = $this->prophesize(CommandHandlerResolver::class);
        $handlerProphecy  = $this->prophesize(CommandHandler::class);
        $requestProphecy  = $this->prophesize(CommandRequest::class);

        $request = $requestProphecy->reveal();
        $handlerProphecy->handle($request)->willReturn($this->prophesize(CommandResponse::class)->reveal());
        $resolverProphecy->getHandler($request)->willReturn($handlerProphecy);

        $bus      = new SimpleCommandBus($resolverProphecy->reveal());
        $result   = $bus->execute($requestProphecy->reveal());

        $this->assertInstanceOf(CommandResponse::class, $result);
    }


}
