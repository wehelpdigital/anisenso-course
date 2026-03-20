<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OtpService
{
    /**
     * OTP expiry time in minutes
     */
    protected int $expiryMinutes = 15;

    /**
     * Maximum verification attempts allowed
     */
    protected int $maxAttempts = 5;

    /**
     * Cooldown period in minutes before allowing new OTP request
     */
    protected int $cooldownMinutes = 1;

    /**
     * Generate and store a new OTP for the given email
     */
    public function generate(string $email): string
    {
        // Invalidate any existing unused OTPs for this email
        $this->invalidateExisting($email);

        // Generate 6-digit OTP
        $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Store the OTP
        DB::table('client_password_reset_otps')->insert([
            'email' => strtolower($email),
            'otp_code' => $otpCode,
            'attempts' => 0,
            'expires_at' => Carbon::now()->addMinutes($this->expiryMinutes),
            'verified_at' => null,
            'used' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return $otpCode;
    }

    /**
     * Verify the OTP code for the given email
     */
    public function verify(string $email, string $otpCode): array
    {
        $record = DB::table('client_password_reset_otps')
            ->where('email', strtolower($email))
            ->where('used', false)
            ->whereNull('verified_at')
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$record) {
            return [
                'success' => false,
                'message' => 'No active OTP found. Please request a new one.',
            ];
        }

        // Check if expired
        if (Carbon::parse($record->expires_at)->isPast()) {
            return [
                'success' => false,
                'message' => 'This OTP has expired. Please request a new one.',
            ];
        }

        // Check max attempts
        if ($record->attempts >= $this->maxAttempts) {
            return [
                'success' => false,
                'message' => 'Too many failed attempts. Please request a new OTP.',
            ];
        }

        // Verify the code
        if ($record->otp_code !== $otpCode) {
            // Increment attempts
            DB::table('client_password_reset_otps')
                ->where('id', $record->id)
                ->increment('attempts');

            $remainingAttempts = $this->maxAttempts - $record->attempts - 1;

            return [
                'success' => false,
                'message' => "Invalid OTP code. {$remainingAttempts} attempts remaining.",
            ];
        }

        // Mark as verified
        DB::table('client_password_reset_otps')
            ->where('id', $record->id)
            ->update([
                'verified_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        return [
            'success' => true,
            'message' => 'OTP verified successfully.',
            'otp_id' => $record->id,
        ];
    }

    /**
     * Mark OTP as used after password reset
     */
    public function markAsUsed(string $email): void
    {
        DB::table('client_password_reset_otps')
            ->where('email', strtolower($email))
            ->whereNotNull('verified_at')
            ->where('used', false)
            ->update([
                'used' => true,
                'updated_at' => Carbon::now(),
            ]);
    }

    /**
     * Check if email has a verified OTP ready for password reset
     */
    public function hasVerifiedOtp(string $email): bool
    {
        return DB::table('client_password_reset_otps')
            ->where('email', strtolower($email))
            ->whereNotNull('verified_at')
            ->where('used', false)
            ->where('expires_at', '>', Carbon::now())
            ->exists();
    }

    /**
     * Check if user can request a new OTP (cooldown check)
     */
    public function canRequestNewOtp(string $email): array
    {
        $lastOtp = DB::table('client_password_reset_otps')
            ->where('email', strtolower($email))
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$lastOtp) {
            return ['allowed' => true];
        }

        $createdAt = Carbon::parse($lastOtp->created_at);
        $cooldownEnds = $createdAt->addMinutes($this->cooldownMinutes);

        if (Carbon::now()->lt($cooldownEnds)) {
            $secondsRemaining = Carbon::now()->diffInSeconds($cooldownEnds);
            return [
                'allowed' => false,
                'seconds_remaining' => $secondsRemaining,
                'message' => "Please wait {$secondsRemaining} seconds before requesting a new OTP.",
            ];
        }

        return ['allowed' => true];
    }

    /**
     * Invalidate all existing unused OTPs for the email
     */
    protected function invalidateExisting(string $email): void
    {
        DB::table('client_password_reset_otps')
            ->where('email', strtolower($email))
            ->where('used', false)
            ->update([
                'used' => true,
                'updated_at' => Carbon::now(),
            ]);
    }

    /**
     * Get OTP expiry time in minutes
     */
    public function getExpiryMinutes(): int
    {
        return $this->expiryMinutes;
    }

    /**
     * Clean up expired OTPs (for scheduled task)
     */
    public function cleanupExpired(): int
    {
        return DB::table('client_password_reset_otps')
            ->where('expires_at', '<', Carbon::now()->subDay())
            ->delete();
    }
}
