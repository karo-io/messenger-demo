<?php


namespace KaroIO\MessengerMonitor\Command;


use KaroIO\MessengerMonitor\Locator\ReceiverLocator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Transport\Receiver\MessageCountAwareInterface;
use Symfony\Component\Messenger\Transport\Receiver\ReceiverInterface;

class MonitorCommand extends Command
{
    protected static $defaultName = 'messenger:monitor';
    /**
     * @var MessageBusInterface
     */
    private $bus;
    /**
     * @var ReceiverLocator
     */
    private $locator;

    public function __construct(string $name = null, ReceiverLocator $locator)
    {
        parent::__construct($name);
        $this->locator = $locator;

        $this->receivers = $this->locator->getReceiverMapping();
    }

    protected function configure()
    {
        // We'll see
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        while (1) {
            // clear screen
            $io->write(sprintf("\033\143"));
            $io->title('Transport Queue Length');
            $io->text((new \DateTime('now'))->format('Y-m-d H:i:s'));

            $receivers = $this->locator->getReceiverMapping();
            $rows = [];
            foreach ($receivers as $name => $receiver) {
                /** @var ReceiverInterface $receiver */
                $receiver = $receivers[$name];
                $queueLength = -1;
                if ($receiver instanceof MessageCountAwareInterface) {
                    /** @var MessageCountAwareInterface $receiver */
                    $queueLength = $receiver->getMessageCount();
                }
                $rows[] = [$name, $queueLength];
            }
            $io->table(['Transport', 'Queue Length'], $rows);

            sleep(1);

        }

        return 0;
    }
}
