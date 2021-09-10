<?php


namespace App\Notifications\Otp;


use Erdemkeren\Otp\Token;
use Erdemkeren\Otp\TokenInterface;
use Illuminate\Notifications\Notification;

class TwilioToken extends Token implements TokenInterface
{
    public function toNotification(): Notification
    {
        return new TwilioTokenNotification($this);
    }

    /**
     * Create a new token.
     *
     * @param $authenticableId
     * @param string      $cipherText
     * @param null|string $plainText
     *
     * @return TokenInterface
     */
    public static function create(
        $authenticableId,
        string $cipherText,
        ?string $plainText = null
    ): TokenInterface {
        $token = new self($authenticableId, $cipherText, $plainText);
        $token->persist();
        return $token;
    }
}
