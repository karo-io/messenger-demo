<?php

namespace App\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ReceiverLocatorPass implements CompilerPassInterface
{
    /**
     * @var string
     */
    private $receiverTag;

    public function __construct($receiverTag = 'messenger.receiver')
    {
        $this->receiverTag = $receiverTag;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if ($container->hasDefinition('messenger-monitor.receiver-locator')) {
            if ($container->hasDefinition('console.command.messenger_consume_messages')) {

                // steal configurations already done by the MessengerPass so we dont have to duplicate the work
                $monitorDefinition = $container->getDefinition('messenger-monitor.receiver-locator');
                $monitorDefinition->addArgument(new Reference('messenger.receiver_locator'));

                $consumeCommandDefinition = $container->getDefinition('console.command.messenger_consume_messages');
                $names = $consumeCommandDefinition->getArgument(4);
                $monitorDefinition->addArgument($names);
            }
        }
    }
}

