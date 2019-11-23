<?php


namespace App\Message;


class ReceiverLocator
{
    private $receivers;
    private $receiverMapping;
    private $receiverNames;

    public function __construct($receivers, $receiverMapping, $receiverNames)
    {
        $this->receivers = $receivers;
        $this->receiverMapping = $receiverMapping;
        $this->receiverNames = $receiverNames;
    }

    /**
     * @return mixed
     */
    public function getReceivers()
    {
        return $this->receivers;
    }

    /**
     * @return mixed
     */
    public function getReceiverMapping()
    {
        return $this->receiverMapping;
    }

    /**
     * @return mixed
     */
    public function getReceiverNames()
    {
        return $this->receiverNames;
    }
}
