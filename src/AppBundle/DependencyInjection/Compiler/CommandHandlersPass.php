<?php
/**
 * CommandHandlersPass.php
 * restfully
 * Date: 17.09.17
 */

namespace AppBundle\DependencyInjection\Compiler;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

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

        $handlers = [];
        foreach ($container->findTaggedServiceIds('app.command.handler') as $id => $tags) {
            $handlerDefinition       = $container->getDefinition($id);
            $handlerClass            = $this->getClassName($container, $handlerDefinition->getClass());
            $handlers[$handlerClass] = $id;
        }

        $container
            ->getDefinition('app.command.resolver')
            ->addMethodCall('setHandlers', [$handlers])
        ;
    }

    protected function getClassName(ContainerBuilder $builder, $candidate)
    {
        return class_exists($candidate) ? $candidate : $builder->getParameter($candidate);
    }
}