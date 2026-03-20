@extends('layouts.app')

@section('title', 'Payment Pending Verification - Ani-Senso Academy')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center px-4 py-12 bg-gray-100">
    <div class="w-full max-w-md">
        <!-- Logo & Title -->
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="inline-block mb-4">
                <img src="http://anisenso.test/wp-content/uploads/2025/12/test-logo-big-2-scaled.png" alt="AniSenso" class="h-14 w-auto mx-auto">
            </a>
        </div>

        <!-- Pending Verification Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 p-8 text-center">
            <!-- Pending Icon -->
            <div class="mx-auto w-20 h-20 rounded-full bg-yellow-100 flex items-center justify-center mb-6">
                <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>

            <!-- Message -->
            <h1 class="text-2xl font-bold text-gray-900 mb-3">Payment Under Review</h1>

            <p class="text-gray-600 mb-6">
                {{ $message }}
            </p>

            <!-- Order Details -->
            <div class="bg-yellow-50 rounded-xl p-4 mb-6 text-left">
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
                        <span class="text-sm text-gray-600">Amount:</span>
                        <span class="text-sm font-semibold text-gray-900">P{{ number_format($order->grandTotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Payment Status:</span>
                        <span class="inline-flex items-center gap-1 text-sm font-semibold text-yellow-600">
                            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Pending Verification
                        </span>
                    </div>
                </div>
            </div>

            <!-- Info Box -->
            <div class="bg-gray-50 rounded-xl p-4 mb-6">
                <h3 class="font-semibold text-gray-900 mb-2 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    What happens next?
                </h3>
                <ul class="text-sm text-gray-600 space-y-2 text-left">
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-brand-green flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Our team will verify your payment within 24 hours</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-brand-green flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>You'll receive an email once your payment is confirmed</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-brand-green flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Course access will be granted automatically after verification</span>
                    </li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3">
                <a href="{{ url('/') }}" class="block w-full py-3 px-4 bg-brand-yellow hover:bg-brand-yellow-hover text-brand-dark font-bold rounded-xl transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 text-center">
                    Back to Home
                </a>
            </div>
        </div>

        <!-- Contact Support -->
        <div class="text-center mt-6">
            <p class="text-sm text-gray-500">
                Questions about your payment? Contact us at <a href="mailto:support@anisenso.com" class="text-brand-green hover:underline">support@anisenso.com</a>
            </p>
        </div>
    </div>
</div>
@endsection
