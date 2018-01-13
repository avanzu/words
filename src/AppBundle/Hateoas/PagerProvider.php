<?php
/**
 * PagerProvider.php
 * words
 * Date: 13.01.18
 */

namespace AppBundle\Hateoas;

use AppBundle\Hateoas\Relation\RouteRelation;
use Components\DataAccess\IPager;
use Components\Hateoas\Relation\NamedRouteRelation;
use Components\Hateoas\RelationProviderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;


/**
 * Class PagerProvider
 */
class PagerProvider implements RelationProviderInterface
{

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * PagerProviderInterface constructor.
     *
     * @param RequestStack    $requestStack
     * @param RouterInterface $router
     */
    public function __construct(RequestStack $requestStack, RouterInterface $router) {
        $this->requestStack = $requestStack;
        $this->router       = $router;
    }


    /**
     * @param IPager $pager
     *
     * @return array
     */
    public function decorate($pager)
    {
        $request = $this->requestStack->getMasterRequest();

        $route   = $request->attributes->get('_route');
        $query   = $request->query->all();
        $attribs = array_filter($request->attributes->get('_route_params'), function($key){ return strpos($key, '_') !== 0; }, ARRAY_FILTER_USE_KEY);

        $links = [
            'self'  => new NamedRouteRelation($route, array_merge($attribs,$query)),
            'last'  => new NamedRouteRelation($route, array_merge($attribs, $query, ['page' => $pager->getPagesTotal()])),
            'first' => new NamedRouteRelation($route, array_merge($attribs, $query, ['page' => 1])),
            'next'  => $pager->hasNext() ?
                new NamedRouteRelation($route, array_merge($attribs,$query, ['page' => $pager->getNext()])) : false,
            'prev'  => $pager->hasPrevious() ?
                new NamedRouteRelation($route, array_merge($attribs, $query, ['page' => $pager->getPrevious()])) : false,
        ];

        if( $schema = $this->getSchemaByRequest($request) ){
            $links['schema'] = $schema;
        }

        return $links;
    }

    /**
     * @param $request
     *
     * @return bool|NamedRouteRelation
     */
    protected function getSchemaByRequest($request)
    {
        $name  = $request->attributes->get('_route');
        $route = $this->router->getRouteCollection()->get($name);
        if( ! $route->hasOption('schema') ) {
            return false;
        }

        return new NamedRouteRelation($route->getOption('schema'));
    }

    /**
     * @param $object
     *
     * @return bool
     */
    public function isSupported($object)
    {
        return ($object instanceof IPager);

    }
}