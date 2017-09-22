<?php
/**
 * AppExtension.php
 * restfully
 * Date: 08.04.17
 */

namespace AppBundle\DependencyInjection;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class AppExtension
 */
class AppExtension extends Extension
{

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $this->configure($configs, $container);
    }

    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function configure(array $configs, ContainerBuilder $container)
    {
        $config = $this->loadConfiguration($configs, $container);

        $container->setParameter('app.email.sender', [$config['email']['address'] => $config['email']['alias']]);

        $this->initializeClasses($config, $container);


    }



    /**
     * @param                  $config
     * @param ContainerBuilder $container
     */
    protected function initializeClasses($config, ContainerBuilder $container)
    {
        $resourceNames = $container->hasParameter('app.resources') ? $container->getParameter('app.resources') : [];

        foreach($config['resources'] as $key => $settings) {

            $container->setParameter(sprintf('app.resource.%s.class', $key), $settings['model']);

            $this->addManagerDefinition($key, $settings, $container);
            $this->addControllerDefinition($key, $settings, $container);

            $resourceNames[$key] = $settings['model'];
        }

        $container->setParameter('app.resources', $resourceNames);

    }

    /**
     * @param                  $key
     * @param                  $settings
     * @param ContainerBuilder $container
     */
    protected function addControllerDefinition($key, $settings, ContainerBuilder $container)
    {
        $definition = new Definition($settings['controller'], [
           new Reference(sprintf('app.manager.%s', $key)),
           new Reference('app.presenter')
        ]);

        if( is_a($settings['controller'], ContainerAwareInterface::class, true) ) {
            $definition->addMethodCall('setContainer', [new Reference('service_container')]);
        }



        $container->setDefinition(sprintf('app.controller.%s', $key), $definition);
    }

    /**
     * @param                  $key
     * @param                  $settings
     * @param ContainerBuilder $container
     */
    protected function addManagerDefinition($key, $settings, ContainerBuilder $container)
    {
        $definition          = new Definition($settings['manager'], [
            $settings['model'],
            new Reference('app.repository.factory'),
            new Reference('app.validator'),
            new Reference('doctrine.orm.entity_manager'),
        ]);

        if( is_a($settings['manager'], ContainerAwareInterface::class, true) ) {
            $definition->addMethodCall('setContainer', [new Reference('service_container')]);
        }

        $container->setDefinition(sprintf('app.manager.%s', $key), $definition);
    }

    /**
     * @param $configs
     * @param $container
     *
     * @return array
     */
    protected function loadConfiguration($configs, $container)
    {
        $configuration = $this->getConfiguration($configs, $container);
        $config        = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.yml');

        return $config;

    }

}