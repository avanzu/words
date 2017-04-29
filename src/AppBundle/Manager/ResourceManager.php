<?php
/**
 * ObjectManager.php
 * restfully
 * Date: 08.04.17
 */

namespace AppBundle\Manager;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ResourceManager
 */
class ResourceManager
{
    const INTENT_CREATE = 'create';
    const INTENT_UPDATE = 'update';
    const INTENT_REMOVE = 'delete';

    /**
     * @var string
     */
    protected $className;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * ResourceManager constructor.
     *
     * @param string             $className
     * @param EntityManager      $entityManager
     * @param ValidatorInterface $validator
     */
    public function __construct($className, EntityManager $entityManager, ValidatorInterface $validator)
    {
        $this->className     = $className;
        $this->entityManager = $entityManager;
        $this->validator     = $validator;
    }

    /**
     * @param      $model
     * @param null $groups
     * @param null $constraints
     *
     * @return \Symfony\Component\Validator\ConstraintViolationListInterface
     */
    public function validate($model, $groups=null, $constraints = null)
    {
        return $this->getValidator()->validate($model,$constraints, $groups);
    }

    /**
     * @param array $properties
     *
     * @return mixed
     */
    public function createNew($properties = [])
    {
        $class = $this->getRepository()->getClassName();
        $model = new $class;

        return $this->initialize($model, $properties);
    }

    /**
     * @param array|object $models
     * @param bool         $flush
     * @param null         $intent
     */
    public function save($models = [], $flush = true, $intent = null)
    {

        if( ! is_array($models) ) {
            $models = [$models];
        }

        $em = $this->getEntityManager();
        foreach($models as $model) {
            $this->preProcess($model, $intent);
            $em->persist($model);
            $this->postProcess($model, $intent);
        }

        if( $flush ) $em->flush();

    }

    /**
     * @param array|object $models
     * @param bool         $flush
     * @param null         $intent
     */
    public function remove($models = [], $flush = true, $intent = null)
    {
        if( ! is_array($models) ) {
            $models = [$models];
        }

        $em = $this->getEntityManager();
        foreach($models as $model) {
            $em->remove($model);
        }

        if( $flush ) $em->flush();
    }


    /**
     * @param $model
     * @param $intent
     */
    protected function preProcess($model, $intent)
    {}

    /**
     * @param $model
     * @param $intent
     */
    protected function postProcess($model, $intent)
    {}

    /**
     * @param       $model
     * @param array $properties
     *
     * @return mixed
     */
    public function initialize($model, $properties = [])
    {
        $accessor = PropertyAccess::createPropertyAccessor();
        foreach($properties as $propertyName => $property) {
            if( ! $accessor->isWritable($model, $propertyName) ) {
                continue;
            }
            $accessor->setValue($model, $propertyName, $property);
        }
        return $model;
    }


    /**
     * @return EntityRepository
     */
    public function getRepository()
    {
        return $this->getEntityManager()->getRepository($this->className);
    }

    /**
     * @return ValidatorInterface
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

}