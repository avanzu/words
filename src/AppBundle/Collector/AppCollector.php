<?php
/**
 * AppCollector.php
 * restfully
 * Date: 27.04.17
 */

namespace AppBundle\Collector;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

class AppCollector extends DataCollector
{
    /**
     * AppCollector constructor.
     */
    public function __construct($appName, $appIcon, $defaultLocale, $resources) {

        $this->data = [
            'app_name'       => $appName,
            'app_icon'       => $appIcon,
            'version'        => \App::VERSION,
            'default_locale' => $defaultLocale,
            'request_locale' => null,
            'resources'      => $resources
        ];
    }

    /**
     * @return string
     */
    public function getLocaleCode()
    {
        return $this->data['default_locale'];
    }

    /**
     * @return string
     */
    public function getRequestLocaleCode()
    {
        return $this->data['request_locale'];
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->data['version'];
    }

    /**
     * @return string
     */
    public function getAppName()
    {
        return $this->data['app_name'];
    }

    /**
     * @return string
     */
    public function getAppIcon()
    {
        return $this->data['app_icon'];
    }

    /**
     * @return string[]
     */
    public function getAppResources()
    {
        return $this->data['resources'];
    }


    /**
     * Collects data for the given Request and Response.
     *
     * @param Request    $request   A Request instance
     * @param Response   $response  A Response instance
     * @param \Exception $exception An Exception instance
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $this->data['request_locale'] = $request->getLocale();
    }

    /**
     * Returns the name of the collector.
     *
     * @return string The collector name
     */
    public function getName()
    {
        return 'app';
    }
}