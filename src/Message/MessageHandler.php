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
        $this->logger->info('Handled msg after '.$diff->format('%s'));
    }
}
