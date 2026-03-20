@extends('layouts.app')

@section('title', 'Verify Code - Ani-Senso Academy')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center px-4 py-12 bg-gray-100">
    <div class="w-full max-w-md">
        <!-- Logo & Title -->
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="inline-block mb-4">
                <img src="http://anisenso.test/wp-content/uploads/2025/12/test-logo-big-2-scaled.png" alt="AniSenso" class="h-14 w-auto mx-auto">
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Verify Your Email</h1>
            <p class="mt-2 text-gray-500">Enter the 6-digit code sent to</p>
            <p class="text-brand-green font-medium">{{ $email }}</p>
        </div>

        <!-- OTP Verification Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 p-8">
            <!-- Error Messages -->
            @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200">
                <div class="flex items-center gap-2">
                    <span class="text-red-500">⚠️</span>
                    <p class="text-sm text-red-600 font-medium">{{ $errors->first() }}</p>
                </div>
            </div>
            @endif

            <!-- Success Messages -->
            @if (session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200">
                <div class="flex items-center gap-2">
                    <span class="text-green-500">✓</span>
                    <p class="text-sm text-green-600 font-medium">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            @if (session('error'))
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200">
                <div class="flex items-center gap-2">
                    <span class="text-red-500">⚠️</span>
                    <p class="text-sm text-red-600 font-medium">{{ session('error') }}</p>
                </div>
            </div>
            @endif

            <form method="POST" action="{{ route('password.verify-otp.submit') }}" class="space-y-5" x-data="{ loading: false, otp: '' }" @submit="loading = true">
                @csrf

                <!-- OTP Input -->
                <div>
                    <label for="otp" class="block text-sm font-semibold text-gray-700 mb-2">
                        Verification Code
                    </label>
                    <input
                        type="text"
                        id="otp"
                        name="otp"
                        x-model="otp"
                        maxlength="6"
                        pattern="[0-9]{6}"
                        inputmode="numeric"
                        required
                        autofocus
                        autocomplete="one-time-code"
                        placeholder="000000"
                        @input="otp = $event.target.value.replace(/[^0-9]/g, '')"
                        class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl text-gray-900 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-brand-yellow/50 focus:border-brand-yellow transition-colors text-center text-2xl font-mono tracking-[0.5em]"
                    >
                </div>

                <!-- Timer Info -->
                <div class="text-center text-sm text-gray-500">
                    <p>Code expires in <span class="font-semibold text-brand-green">{{ $expiryMinutes }} minutes</span></p>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    :disabled="loading || otp.length !== 6"
                    class="w-full py-3 px-4 bg-brand-yellow hover:bg-brand-yellow-hover text-brand-dark font-bold rounded-xl transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-brand-yellow focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0"
                >
                    <span x-show="!loading">Verify Code</span>
                    <span x-show="loading" x-cloak class="flex items-center justify-center gap-2">
                        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Verifying...
                    </span>
                </button>

                <!-- Resend Code -->
                <div class="text-center pt-4 border-t border-gray-100">
                    <p class="text-sm text-gray-500 mb-2">Didn't receive the code?</p>
                    <a href="{{ route('password.resend-otp') }}" class="text-sm font-semibold text-brand-green hover:text-brand-green/80 transition-colors">
                        Resend Code
                    </a>
                </div>
            </form>
        </div>

        <!-- Navigation Links -->
        <div class="flex justify-between mt-6">
            <a href="{{ route('password.request') }}" class="text-gray-500 hover:text-brand-yellow transition-colors text-sm">
                ← Change Email
            </a>
            <a href="{{ route('password.cancel') }}" class="text-gray-500 hover:text-red-500 transition-colors text-sm">
                Cancel
            </a>
        </div>
    </div>
</div>
@endsection
