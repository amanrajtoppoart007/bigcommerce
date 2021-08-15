<?php


namespace App\Library\TextLocal;


use Exception;
class TextLocal extends TextLocalLib
{
    private $sender;

    public function __construct()
    {
        parent::__construct('', '', 'QxR3Do53a2w-2G8lL0bwsIv9cYgfNlaJ9bP8yPwxwP');
        $this->sender = 'KSVPRO' ; # Default sender name
    }

    /**
     * @param string $message
     * @param string $receiver
     * @param string $sender
     * @return array|mixed
     * @throws Exception
     */
    public function send(string $message, $receiver, $sender = '')
    {
        return $this->sendSms([$receiver], $message, $sender != '' ? $sender : $this->sender);
    }
}
