<?php

namespace App\Providers;

use App\Notifications\Otp\TwilioToken;
use Erdemkeren\Otp\Encryptor;
use Erdemkeren\Otp\OtpService;
use Erdemkeren\Otp\PasswordGeneratorManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register OTP service with twilio notifications support

        $otp_service = $this->createOtpServiceInstance();
        $this->app->singleton('otp', function () use ($otp_service) {
            return $otp_service;
        });
    }

    private function createOtpServiceInstance(): OtpService
    {
        return new OtpService(
            new PasswordGeneratorManager(),
            new Encryptor(config('app.secret')),
            config('otp.password_generator', 'numeric-no-0'),
            4,
            TwilioToken::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
