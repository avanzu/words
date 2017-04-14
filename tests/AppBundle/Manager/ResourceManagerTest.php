<?php
/**
 * ResourceManagerTest.php
 * restfully
 * Date: 14.04.17
 */

namespace AppBundle\Manager;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
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

class ResourceManagerTest extends \PHPUnit_Framework_TestCase
{


    /**
     * @test
     */
    public function itShouldCreateNewObjectsOfManagedType()
    {

        $manager = new ResourceManager(
            ManagedTestObject::class,
            $this->getEntityManager($this->getRepository()),
            $this->getValidator());

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
            $this->getEntityManager($this->getRepository()),
            $this->getValidator());

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
            $em->reveal(),
            $this->getValidator()
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
            $em->reveal(),
            $this->getValidator()
        );

        $manager->remove($model);

        $manager->remove($model, false);

    }

    private function getRepository()
    {
        $repository = $this->prophesize(EntityRepository::class);;
        $repository->getClassName()->willReturn(ManagedTestObject::class);
        return $repository;
    }

    private function getEntityManager( $repository, $reveal = true )
    {
        /** @var ObjectProphecy|EntityManager $manager */
        $manager    = $this->prophesize(EntityManager::class);
        $manager->getRepository(ManagedTestObject::class)->willReturn($repository);

        return $reveal ? $manager->reveal() : $manager;
    }


    private function getValidator($reveal = true)
    {
        $validator = $this->prophesize(ValidatorInterface::class);

        return $reveal ? $validator->reveal() : $validator;
    }

}
