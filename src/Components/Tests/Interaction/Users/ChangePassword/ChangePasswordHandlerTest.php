<?php
/**
 * ChangePasswordHandlerTest.php
 * restfully
 * Date: 23.09.17
 */

namespace Components\Tests\Interaction\Users\ChangePassword;

use Components\Infrastructure\Events\INotifier;
use Components\Infrastructure\Events\ResourceMessage;
use Components\Infrastructure\Response\ErrorResponse;
use Components\Interaction\Users\ChangePassword\ChangePasswordHandler;
use Components\Interaction\Users\ChangePassword\ChangePasswordRequest;
use Components\Interaction\Users\ChangePassword\ChangePasswordResponse;
use Components\Model\User;
use Components\Resource\IUserManager;
use Components\Tests\TestCase;
use Prophecy\Argument;

/**
 * Class ChangePasswordHandlerTest
 */
class ChangePasswordHandlerTest extends TestCase
{


    /**
     *
     */
    public function testItShouldUpdatePasswords()
    {

        $manager = $this->prophesize(IUserManager::class);
        $manager->startTransaction()->shouldBeCalled();
        $manager->commitTransaction()->shouldBeCalled();
        $manager->encodePassword(Argument::type(User::class), '123abc')->shouldBeCalled()->willReturn('abc321');
        $manager->save(Argument::type(User::class))->shouldBeCalled();

        $notifier = $this->prophesize(INotifier::class);
        $notifier->notify(Argument::type(ResourceMessage::class))->shouldBeCalled();


        $subject = new ChangePasswordHandler($notifier->reveal());
        $subject->setManager($manager->reveal());

        $user     = new User();
        $response = $subject->handle(new ChangePasswordRequest($user, '123abc'));
        $this->assertInstanceOf(ChangePasswordResponse::class, $response);
        $this->assertSame($user, $response->getResource());
        $this->assertEquals('abc321', $user->getPassword());
    }


    /**
     *
     */
    public function testItShouldCancelOnException()
    {
        $manager = $this->prophesize(IUserManager::class);
        $manager->startTransaction()->shouldBeCalled();
        $manager->cancelTransaction()->shouldBeCalled();
        $manager->encodePassword(Argument::type(User::class), '123abc')->shouldBeCalled()->willReturn('abc321');
        $manager->save(Argument::type(User::class))->shouldBeCalled();

        $notifier = $this->prophesize(INotifier::class);
        $notifier->notify(Argument::type(ResourceMessage::class))->shouldBeCalled()->will(function(){
            throw new \Exception('notification failure...');
        });


        $subject = new ChangePasswordHandler($notifier->reveal());
        $subject->setManager($manager->reveal());

        $user     = new User();
        $response = $subject->handle(new ChangePasswordRequest($user, '123abc'));
        $this->assertInstanceOf(ErrorResponse::class, $response);

    }
}
