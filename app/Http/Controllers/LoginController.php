<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function getOtp(Request $request)
    {
        $user = User::findOrCreateByPhone($request->phone);
        $token = app('otp')->create($user, $length = 4);
        $user->notify($token->toNotification());
    }

    public function loginWithOtp(Request $request)
    {
        $user = User::findOrCreateByPhone($request->phone);
        $validator = Validator::make($request->all(), [
            'phone' => [
                'required',
                'string',
                'min:8',
                'max:16'
            ],
            'otp' => [
                'required',
                'digits:4',
                function ($attribute, $value, $fail) use ($user) {
                    $token = app('otp')->retrieveByPlainText($user, $value);
                    if (!$token || $token->expired()) {
                        $fail('OTP is invalid.');
                    }
                },
            ]
        ]);

        if ($validator->fails()) {
            return ['error' => $validator->errors()->messages()];
        }

        $token = $user->createToken('login');
        return ['token' => $token->plainTextToken];
    }
}
