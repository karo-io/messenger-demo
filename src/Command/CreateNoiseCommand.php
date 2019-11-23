<?php


namespace App\Command;


use App\Message\StandardMessage;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DelayStamp;

class CreateNoiseCommand extends Command
{
    protected static $defaultName = 'app:noise';
    /**
     * @var MessageBusInterface
     */
    private $bus;

    public function __construct(string $name = null, MessageBusInterface $bus)
    {
        parent::__construct($name);
        $this->bus = $bus;
    }

    protected function configure()
    {
        // We'll see
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        while (true) {
            $msg = new StandardMessage($io);
            $delay = rand(5000, 15000);
            $env = new Envelope($msg, [new DelayStamp($delay)]);
            $io->writeln('Dispatch Msg with delay '.$delay);
            $this->bus->dispatch($env);

            sleep(rand(2, 10));
        }


        return 0;
    }
}
