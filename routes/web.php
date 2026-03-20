<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Public pages
Route::get('/courses', function () {
    return view('courses.index');
})->name('courses.index');

Route::get('/about', function () {
    return view('about');
})->name('about');

// Blog routes - fetch from as_blogs table
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/api/blog/posts', [BlogController::class, 'apiIndex'])->name('blog.api');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/unladsaka-rhizocote-micronutrient-fertilizer-for-crops-high-yield', function () {
    return view('tech.rhizocote');
})->name('tech.rhizocote');

Route::get('/get-online-course', function () {
    return view('courses.online-course');
})->name('courses.online');

Route::get('/join-community', function () {
    return view('community.join');
})->name('community.join');

// Checkout routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::get('/checkout/step-1', [CheckoutController::class, 'stepOnePage'])->name('checkout.step1.page');
Route::get('/checkout/step-2', [CheckoutController::class, 'stepTwoPage'])->name('checkout.step2.page');
Route::get('/checkout/continue/{token}', [CheckoutController::class, 'continueCheckout'])->name('checkout.continue');
Route::post('/checkout/step-1', [CheckoutController::class, 'stepOne'])->name('checkout.step1');
Route::post('/checkout/step-2', [CheckoutController::class, 'stepTwo'])->name('checkout.step2');
Route::post('/checkout/step-3', [CheckoutController::class, 'stepThree'])->name('checkout.step3');
Route::post('/checkout/login', [CheckoutController::class, 'loginExistingAccount'])->name('checkout.login');
Route::post('/checkout/check-email', [CheckoutController::class, 'checkEmailExists'])->name('checkout.check-email');
Route::get('/checkout/reset', [CheckoutController::class, 'resetCheckout'])->name('checkout.reset');
Route::get('/checkout/salamat/{token}', [CheckoutController::class, 'showConfirmation'])->name('checkout.confirmation');

// Guest routes (not authenticated)
Route::middleware('guest:client')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

    // Password Reset Routes (Email OTP)
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('password.email');
    Route::get('/verify-otp', [ForgotPasswordController::class, 'showVerifyOtpForm'])->name('password.verify-otp');
    Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('password.verify-otp.submit');
    Route::get('/resend-otp', [ForgotPasswordController::class, 'resendOtp'])->name('password.resend-otp');
    Route::get('/reset-password', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
    Route::get('/cancel-reset', [ForgotPasswordController::class, 'cancel'])->name('password.cancel');
});

// Authenticated routes
Route::middleware('auth:client')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
