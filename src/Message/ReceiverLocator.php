<?php


namespace App\Message;


class ReceiverLocator
{
    private $receivers;

    public function __construct($receivers)
    {
        $this->receivers = $receivers;
    }

    /**
     * @return mixed
     */
    public function getReceivers()
    {
        return $this->receivers;
    }


}
