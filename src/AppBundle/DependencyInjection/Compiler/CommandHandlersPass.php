<?php
/**
 * CommandHandlersPass.php
 * restfully
 * Date: 17.09.17
 */

namespace AppBundle\DependencyInjection\Compiler;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CommandHandlersPass implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('app.command.resolver')) {
            return;
        }

        $handlers  = $references = [];
        foreach ($container->findTaggedServiceIds('app.command.handler') as $id => $tags) {
            $handlerDefinition         = $container->getDefinition($id);
            $handlerClass              = $this->getClassName($container, $handlerDefinition->getClass());
            $handlers[$handlerClass]   = $handlerClass;
            $references[$handlerClass] = new Reference($id);
        }

        $container
            ->getDefinition('app.command.resolver')
            ->addMethodCall('setHandlers', [$handlers])
        ;


        $locator = $container->getDefinition('app.handler.locator');
        $locator->setArguments([$references]);


    }

    protected function getClassName(ContainerBuilder $builder, $candidate)
    {
        return class_exists($candidate) ? $candidate : $builder->getParameter($candidate);
    }
}