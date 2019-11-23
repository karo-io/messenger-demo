<?php

namespace App\Message;

use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class MessageHandler implements MessageHandlerInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(StandardMessage $message)
    {
        $diff = (new \DateTime())->diff($message->getCreatedDate());
        $this->logger->info('Starting msg after '.$diff->format('%m:%s'));
        $delay = rand(5, 30);
        $this->logger->info('Gonna need '.$delay.' for this job');
        sleep($delay);
    }
}
