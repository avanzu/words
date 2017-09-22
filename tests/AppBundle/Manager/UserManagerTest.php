<?php
/**
 * UserManagerTest.php
 * restfully
 * Date: 08.04.17
 */

namespace AppBundle\Tests\Manager;


use AppBundle\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class UserManagerTest extends KernelTestCase
{
    protected function setUp()
    {
        static::bootKernel();
    }


    /**
     * @return \Components\Resource\IUserManager|object
     */
    private function getManager()
    {
        return static::$kernel->getContainer()->get('app.manager.user');
    }

    /**
     * @test
     */
    public function itShouldCreateNewUsersWithEncodedPlainPassword()
    {
        $manager = $this->getManager();
        $user    = $manager->createNew(
            [
                'username'      => 'test',
                'email'         => 'someone@example.com',
                'plainPassword' => '12345'
            ]
        );

        $this->assertNotEmpty($user->getPassword(), 'Password should be filled');
        $this->assertEquals('12345', $user->getPlainPassword(), 'Plain password should be cleared');
    }

}
