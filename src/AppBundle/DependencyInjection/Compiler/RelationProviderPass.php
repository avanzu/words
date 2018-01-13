<?php
/**
 * RelationProviderPass.php
 * restfully
 * Date: 14.04.17
 */

namespace AppBundle\DependencyInjection\Compiler;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RelationProviderPass implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if( ! $container->hasDefinition('app.subscriber.serializer.hateoas')) {
            return;
        }

        $definition = $container->getDefinition('app.subscriber.serializer.hateoas');

        foreach(array_keys( $container->findTaggedServiceIds('hateoas.provider')) as $id ) {
            $providerDefinition = $container->getDefinition($id);
            $providerDefinition->setLazy(true);
            $definition->addMethodCall('addProvider', [new Reference($id)]);
        }
    }
}