<?php
/**
 * RegisterHandlerTest.php
 * restfully
 * Date: 23.09.17
 */

namespace Components\Tests\Interaction\Users\Register;

use AppBundle\Validator\Result;
use Components\Infrastructure\Events\INotifier;
use Components\Infrastructure\Events\ResourceMessage;
use Components\Infrastructure\Response\ErrorResponse;
use Components\Infrastructure\Response\ValidationFailedResponse;
use Components\Interaction\Users\Register\RegisterHandler;
use Components\Interaction\Users\Register\RegisterRequest;
use Components\Interaction\Users\Register\RegisterResponse;
use Components\Model\User;
use Components\Resource\IUserManager;
use Components\Tests\TestCase;
use Prophecy\Argument;

class RegisterHandlerTest extends TestCase
{


    public function testItShouldValidate()
    {
        $manager = $this->prophesize(IUserManager::class);
        $result  = $this->prophesize(Result::class);
        $result->isValid()->shouldBeCalled()->willReturn(false);
        $manager->validate(Argument::type(User::class), ['Default', 'register'])->shouldBeCalled()->willReturn( $result );

        $notifier = $this->prophesize(INotifier::class);
        $notifier->notify(Argument::type(ResourceMessage::class))->shouldNotBeCalled();


        $subject = new RegisterHandler($notifier->reveal());
        $subject->setManager($manager->reveal());

        $response = $subject->handle(new RegisterRequest(new User()));
        $this->assertInstanceOf(ValidationFailedResponse::class, $response);
    }

    /**
     *
     */
    public function testItShouldCancelOnException()
    {
        $manager = $this->prophesize(IUserManager::class);
        $result  = $this->prophesize(Result::class);
        $result->isValid()->shouldBeCalled()->willReturn(true);
        $manager->validate(Argument::type(User::class), ['Default', 'register'])->shouldBeCalled()->willReturn( $result );

        $manager->startTransaction()->shouldBeCalled();
        $manager->cancelTransaction()->shouldBeCalled();
        $manager->encodePassword(Argument::type(User::class), '123abc')->shouldBeCalled()->willReturn('abc321');
        $manager->save(Argument::type(User::class))->shouldBeCalled();

        $notifier = $this->prophesize(INotifier::class);
        $notifier->notify(Argument::type(ResourceMessage::class))->shouldBeCalled()->will(function(){
            throw new \Exception('notification failure...');
        });


        $subject = new RegisterHandler($notifier->reveal());
        $subject->setManager($manager->reveal());

        $user     = new User();
        $user->setPlainPassword('123abc');
        $response = $subject->handle(new RegisterRequest($user));
        $this->assertInstanceOf(ErrorResponse::class, $response);

    }
    public function testItShouldFinalizeAndSave()
    {

        $result  = $this->prophesize(Result::class);
        $result->isValid()->shouldBeCalled()->willReturn(true);

        $manager = $this->prophesize(IUserManager::class);
        $manager->validate(Argument::type(User::class), ['Default', 'register'])->shouldBeCalled()->willReturn( $result );
        $manager->startTransaction()->shouldBeCalled();
        $manager->encodePassword(Argument::type(User::class), '123abc')->shouldBeCalled()->willReturn('abc321');
        $manager->save(Argument::type(User::class))->shouldBeCalled();
        $manager->commitTransaction()->shouldBeCalled();

        $notifier = $this->prophesize(INotifier::class);
        $notifier->notify(Argument::type(ResourceMessage::class))->shouldBeCalled();

        $subject = new RegisterHandler($notifier->reveal());
        $subject->setManager($manager->reveal());

        $user = new User();
        $user->setPlainPassword('123abc');
        $response = $subject->handle(new RegisterRequest($user));

        $this->assertInstanceOf(RegisterResponse::class, $response);
        $this->assertEquals('abc321', $user->getPassword());
        $this->assertNotEmpty($user->getToken());

    }

}
