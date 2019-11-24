<?php


namespace KaroIO\MessengerMonitor;

use KaroIO\MessengerMonitor\DependencyInjection\ReceiverLocatorPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class KaroIOMessengerMonitorBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new ReceiverLocatorPass());
    }
}
