<?php
/**
 * AppUserCreateCommandTest.php
 * restfully
 * Date: 08.04.17
 */

namespace AppBundle\Tests\Command;


use AppBundle\Command\AppUserCreateCommand;
use AppBundle\Entity\User;
use AppBundle\Manager\UserManager;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;


class AppUserCreateCommandTest extends KernelTestCase
{
    /**
     * @test
     */
    public function itShouldCreateUsers()
    {
        $application = new Application();
        $application->add(new AppUserCreateCommand());
        $command = $application->find('app:user:create');
        $command->setContainer($this->getContainer($this->getUserManager()));

        $tester = new CommandTester($command);

        $tester->execute(
            array(
                'command'  => $command->getName(),
                'username' => 'testuser',
                'email'    => 'testuser@example.com',
                'password' => '1234',
                'roles'    => ['ROLE_ADMIN']
            )
        );

        $this->assertStringMatchesFormat('[OK] A new user [%s] was created.', trim($tester->getDisplay()));
    }

    /**
     * @param null $manager
     *
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private function getContainer($manager = null)
    {
        $container = static::$kernel->getContainer();
        if ($manager) {
            $container->set('app.manager.user', $manager);
        }

        return $container;
    }

    private function getUserManager()
    {
        /** @var ObjectProphecy|UserManager $manager */
        $manager = $this->prophesize(UserManager::class);
        $user    = new User();
        $user->setUsername('testuser')
             ->setEmail('testuser@example.com')
             ->setPlainPassword('1234')
             ->setRoles(['ROLE_ADMIN'])
        ;

        $manager
            ->createNew(
                [
                    'username'      => 'testuser',
                    'email'         => 'testuser@example.com',
                    'plainPassword' => '1234',
                    'roles'         => ['ROLE_ADMIN'],
                ]
            )
            ->shouldBeCalled()
            ->willReturn($user)
        ;


        $manager->validate($user, ['Default', 'registration'])->shouldBeCalled()->willReturn([]);
        $manager->save([$user])->shouldBeCalled();

        return $manager->reveal();
    }

    protected function setUp()
    {
        static::bootKernel();
    }

}
