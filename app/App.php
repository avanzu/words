<?php
/**
 * Restully.php
 * restfully
 * Date: 09.04.17
 */


class App
{

    const VERSION = '0.0.1';
    const VERSION_ID = 000001;
    const MAJOR_VERSION = 0;
    const MINOR_VERSION = 0;
    const RELEASE_VERSION = 1;
    const EXTRA_VERSION = '';

    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected static $container;

    public static function initialize($container)
    {
        static::$container = $container;

    }

    /**
     * @return mixed
     */
    public static function getContainer()
    {
        return self::$container;
    }

    /**
     * @param       $level
     * @param       $message
     * @param array $context
     */
    public static function log($level, $message, $context = [])
    {
        if( ! $container = static::getContainer() ) return;
        if( ! $container->has('logger')) return;

        $container->get('logger')->log($level, $message, $context);
    }


}