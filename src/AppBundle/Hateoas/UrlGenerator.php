<?php
/**
 * UrlGenerator.php
 * words
 * Date: 13.01.18
 */

namespace AppBundle\Hateoas;


use Components\Hateoas\IUrlGenerator;
use Components\Hateoas\Relation\NamedRouteRelation;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class UrlGenerator implements IUrlGenerator
{

    /**
     * @var  UrlGeneratorInterface
     */
    protected $generator;

    /**
     * UrlGenerator constructor.
     *
     * @param UrlGeneratorInterface $generator
     */
    public function __construct(UrlGeneratorInterface $generator) {
        $this->generator = $generator;
    }

    /**
     * @param NamedRouteRelation $name
     * @param array $parameters
     *
     * @return string
     */
    public function generate($name, $parameters = array())
    {
        return $this->generator->generate($name->getRouteName(), $name->getParameters());
    }

    /**
     * @param mixed $candidate
     *
     * @return bool
     */
    public function supports($candidate)
    {
        return ($candidate instanceof NamedRouteRelation);
    }
}