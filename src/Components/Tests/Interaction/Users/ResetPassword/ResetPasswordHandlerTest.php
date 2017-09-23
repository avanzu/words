<?php
/**
 * ResetPasswordHandlerTest.php
 * restfully
 * Date: 23.09.17
 */

namespace Components\Tests\Interaction\Users\ResetPassword;

use AppBundle\Validator\Result;
use Components\Infrastructure\Events\INotifier;
use Components\Infrastructure\Events\ResourceMessage;
use Components\Infrastructure\Response\ErrorResponse;
use Components\Interaction\Users\ResetPassword\ResetPasswordHandler;
use Components\Interaction\Users\ResetPassword\ResetPasswordRequest;
use Components\Interaction\Users\ResetPassword\ResetPasswordResponse;
use Components\Model\User;
use Components\Resource\IUserManager;
use Components\Tests\TestCase;
use Prophecy\Argument;

class ResetPasswordHandlerTest extends TestCase
{


    public function testItShouldValidate()
    {
        $this->markTestSkipped();
        $manager = $this->prophesize(IUserManager::class);
        $result  = $this->prophesize(Result::class);
        $result->isValid()->shouldBeCalled()->willReturn(false);
        $manager->validate(Argument::type(User::class), ['Default', 'register'])->shouldBeCalled()->willReturn( $result );

        $notifier = $this->prophesize(INotifier::class);
        $notifier->notify(Argument::type(ResourceMessage::class))->shouldNotBeCalled();


        $subject = new ResetPasswordHandler($notifier->reveal());
        $subject->setManager($manager->reveal());

        $response = $subject->handle(new ResetPasswordRequest(new User()));
        $this->assertInstanceOf(ValidationFailedResponse::class, $response);
    }

    /**
     *
     */
    public function testItShouldCancelOnException()
    {
        $manager = $this->prophesize(IUserManager::class);
        $result  = $this->prophesize(Result::class);

        $manager->startTransaction()->shouldBeCalled();
        $manager->cancelTransaction()->shouldBeCalled();
        $manager->save(Argument::type(User::class))->shouldBeCalled();

        $notifier = $this->prophesize(INotifier::class);
        $notifier->notify(Argument::type(ResourceMessage::class))->shouldBeCalled()->will(function(){
            throw new \Exception('notification failure...');
        });


        $subject = new ResetPasswordHandler($notifier->reveal());
        $subject->setManager($manager->reveal());

        $user     = new User();
        $response = $subject->handle(new ResetPasswordRequest($user));
        $this->assertInstanceOf(ErrorResponse::class, $response);

    }
    public function testItShouldFinalizeAndSave()
    {

        $manager = $this->prophesize(IUserManager::class);
        $manager->startTransaction()->shouldBeCalled();
        $manager->save(Argument::type(User::class))->shouldBeCalled();
        $manager->commitTransaction()->shouldBeCalled();

        $notifier = $this->prophesize(INotifier::class);
        $notifier->notify(Argument::type(ResourceMessage::class))->shouldBeCalled();

        $subject = new ResetPasswordHandler($notifier->reveal());
        $subject->setManager($manager->reveal());

        $user = new User();
        $response = $subject->handle(new ResetPasswordRequest($user));

        $this->assertInstanceOf(ResetPasswordResponse::class, $response);
        $this->assertNotEmpty($user->getToken());

    }
}
