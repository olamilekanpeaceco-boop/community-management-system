<?php

use App\Features\Auth\Controllers\AuthController;
use App\Features\Auth\Controllers\EmailVerificationController;
use App\Features\Auth\Controllers\PasswordResetController;
use App\Features\Auth\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegistration'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('forgot-password', [PasswordResetController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
    Route::get('reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('verify-email', [EmailVerificationController::class, 'showVerificationNotice'])->name('verification.notice');
    Route::post('verify-email/send', [EmailVerificationController::class, 'sendVerificationEmail'])->name('verification.send');
    Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verifyEmail'])->middleware('signed')->name('verification.verify');
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('avatar', [ProfileController::class, 'uploadAvatar'])->name('profile.avatar');
        Route::delete('avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');
        Route::get('change-password', [ProfileController::class, 'showChangePasswordForm'])->name('password.change');
        Route::patch('change-password', [ProfileController::class, 'updatePassword'])->name('password.change.update');
    });
});
