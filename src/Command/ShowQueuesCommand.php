<?php


namespace App\Command;


use App\Message\ReceiverLocator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Transport\Receiver\MessageCountAwareInterface;
use Symfony\Component\Messenger\Transport\Receiver\ReceiverInterface;

class ShowQueuesCommand extends Command
{
    protected static $defaultName = 'app:show';
    /**
     * @var MessageBusInterface
     */
    private $bus;
    /**
     * @var ReceiverLocator
     */
    private $locator;

    public function __construct(string $name = null, MessageBusInterface $bus, ReceiverLocator $locator)
    {
        parent::__construct($name);
        $this->bus = $bus;
        $this->locator = $locator;
    }

    protected function configure()
    {
        // We'll see
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        while (true) {
            // clear screen
            $io->write(sprintf("\033\143"));
            $io->title('Transport Queue Length');
            $io->text((new \DateTime('now'))->format('Y-m-d H:i:s'));

            $receivers = $this->locator->getReceivers();
            $rows = [];
            /** @var ReceiverInterface $receiver */
            foreach ($receivers as $name => $receiver) {
                $queueLength = -1;
                if ($receiver instanceof MessageCountAwareInterface) {
                    /** @var MessageCountAwareInterface $receiver */
                    $queueLength = $receiver->getMessageCount();
                }
                $rows[] = [get_class($receiver), $queueLength];
            }
            $io->table(['Transport', 'Queue Length'], $rows);

            sleep(1);
        }

        return 0;
    }
}