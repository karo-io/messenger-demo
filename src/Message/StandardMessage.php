<?php


namespace App\Message;


class StandardMessage
{
    private $info;

    /**
     * @var \DateTime
     */
    private $created;

    public function __construct($info = null)
    {
        $this->info = $info;
        $this->created = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedDate(): \DateTime
    {
        return $this->created;
    }
}
