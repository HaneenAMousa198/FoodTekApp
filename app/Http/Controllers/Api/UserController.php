<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class UserController extends Controller
{
    public function __construct()
    {
        // يمكن تحكم بالـ middleware هنا لو تحتاج
        $this->middleware('auth:sanctum')->only(['resendEmailVerificationMail', 'logout']);
        $this->middleware('signed')->only('emailVerify');
        $this->middleware('throttle:6,1')->only('emailVerify', 'resendEmailVerificationMail');
    }

    // *********** وظائف إدارة المستخدمين ***********

    public function index()
    {
        $users = User::with('role')->latest()->get();
        return UserResource::collection($users);
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        return new UserResource($user->load('role'));
    }

    public function show(User $user)
    {
        return new UserResource($user->load('role'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $user->update($data);
        return new UserResource($user->load('role'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully.'], 200);
    }

    // *********** تسجيل المستخدم مع OTP على الإيميل ***********

    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'phone_number' => 'required',
            'birth_date' => 'required|date',
        ]);

        $otp = rand(100000, 999999);

        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'birth_date' => $request->birth_date,
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(10),
            'role_id' => $request->role_id ?? 2,

        ]);

        Mail::raw("Your OTP is: $otp", function ($message) use ($user) {
            $message->to($user->email)->subject("OTP Verification");
        });

        return response()->json(['message' => 'Registered successfully. Please verify your email using the OTP sent.']);
    }

    // *********** التحقق من OTP ***********

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || $user->otp !== $request->otp || Carbon::now()->gt($user->otp_expires_at)) {
            throw ValidationException::withMessages(['otp' => 'Invalid or expired OTP.']);
        }

        // تعيين أن الإيميل موثق بعد التحقق من OTP
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->email_verified_at = now();  // تحديث حالة التحقق من الإيميل
        $user->save();

        return response()->json(['message' => 'OTP verified successfully.']);
    }

    // *********** تسجيل الدخول ***********

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages(['email' => 'Invalid credentials.']);
        }

        if ($user->otp !== null) {
            return response()->json(['message' => 'Please verify your OTP first.'], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }

    // *********** تسجيل الخروج ***********

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully.']);
    }

    // *********** التحقق من البريد الإلكتروني ***********

    public function emailVerify($user_id, Request $request)
    {
        if (!$request->hasValidSignature()) {
            return response()->json(['message' => 'Invalid or expired verification code.'], 400);
        }

        $user = User::findOrFail($user_id);

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 400);
        }

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            return response()->json([
                'message' => 'Email address successfully verified',
                'user' => $user,
            ]);
        }

        return response()->json(['message' => 'Email address already verified.'], 400);
    }

    // *********** إعادة إرسال رابط التحقق من البريد الإلكتروني ***********

    public function resendEmailVerificationMail(Request $request)
    {
        $user = $request->user();

        $user = User::where('email', $request->email)->firstOrFail();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 400);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified.'], 400);
        }

        $user->sendEmailVerificationNotification();

        return response()->json(['message' => 'Email verification link sent to your email address']);
    }

    // *********** إعادة إرسال رابط إعادة تعيين كلمة المرور ***********

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Reset password link sent successfully.'])
            : response()->json(['message' => 'Failed to send reset link.'], 500);
    }

    // *********** إعادة تعيين كلمة المرور ***********

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60)
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['message' => 'Password reset successfully.'])
            : response()->json(['message' => 'Failed to reset password.'], 500);
    }
}
