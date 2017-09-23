<?php
/**
 * ActivateHandlerTest.php
 * restfully
 * Date: 23.09.17
 */

namespace Components\Tests\Interaction\Users\Activate;

use Components\Infrastructure\Response\ErrorResponse;
use Components\Interaction\Users\Activate\ActivateHandler;
use Components\Interaction\Users\Activate\ActivateRequest;
use Components\Interaction\Users\Activate\ActivateResponse;
use Components\Model\User;
use Components\Resource\IManager;
use Components\Resource\IUserManager;
use Components\Tests\TestCase;
use Prophecy\Argument;

/**
 * Class ActivateHandlerTest
 */
class ActivateHandlerTest extends TestCase
{

    /**
     *
     */
    public function testItShouldActivateUsers()
    {
        $subject = new ActivateHandler();
        $manager = $this->prophesize(IUserManager::class);
        $manager->startTransaction()->shouldBeCalled();
        $manager->commitTransaction()->shouldBeCalled();
        $manager->save(Argument::type(User::class))->shouldBeCalled();

        $subject->setManager($manager->reveal());

        $user = new User();
        $user->setToken(uniqid('test-token'))->setIsActive(false);

        $response = $subject->handle(new ActivateRequest($user));

        $this->assertInstanceOf(ActivateResponse::class, $response);
        $this->assertSame($user, $response->getResource());
        $this->assertNull($user->getToken());
        $this->assertTrue($user->getIsActive());

    }

    /**
     *
     */
    public function testItShouldReturnErrorResponseOnException()
    {
        $subject = new ActivateHandler();
        $manager = $this->prophesize(IUserManager::class);
        $manager->startTransaction()->shouldBeCalled();
        $manager->cancelTransaction()->shouldBeCalled();
        $manager->save(Argument::type(User::class))->shouldBeCalled()->will(function (){
            throw new \Exception('testing...');
        });

        $subject->setManager($manager->reveal());

        $user     = new User();
        $response = $subject->handle(new ActivateRequest($user));

        $this->assertInstanceOf(ErrorResponse::class, $response);

    }

}
