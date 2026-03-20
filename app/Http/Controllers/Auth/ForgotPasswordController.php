<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendOtpCode;
use App\Models\ClientAccessLogin;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    protected OtpService $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Show the forgot password form (Step 1: Enter Email)
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle forgot password request - send OTP via email
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
        ]);

        $email = strtolower($request->email);

        // Check if user exists with this email
        $user = ClientAccessLogin::where('clientEmailAddress', $email)
            ->where('isActive', 1)
            ->where('deleteStatus', 1)
            ->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['We couldn\'t find an account with that email address.'],
            ]);
        }

        // Check cooldown
        $cooldownCheck = $this->otpService->canRequestNewOtp($email);
        if (!$cooldownCheck['allowed']) {
            throw ValidationException::withMessages([
                'email' => [$cooldownCheck['message']],
            ]);
        }

        // Generate OTP
        $otpCode = $this->otpService->generate($email);

        // Send OTP via email
        try {
            Mail::to($email)->send(new SendOtpCode($otpCode, $user->clientFirstName));
        } catch (\Exception $e) {
            // Log the error but don't expose details to user
            \Log::error('Failed to send OTP email: ' . $e->getMessage());
            throw ValidationException::withMessages([
                'email' => ['Failed to send verification code. Please try again later.'],
            ]);
        }

        // Store email in session for the next step
        session(['password_reset_email' => $email]);

        return redirect()->route('password.verify-otp')
            ->with('success', 'A verification code has been sent to your email address.');
    }

    /**
     * Show the OTP verification form (Step 2: Enter OTP)
     */
    public function showVerifyOtpForm()
    {
        // Ensure email is in session
        if (!session('password_reset_email')) {
            return redirect()->route('password.request')
                ->with('error', 'Please enter your email first.');
        }

        return view('auth.verify-otp', [
            'email' => session('password_reset_email'),
            'expiryMinutes' => $this->otpService->getExpiryMinutes(),
        ]);
    }

    /**
     * Verify the OTP code
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ], [
            'otp.required' => 'Please enter the verification code.',
            'otp.size' => 'The verification code must be 6 digits.',
        ]);

        $email = session('password_reset_email');

        if (!$email) {
            return redirect()->route('password.request')
                ->with('error', 'Session expired. Please start over.');
        }

        // Verify OTP
        $result = $this->otpService->verify($email, $request->otp);

        if (!$result['success']) {
            throw ValidationException::withMessages([
                'otp' => [$result['message']],
            ]);
        }

        // Mark that OTP is verified in session
        session(['password_reset_verified' => true]);

        return redirect()->route('password.reset')
            ->with('success', 'Code verified! Please enter your new password.');
    }

    /**
     * Resend OTP code
     */
    public function resendOtp()
    {
        $email = session('password_reset_email');

        if (!$email) {
            return redirect()->route('password.request')
                ->with('error', 'Session expired. Please start over.');
        }

        // Check cooldown
        $cooldownCheck = $this->otpService->canRequestNewOtp($email);
        if (!$cooldownCheck['allowed']) {
            return redirect()->route('password.verify-otp')
                ->with('error', $cooldownCheck['message']);
        }

        // Get user info for email
        $user = ClientAccessLogin::where('clientEmailAddress', $email)->first();

        if (!$user) {
            return redirect()->route('password.request')
                ->with('error', 'Account not found. Please start over.');
        }

        // Generate new OTP
        $otpCode = $this->otpService->generate($email);

        // Send OTP via email
        try {
            Mail::to($email)->send(new SendOtpCode($otpCode, $user->clientFirstName));
        } catch (\Exception $e) {
            \Log::error('Failed to resend OTP email: ' . $e->getMessage());
            return redirect()->route('password.verify-otp')
                ->with('error', 'Failed to send verification code. Please try again.');
        }

        return redirect()->route('password.verify-otp')
            ->with('success', 'A new verification code has been sent to your email.');
    }

    /**
     * Show reset password form (Step 3: Enter New Password)
     */
    public function showResetPasswordForm()
    {
        $email = session('password_reset_email');
        $verified = session('password_reset_verified');

        // Ensure email and OTP verification
        if (!$email || !$verified) {
            return redirect()->route('password.request')
                ->with('error', 'Please complete the verification process first.');
        }

        // Check if OTP is still valid
        if (!$this->otpService->hasVerifiedOtp($email)) {
            session()->forget(['password_reset_email', 'password_reset_verified']);
            return redirect()->route('password.request')
                ->with('error', 'Session expired. Please start over.');
        }

        return view('auth.reset-password', [
            'email' => $email,
        ]);
    }

    /**
     * Handle password reset
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.required' => 'Please enter a new password.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        $email = session('password_reset_email');
        $verified = session('password_reset_verified');

        if (!$email || !$verified) {
            return redirect()->route('password.request')
                ->with('error', 'Session expired. Please start over.');
        }

        // Verify OTP is still valid
        if (!$this->otpService->hasVerifiedOtp($email)) {
            session()->forget(['password_reset_email', 'password_reset_verified']);
            return redirect()->route('password.request')
                ->with('error', 'Session expired. Please start over.');
        }

        // Update the user's password
        $user = ClientAccessLogin::where('clientEmailAddress', $email)->first();

        if (!$user) {
            return redirect()->route('password.request')
                ->with('error', 'Account not found.');
        }

        $user->clientPassword = Hash::make($request->password);
        $user->save();

        // Mark OTP as used
        $this->otpService->markAsUsed($email);

        // Clear session
        session()->forget(['password_reset_email', 'password_reset_verified']);

        return redirect()->route('login')
            ->with('success', 'Your password has been reset successfully. Please sign in with your new password.');
    }

    /**
     * Cancel password reset and return to login
     */
    public function cancel()
    {
        session()->forget(['password_reset_email', 'password_reset_verified']);
        return redirect()->route('login');
    }
}
