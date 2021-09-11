<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\Otp\TwilioTokenNotification;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Notification;
use Otp;
use Tests\TestCase;

class CustomerOtpLoginTest extends TestCase
{
    use WithFaker;

    private $phone;

    protected function setUp(): void
    {
        parent::setUp();
        $this->phone = $this->faker->e164PhoneNumber();
    }

    public function test_request_otp()
    {
        Notification::fake();
        $response = $this->postJson('api/v1/otp', ['phone' => $this->phone]);
        Notification::assertSentTo(
            [User::where('phone', $this->phone)->first()],
            TwilioTokenNotification::class
        );
        $response->assertStatus(200);
    }

    public function test_login_with_otp()
    {
        Otp::shouldReceive('create')->andReturn(TwilioTokenNotification::class);
        Otp::shouldReceive('retrieveByPlainText->expired')->andReturn(false);

        $response = $this->postJson('api/v1/login', [
            'phone' => $this->phone,
            'otp' => '1111',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->has('token')
                ->whereType('token', 'string');
        });
    }
}
