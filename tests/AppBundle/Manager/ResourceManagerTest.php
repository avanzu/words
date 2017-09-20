<?php
/**
 * ResourceManagerTest.php
 * restfully
 * Date: 14.04.17
 */

namespace AppBundle\Manager;


use Components\Resource\Repository\Factory;
use Components\Resource\Repository\Repository;
use Components\Resource\Validator\Validator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ManagedTestObject {

    protected $protectedProp;

    public $publicProp;

    private $privateProp;

    /**
     * @var
     */
    protected $protectedInternal;

    /**
     * @var
     */
    private $privateInternal;

    /**
     * @return mixed
     */
    public function getProtectedProp()
    {
        return $this->protectedProp;
    }

    /**
     * @return mixed
     */
    public function getPublicProp()
    {
        return $this->publicProp;
    }

    /**
     * @return mixed
     */
    public function getPrivateProp()
    {
        return $this->privateProp;
    }

    /**
     * @param mixed $protectedProp
     *
     * @return $this
     */
    public function setProtectedProp($protectedProp)
    {
        $this->protectedProp = $protectedProp;

        return $this;
    }

    /**
     * @param mixed $privateProp
     *
     * @return $this
     */
    public function setPrivateProp($privateProp)
    {
        $this->privateProp = $privateProp;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getProtectedInternal()
    {
        return $this->protectedInternal;
    }

    /**
     * @return mixed
     */
    public function getPrivateInternal()
    {
        return $this->privateInternal;
    }




}

class ResourceManagerTest extends TestCase
{


    /**
     * @test
     */
    public function itShouldCreateNewObjectsOfManagedType()
    {

        $manager = new ResourceManager(
            ManagedTestObject::class,
            $this->getFactory(ManagedTestObject::class),
            $this->getValidator(),
            $this->getEntityManager($this->getRepository())
            );

        $object = $manager->createNew();

        $this->assertInstanceOf(ManagedTestObject::class, $object);
    }


    /**
     * @test
     */
    public function itShouldInitializeManagedObjects()
    {
        $manager = new ResourceManager(
            ManagedTestObject::class,
            $this->getFactory(ManagedTestObject::class),
            $this->getValidator(),
            $this->getEntityManager($this->getRepository())
        );

        /** @var ManagedTestObject $object */
        $object = $manager->createNew(
            [
                'publicProp'        => 'public value',
                'protectedProp'     => 'protected value',
                'privateProp'       => 'private value',
                'invalid'           => 'invalid value',
                'protectedInternal' => 'should stay empty',
                'privateInternal'   => 'should also stay empty',
            ]
        );

        $this->assertEquals('public value', $object->getPublicProp());
        $this->assertEquals('protected value', $object->getProtectedProp());
        $this->assertEquals('private value', $object->getPrivateProp());

        $this->assertEmpty($object->getProtectedInternal());
        $this->assertEmpty($object->getPrivateInternal());
    }

    /**
     * @test
     */
    public function itShouldSaveAndOptionallyPersist()
    {
        $model   = new ManagedTestObject();
        $em      = $this->getEntityManager($this->getRepository(), false);
        $em->persist($model)->shouldBeCalledTimes(2);
        $em->flush()->shouldBeCalledTimes(1);

        $manager = new ResourceManager(
            ManagedTestObject::class,
            $this->getFactory(ManagedTestObject::class),
            $this->getValidator(),
            $em->reveal()
        );

        $manager->save($model);

        $manager->save($model, false);

    }

    /**
     * @test
     */
    public function itShouldRemoveAndOptionallyPersist()
    {
        $model   = new ManagedTestObject();
        $em      = $this->getEntityManager($this->getRepository(), false);
        $em->remove($model)->shouldBeCalledTimes(2);
        $em->flush()->shouldBeCalledTimes(1);

        $manager = new ResourceManager(
            ManagedTestObject::class,
            $this->getFactory(ManagedTestObject::class),
            $this->getValidator(),
            $em->reveal()
        );

        $manager->remove($model);

        $manager->remove($model, false);

    }

    /**
     * @return ObjectProphecy|Repository
     */
    private function getRepository()
    {
        $repository = $this->prophesize(EntityRepository::class);;
        $repository->getClassName()->willReturn(ManagedTestObject::class);
        return $repository;
    }

    /**
     * @return Factory
     */
    private function getFactory($repository)
    {
        /** @var Factory|ObjectProphecy $factory */
        $factory = $this->prophesize(Factory::class);
        $factory->getRepository(ManagedTestObject::class)->willReturn($repository);
        return $factory->reveal();
    }

    /**
     * @param      $repository
     * @param bool $reveal
     *
     * @return EntityManager|object|ObjectProphecy
     */
    private function getEntityManager( $repository, $reveal = true )
    {
        /** @var ObjectProphecy|EntityManager $manager */
        $manager    = $this->prophesize(EntityManager::class);
        $manager->getRepository(ManagedTestObject::class)->willReturn($repository);

        return $reveal ? $manager->reveal() : $manager;
    }


    /**
     * @param bool $reveal
     *
     * @return object|ObjectProphecy|Validator
     */
    private function getValidator($reveal = true)
    {
        $validator = $this->prophesize(Validator::class);

        return $reveal ? $validator->reveal() : $validator;
    }

}
