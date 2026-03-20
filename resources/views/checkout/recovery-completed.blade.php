@extends('layouts.app')

@section('title', 'Order Completed - Ani-Senso Academy')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center px-4 py-12 bg-gray-100">
    <div class="w-full max-w-md">
        <!-- Logo & Title -->
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="inline-block mb-4">
                <img src="http://anisenso.test/wp-content/uploads/2025/12/test-logo-big-2-scaled.png" alt="AniSenso" class="h-14 w-auto mx-auto">
            </a>
        </div>

        <!-- Completed Order Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 p-8 text-center">
            <!-- Success Icon -->
            <div class="mx-auto w-20 h-20 rounded-full bg-green-100 flex items-center justify-center mb-6">
                <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>

            <!-- Message -->
            <h1 class="text-2xl font-bold text-gray-900 mb-3">Order Already Completed!</h1>

            <p class="text-gray-600 mb-6">
                {{ $message }}
            </p>

            <!-- Order Details -->
            <div class="bg-green-50 rounded-xl p-4 mb-6 text-left">
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Order Number:</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $order->orderNumber }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Course:</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $productName }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Status:</span>
                        <span class="inline-flex items-center gap-1 text-sm font-semibold text-green-600">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            {{ ucfirst($order->orderStatus) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Access Info -->
            <div class="bg-brand-yellow/10 rounded-xl p-4 mb-6">
                <p class="text-sm text-gray-700">
                    You can access your course by logging in to your account. If you have any issues, please contact support.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3">
                <a href="{{ route('login') }}" class="block w-full py-3 px-4 bg-brand-yellow hover:bg-brand-yellow-hover text-brand-dark font-bold rounded-xl transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 text-center">
                    Login to Access Course
                </a>
                <a href="{{ url('/') }}" class="block w-full py-3 px-4 bg-white hover:bg-gray-50 text-gray-700 font-medium rounded-xl border-2 border-gray-200 transition-all text-center">
                    Back to Home
                </a>
            </div>
        </div>

        <!-- Contact Support -->
        <div class="text-center mt-6">
            <p class="text-sm text-gray-500">
                Need help? Contact us at <a href="mailto:support@anisenso.com" class="text-brand-green hover:underline">support@anisenso.com</a>
            </p>
        </div>
    </div>
</div>
@endsection
