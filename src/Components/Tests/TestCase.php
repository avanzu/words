<?php
/**
 * TestCase.php
 * restfully
 * Date: 22.09.17
 */

namespace Components\Tests;

use Components\Infrastructure\IContainer;
use PHPUnit\Framework\TestCase as UnitTestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;

class TestCase extends UnitTestCase
{

    /**
     * @param array $accessible
     *
     * @return IContainer
     */
    protected function createContainer(array $accessible = [])
    {
        /** @var IContainer|ObjectProphecy $container */
        $container = $this->prophesize(IContainer::class);


        $container
            ->acquire(Argument::type('string'))
            ->will(function($args) use ($accessible){
                $id = current($args);
                return isset($accessible[$id]) ? $accessible[$id] : null;
            });

        $container
            ->exists(Argument::type('string'))
            ->will(function($args) use ($accessible) {
                $id = current($args);
                return isset($accessible[$id]);
            });

        return $container->reveal();
    }

}