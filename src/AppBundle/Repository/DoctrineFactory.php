<?php
/**
 * DoctrineFactory.php
 * restfully
 * Date: 16.09.17
 */

namespace AppBundle\Repository;


use Components\Resource\Repository\Factory;
use Components\Resource\Repository\Repository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class DoctrineFactory implements Factory
{

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * DoctrineFactory constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     * @param $className
     *
     * @return Repository|EntityRepository|ResourceRepository
     */
    public function getRepository($className)
    {
        return $this->entityManager->getRepository($className);
    }
}