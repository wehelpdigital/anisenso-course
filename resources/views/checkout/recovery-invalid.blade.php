@extends('layouts.app')

@section('title', 'Invalid Recovery Link - Ani-Senso Academy')

@php $btcUrl = rtrim(config('app.btc_check_url'), '/'); @endphp

@section('content')
<div class="min-h-[85vh] flex items-center justify-center px-4 py-12 bg-gray-100">
    <div class="w-full max-w-md">
        <!-- Logo & Title -->
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="inline-block mb-4">
                <img src="{{ asset('images/logo.png') }}" alt="AniSenso" class="h-14 w-auto mx-auto">
            </a>
        </div>

        <!-- Invalid Link Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 p-8 text-center">
            <!-- Icon -->
            <div class="mx-auto w-20 h-20 rounded-full bg-red-100 flex items-center justify-center mb-6">
                @if($reason === 'expired')
                <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                @else
                <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                @endif
            </div>

            <!-- Message -->
            <h1 class="text-2xl font-bold text-gray-900 mb-3">
                @if($reason === 'expired')
                Link Expired
                @else
                Invalid Link
                @endif
            </h1>

            <p class="text-gray-600 mb-6">
                {{ $message }}
            </p>

            @if(isset($orderNumber))
            <p class="text-sm text-gray-500 mb-6">
                Order: <span class="font-medium">{{ $orderNumber }}</span>
            </p>
            @endif

            <!-- Help Text -->
            <div class="bg-gray-50 rounded-xl p-4 mb-6">
                <p class="text-sm text-gray-600">
                    @if($reason === 'expired')
                    Recovery links are valid for 7 days. If you still want to purchase the course, please start a new checkout.
                    @else
                    This link may have already been used or is no longer valid. Please contact support if you need assistance.
                    @endif
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3">
                <a href="{{ route('checkout') }}" class="block w-full py-3 px-4 bg-brand-yellow hover:bg-brand-yellow-hover text-brand-dark font-bold rounded-xl transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 text-center">
                    Start New Checkout
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
