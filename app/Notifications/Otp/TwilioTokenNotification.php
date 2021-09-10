<?php


namespace App\Notifications\Otp;


use Erdemkeren\Otp\TokenNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\Twilio\TwilioSmsMessage;

class TwilioTokenNotification extends TokenNotification implements ShouldQueue
{

    public function toTwilio(): TwilioSmsMessage
    {
        return (new TwilioSmsMessage())
            ->content("Your one-time password: " . $this->token->plainText());
    }
}
