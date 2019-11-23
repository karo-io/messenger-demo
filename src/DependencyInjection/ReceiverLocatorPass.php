<?php

namespace App\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Messenger\Transport\Receiver\ReceiverInterface;

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
        $receiverMapping = [];
        foreach ($container->findTaggedServiceIds($this->receiverTag) as $id => $tags) {
            $receiverClass = $container->findDefinition($id)->getClass();
            if (!is_subclass_of($receiverClass, ReceiverInterface::class)) {
                throw new RuntimeException(
                    sprintf(
                        'Invalid receiver "%s": class "%s" must implement interface "%s".',
                        $id,
                        $receiverClass,
                        ReceiverInterface::class
                    )
                );
            }

            $receiverMapping[$id] = new Reference($id);

            foreach ($tags as $tag) {
                if (isset($tag['alias'])) {
                    $receiverMapping[$tag['alias']] = $receiverMapping[$id];
                }
            }
        }

        $receiverNames = [];
        foreach ($receiverMapping as $name => $reference) {
            $receiverNames[(string) $reference] = $name;
        }

        if ($container->hasDefinition('messenger-monitor.receiver-locator')) {
            $consumeCommandDefinition = $container->getDefinition('messenger-monitor.receiver-locator');

            $consumeCommandDefinition->addArgument($receiverMapping);
            $consumeCommandDefinition->addArgument($receiverNames);
        }
    }
}

