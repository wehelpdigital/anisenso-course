@extends('layouts.app')

@section('title', 'Reset Password - Ani-Senso Academy')

@php $btcUrl = rtrim(config('app.btc_check_url'), '/'); @endphp

@section('content')
<div class="min-h-[85vh] flex items-center justify-center px-4 py-12 bg-gray-100">
    <div class="w-full max-w-md">
        <!-- Logo & Title -->
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="inline-block mb-4">
                <img src="{{ $btcUrl }}/wp-content/uploads/2025/12/test-logo-big-2-scaled.png" alt="AniSenso" class="h-14 w-auto mx-auto">
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Create New Password</h1>
            <p class="mt-2 text-gray-500">Enter your new password below</p>
        </div>

        <!-- Reset Password Card -->
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

            <!-- Account Info -->
            <div class="mb-6 p-4 rounded-xl bg-gray-50 border border-gray-200">
                <p class="text-sm text-gray-600">
                    Resetting password for: <span class="font-semibold text-gray-900">{{ $email }}</span>
                </p>
            </div>

            <form method="POST" action="{{ route('password.update') }}" class="space-y-5" x-data="{ loading: false, showPassword: false, showConfirm: false }">
                @csrf

                <!-- New Password Input -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        New Password
                    </label>
                    <div class="relative">
                        <input
                            :type="showPassword ? 'text' : 'password'"
                            id="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            placeholder="Enter new password"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand-yellow/50 focus:border-brand-yellow transition-colors pr-12"
                        >
                        <button
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 transition-colors"
                        >
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    <p class="mt-2 text-xs text-gray-500">
                        Must be at least 8 characters
                    </p>
                </div>

                <!-- Confirm Password Input -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                        Confirm New Password
                    </label>
                    <div class="relative">
                        <input
                            :type="showConfirm ? 'text' : 'password'"
                            id="password_confirmation"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="Confirm new password"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand-yellow/50 focus:border-brand-yellow transition-colors pr-12"
                        >
                        <button
                            type="button"
                            @click="showConfirm = !showConfirm"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 transition-colors"
                        >
                            <svg x-show="!showConfirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="showConfirm" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    :disabled="loading"
                    @click="loading = true"
                    class="w-full py-3 px-4 bg-brand-yellow hover:bg-brand-yellow-hover text-brand-dark font-bold rounded-xl transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-brand-yellow focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0"
                >
                    <span x-show="!loading">Reset Password</span>
                    <span x-show="loading" x-cloak class="flex items-center justify-center gap-2">
                        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Resetting...
                    </span>
                </button>
            </form>
        </div>

        <!-- Cancel Link -->
        <div class="text-center mt-6">
            <a href="{{ route('password.cancel') }}" class="text-gray-500 hover:text-red-500 transition-colors">
                Cancel and return to Sign In
            </a>
        </div>
    </div>
</div>
@endsection
