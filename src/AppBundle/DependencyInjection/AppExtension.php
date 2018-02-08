<?php
/**
 * AppExtension.php
 * restfully
 * Date: 08.04.17
 */

namespace AppBundle\DependencyInjection;


use AppBundle\Controller\IFlashing;
use AppBundle\Entity\Api\RefreshToken;
use Symfony\Component\BrowserKit\Response;
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
        $locator       = $container->getDefinition('app.manager.locator');
        $managers      = [];


        foreach($config['resources'] as $key => $settings) {

            $container->setParameter(sprintf('app.resource.%s.class', $key), $settings['model']);

            $managerKey = $this->addManagerDefinition($key, $settings, $container);
            $this->addControllerDefinition($key, $settings, $container);

            $resourceNames[$key]   = $settings['model'];
            $managers[$managerKey] = new Reference($managerKey);

        }
        $container->setParameter('app.resources', $resourceNames);
        $locator->setArguments([$managers]);

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
           new Reference('app.presenter'),
           new Reference('app.localizer'),
           new Reference('app.command_bus')
        ]);


        $definition->addTag('controller.service_arguments');

        if( is_a($settings['controller'], ContainerAwareInterface::class, true) ) {
            $definition->addMethodCall('setContainer', [new Reference('service_container')]);
        }
        if( is_a($settings['controller'], IFlashing::class, true) ) {
            $definition->addMethodCall('setFlasher', [new Reference('app.flash')]);
        }

        $id = sprintf('app.controller.%s', $key);
        $container->setDefinition($id, $definition);

        $container->setAlias($definition->getClass(), $id);
    }

    /**
     * @param                  $key
     * @param                  $settings
     * @param ContainerBuilder $container
     *
     * @return string
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

        $key = sprintf('app.manager.%s', $key);
        $container->setDefinition($key, $definition);
        $container->setAlias($definition->getClass(), $key);
        return $key;
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