<?php

namespace App\Service;

use Twilio\Rest\Client;

class SMSService
{
    const SMS_FROM = '+15005550006';
    const SMS_TO = '+15005550010';

    /** @var Client $client */
    private $client;

    /** @var string $twilioUsername */
    public $twilioUsername;

    /** @var string $twilioPassword */
    public $twilioPassword;

    public function __construct($twilioUsername,$twilioPassword)
    {
        $this->twilioUsername = $twilioUsername;
        $this->twilioPassword = $twilioPassword;
        $this->client = new Client($this->twilioUsername, $this->twilioPassword);
    }


    public function sendSMS($to, $message)
    {
        try {
            $this->client->messages->create(
                $to,
                [
                    'from' => self::SMS_FROM,
                    'body' => $message
                ]
            );
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}
