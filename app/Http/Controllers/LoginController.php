<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function getOtp(Request $request)
    {
        $phone = $request->phone;
        $user = User::where('phone', $phone)->first();
        $token = app('otp')->create($user->id, $length = 4);
        $user->notify($token->toNotification());
    }

    public function loginWithOtp(Request $request)
    {
        $phone = $request->phone;
        $otp = $request->otp;

        $user = User::where('phone', $phone)->first();
        if (app('otp')->check($user->id, $otp)) {
            $token = $user->createToken('login');
            return ['token' => $token->plainTextToken];
        } else {
            abort(403, 'Invalid OTP code');
        }
    }
}
