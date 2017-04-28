<?php

namespace AppBundle;

use AppBundle\DependencyInjection\Compiler\RelationProviderPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class AppBundle
 */
class AppBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new RelationProviderPass());
    }

}
