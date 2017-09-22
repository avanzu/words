<?php
/**
 * ServieContainer.php
 * restfully
 * Date: 17.09.17
 */

namespace AppBundle\Infrastructure;


use Components\Infrastructure\IContainer;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ServiceContainer implements IContainer
{

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * ServiceContainer constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }


    /**
     * @param $id
     *
     * @return object
     */
    public function acquire($id)
    {
        return $this->container->get($id);
    }

    /**
     * @param $id
     *
     * @return bool
     */
    public function exists($id)
    {
        return $this->container->has($id);
    }
}