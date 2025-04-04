<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\VerificationEmailController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

// تفعيل البريد الإلكتروني
Route::get('/email/verify/{user_id}', [VerificationEmailController::class, 'emailVerify'])
->name('verification.verify');
Route::post('/resend-email-verify', [VerificationEmailController::class, 'resendEmailVerificationMail'])->middleware('auth:sanctum');

Route::post('/forgot-password', [VerificationEmailController::class, 'forgotPassword'])->middleware('api');
Route::post('/reset-password', [VerificationEmailController::class, 'resetPassword'])->middleware('api')->name('password.reset');