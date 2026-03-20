@extends('layouts.app')

@section('title', 'Forgot Password - Ani-Senso Academy')

@php $btcUrl = rtrim(config('app.btc_check_url'), '/'); @endphp

@section('content')
<div class="min-h-[85vh] flex items-center justify-center px-4 py-12 bg-gray-100">
    <div class="w-full max-w-md">
        <!-- Logo & Title -->
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="inline-block mb-4">
                <img src="{{ $btcUrl }}/wp-content/uploads/2025/12/test-logo-big-2-scaled.png" alt="AniSenso" class="h-14 w-auto mx-auto">
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Forgot Password?</h1>
            <p class="mt-2 text-gray-500">Enter your email to receive a verification code</p>
        </div>

        <!-- Forgot Password Card -->
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

            <!-- Info Message -->
            @if (session('error'))
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200">
                <div class="flex items-center gap-2">
                    <span class="text-red-500">⚠️</span>
                    <p class="text-sm text-red-600 font-medium">{{ session('error') }}</p>
                </div>
            </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5" x-data="{ loading: false }" @submit="loading = true">
                @csrf

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        Email Address
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="Enter your email address"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand-yellow/50 focus:border-brand-yellow transition-colors"
                    >
                    <p class="mt-2 text-sm text-gray-500">
                        We'll send a 6-digit verification code to this email.
                    </p>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    :disabled="loading"
                    class="w-full py-3 px-4 bg-brand-yellow hover:bg-brand-yellow-hover text-brand-dark font-bold rounded-xl transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-brand-yellow focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0"
                >
                    <span x-show="!loading">Send Verification Code</span>
                    <span x-show="loading" x-cloak class="flex items-center justify-center gap-2">
                        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Sending...
                    </span>
                </button>
            </form>
        </div>

        <!-- Back to Login Link -->
        <div class="text-center mt-6">
            <a href="{{ route('login') }}" class="text-gray-500 hover:text-brand-yellow transition-colors">
                ← Back to Sign In
            </a>
        </div>
    </div>
</div>
@endsection
