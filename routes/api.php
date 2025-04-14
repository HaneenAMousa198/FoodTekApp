<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\VerificationEmailController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\CallController;
use App\Http\Controllers\Api\DeliveryController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\IssueController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\OfferController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderItemController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\RatedController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\RolePermissionController;
use App\Http\Controllers\Api\StaffController;
use App\Http\Controllers\Api\CategoryController;

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



Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('chats', ChatController::class);
    Route::apiResource('addresses', AddressController::class);
    Route::apiResource('calls', CallController::class);
    Route::apiResource('deliveries', DeliveryController::class);
    Route::apiResource('favorites', FavoriteController::class);
    Route::apiResource('issues', IssueController::class);
    Route::apiResource('menues', MenuController::class);
    Route::apiResource('notifications', NotificationController::class);
    Route::apiResource('offers', OfferController::class);
    Route::apiResource('orders', OrderController::class);
    Route::apiResource('order-items', OrderItemController::class);
    Route::apiResource('permissions', PermissionController::class);
    Route::apiResource('rateds', RatedController::class);
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('role-permissions', RolePermissionController::class);
    Route::apiResource('staff', StaffController::class);
    Route::apiResource('categories', CategoryController::class);
});