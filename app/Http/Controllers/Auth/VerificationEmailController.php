<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller; 

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class VerificationEmailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('resend');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
    
    public function emailVerify($user_id, Request $request) 
    {
        if (!$request->hasValidSignature()) {
            return response()->json([
                'message' => 'Invalid or expired verification code.',
            ], 400);
        }

        $user = User::findOrFail($user_id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found.',
            ], 400);
        }

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            return response()->json([
                'message' => 'Email address successfully verified',
                'user' => $user,
            ]);
        }

        return response()->json([
            'message' => 'Email address already verified.',
        ], 400);
    }

    public function resendEmailVerificationMail(Request $request) 
    {
        $user_id = $request->input('user_id');

        $user = User::findOrFail($user_id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found.',
            ], 400);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Email already verified.',
            ], 400);
        }

        $user->sendEmailVerificationNotification();

        return response()->json([
            'message' => 'Email verification link sent to your email address',
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response()->json([
                'message' => trans($status),
            ])
            : response()->json([
                'message' => trans($status),
            ], 400);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json([
                'message' => trans($status),
            ])
            : response()->json([
                'message' => trans($status),
            ], 400);
    }
}