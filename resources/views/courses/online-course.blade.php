@extends('layouts.landing')

@section('title', 'Ang Lihim sa Mataas na Ani - Online Course | AniSenso Academy')

@php $btcUrl = rtrim(config('app.btc_check_url'), '/'); @endphp

@push('styles')
<style>
    .gradient-text {
        background: linear-gradient(135deg, #F5B041 0%, #ffd700 50%, #F5B041 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .pulse-glow {
        animation: pulseGlow 2.5s ease-in-out infinite;
    }

    @keyframes pulseGlow {
        0%, 100% {
            box-shadow: 0 0 0 0 rgba(245, 176, 65, 0.5),
                        0 4px 20px rgba(245, 176, 65, 0.3);
        }
        50% {
            box-shadow: 0 0 30px 10px rgba(245, 176, 65, 0.3),
                        0 4px 30px rgba(245, 176, 65, 0.4);
        }
    }

    .video-glow {
        box-shadow: 0 0 60px rgba(245, 176, 65, 0.15),
                    0 25px 50px rgba(0, 0, 0, 0.3);
    }

    .play-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 0 40px rgba(245, 176, 65, 0.6);
    }

    .price-slash {
        position: relative;
    }
    .price-slash::after {
        content: '';
        position: absolute;
        left: -5%;
        right: -5%;
        top: 50%;
        height: 3px;
        background: linear-gradient(90deg, transparent, #ef4444, transparent);
        transform: rotate(-12deg);
    }

    .card-hover {
        transition: all 0.3s ease;
    }
    .card-hover:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }

    .bg-pattern {
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .floating {
        animation: floating 3s ease-in-out infinite;
    }

    @keyframes floating {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    /* Sticky CTA bar animation */
    .sticky-bar {
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
    }
</style>
@endpush

@section('content')
<!-- Exit Intent Modal -->
<div x-data="exitIntentModal()"
     x-show="showModal"
     x-cloak
     class="fixed inset-0 z-[100] flex items-center justify-center p-4"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @mouseleave.window="handleMouseLeave($event)"
     @beforeunload.window="handleBeforeUnload()">

    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" @click="closeModal()"></div>

    <!-- Modal Content -->
    <div class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full overflow-hidden transform"
         x-show="showModal"
         x-transition:enter="transition ease-out duration-300 delay-100"
         x-transition:enter-start="opacity-0 scale-90 translate-y-8"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-90">

        <!-- Close Button -->
        <button @click="closeModal()" class="absolute top-4 right-4 z-10 w-8 h-8 bg-gray-100 hover:bg-gray-200 rounded-full flex items-center justify-center text-gray-500 hover:text-gray-700 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>

        <!-- Header Banner -->
        <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-4 text-center">
            <div class="flex items-center justify-center gap-2 text-white/90 text-sm font-medium mb-1">
                <svg class="w-5 h-5 animate-pulse" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                TEKA LANG!
            </div>
            <p class="text-white font-bold text-lg">Huwag Mo Pang Iwanan Ito!</p>
        </div>

        <!-- Content -->
        <div class="p-6 text-center">
            <div class="mb-4">
                <p class="text-gray-600 mb-4">Bago ka umalis, may <span class="font-bold text-brand-dark">LAST CHANCE OFFER</span> kami para sa iyo!</p>

                <!-- Special Price -->
                <div class="bg-gradient-to-br from-brand-yellow/10 to-brand-green/10 rounded-2xl p-5 mb-4">
                    <p class="text-sm text-gray-500 mb-2">Exclusive Exit Price:</p>
                    <div class="flex items-center justify-center gap-3">
                        <span class="text-gray-400 text-xl line-through" x-text="'₱' + originalPrice.toLocaleString()"></span>
                        <span class="text-4xl font-bold text-brand-green" x-text="'₱' + exitPrice.toLocaleString()"></span>
                    </div>
                    <p class="text-brand-green font-bold text-sm mt-2">
                        SAVE ₱<span x-text="(originalPrice - exitPrice).toLocaleString()"></span>!
                    </p>
                </div>

                <!-- Warning -->
                <div class="flex items-center justify-center gap-2 text-red-500 text-sm mb-4">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                    <span>Isang beses lang ito lalabas. Pagkatapos nito, wala na!</span>
                </div>
            </div>

            <!-- CTA Buttons -->
            <div class="space-y-3">
                <a :href="checkoutUrl"
                   @click="acceptOffer()"
                   class="block w-full bg-gradient-to-r from-brand-green to-brand-green-dark text-white py-4 px-6 rounded-xl font-bold text-lg hover:shadow-lg hover:scale-[1.02] transition-all duration-300">
                    OO, Kunin Ko Na Ito!
                </a>
                <button @click="closeModal()" class="block w-full text-gray-500 py-3 px-6 rounded-xl font-medium hover:bg-gray-100 transition-colors text-sm">
                    Hindi, ayoko ng discount
                </button>
            </div>

            <!-- Trust badges -->
            <div class="mt-5 pt-5 border-t border-gray-100">
                <div class="flex items-center justify-center gap-4 text-xs text-gray-400">
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-brand-green" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        30-Day Guarantee
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-brand-green" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                        Secure Checkout
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Minimal Sticky Header -->
<header class="fixed top-0 left-0 right-0 z-50 bg-brand-dark/95 sticky-bar border-b border-white/10"
        x-data="{ scrolled: false }"
        @scroll.window="scrolled = window.scrollY > 100">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
        <a href="{{ url('/') }}" class="flex items-center gap-2">
            <img src="{{ asset('images/logo.png') }}" alt="AniSenso" class="h-8 w-auto">
        </a>
        <a href="{{ route('checkout') }}"
           class="inline-flex items-center gap-2 bg-brand-yellow text-brand-dark px-5 py-2 rounded-lg font-bold text-sm hover:bg-brand-yellow-hover transition-all duration-300"
           :class="scrolled ? 'animate-pulse' : ''">
            <span>Mag-Enroll Na</span>
            <span x-show="$store.priceTimer && $store.priceTimer.showTimer" x-cloak class="bg-brand-dark/10 px-2 py-0.5 rounded text-xs" x-text="$store.priceTimer.formatTime()"></span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
        </a>
    </div>
</header>

<!-- Hero Section -->
<section class="relative bg-brand-dark bg-pattern pt-20 pb-16 md:pt-24 md:pb-20 overflow-hidden" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 100)">
    <!-- Decorative elements -->
    <div class="absolute top-20 left-10 w-72 h-72 bg-brand-yellow/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-10 right-10 w-96 h-96 bg-brand-green/10 rounded-full blur-3xl"></div>

    <div class="relative max-w-5xl mx-auto px-4 sm:px-6">
        <!-- Trust Badge -->
        <div class="text-center mb-6 transition-all duration-700"
             :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 -translate-y-6'">
            <span class="inline-flex items-center gap-2 bg-white/10 border border-white/20 text-white px-4 py-2 rounded-full text-sm">
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-green opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-green"></span>
                </span>
                10,000+ Farmers na Nakikinabang
            </span>
        </div>

        <!-- Main Headline -->
        <div class="text-center mb-8 transition-all duration-700 delay-100"
             :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight mb-5" style="font-family: 'Instrument Sans', sans-serif;">
                Alamin Ang <span class="gradient-text">Lihim</span> Kung Paano<br class="hidden sm:block">
                Dagdagan Ang Ani Mo ng <span class="gradient-text">30-50%</span>
            </h1>
            <p class="text-lg md:text-xl text-gray-300 max-w-2xl mx-auto leading-relaxed">
                Ang step-by-step na online course na gagabay sa iyo mula sa pagtatanim hanggang pag-aani.
                <span class="text-white font-medium">Puro Tagalog. Madaling sundin.</span>
            </p>
        </div>

        <!-- Video Section -->
        <div class="max-w-3xl mx-auto mb-10 transition-all duration-1000 delay-200"
             :class="shown ? 'opacity-100 scale-100' : 'opacity-0 scale-90'">
            <div class="relative rounded-2xl overflow-hidden video-glow">
                <!-- Video Thumbnail -->
                <div class="relative aspect-video bg-gradient-to-br from-gray-900 to-gray-800">
                    <img src="https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=1200&h=675&fit=crop"
                         alt="Course Preview"
                         class="absolute inset-0 w-full h-full object-cover opacity-60">

                    <!-- Play Button -->
                    <div class="absolute inset-0 flex items-center justify-center">
                        <button class="play-btn w-20 h-20 md:w-24 md:h-24 bg-brand-yellow rounded-full flex items-center justify-center transition-all duration-300 shadow-2xl">
                            <svg class="w-8 h-8 md:w-10 md:h-10 text-brand-dark ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        </button>
                    </div>

                    <!-- Duration Badge -->
                    <div class="absolute bottom-4 right-4 bg-black/70 text-white text-sm px-3 py-1 rounded-full">
                        3:42
                    </div>
                </div>

                <!-- Video Caption -->
                <div class="bg-white/5 border-t border-white/10 px-4 py-3 text-center">
                    <p class="text-gray-400 text-sm">
                        <svg class="w-4 h-4 inline-block mr-1 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Panoorin kung paano nagbago ang buhay ni Pedro dahil sa course na ito
                    </p>
                </div>
            </div>
        </div>

        <!-- Price & CTA -->
        <div class="text-center transition-all duration-700 delay-300"
             :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">

            <!-- Price Timer -->
            <div x-show="$store.priceTimer.showTimer" x-cloak class="inline-flex items-center gap-2 bg-red-500/20 border border-red-500/30 text-red-400 px-4 py-2 rounded-full text-sm mb-4">
                <svg class="w-4 h-4 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Babalik sa <span class="font-bold text-white">&#8369;8,000</span> sa loob ng <span class="font-bold text-white" x-text="$store.priceTimer.formatTime()"></span></span>
            </div>

            <!-- Price Display -->
            <div class="flex items-center justify-center gap-4 mb-6">
                <!-- Discounted Price (when timer active) -->
                <template x-if="$store.priceTimer.showTimer">
                    <div class="flex items-center gap-4">
                        <span class="text-gray-500 text-2xl price-slash relative">&#8369;8,000</span>
                        <div class="text-center">
                            <span class="text-5xl md:text-6xl font-bold text-white">&#8369;1,999</span>
                            <span class="block text-brand-green text-sm font-bold mt-1">SAVE &#8369;6,001</span>
                        </div>
                    </div>
                </template>
                <!-- Full Price (when timer expired) -->
                <template x-if="!$store.priceTimer.showTimer">
                    <div class="text-center">
                        <span class="text-5xl md:text-6xl font-bold text-white">&#8369;8,000</span>
                        <span class="block text-red-400 text-sm font-bold mt-1">Promo Ended</span>
                    </div>
                </template>
            </div>

            <!-- CTA Button -->
            <a href="{{ route('checkout') }}" class="pulse-glow inline-flex flex-col items-center gap-1 bg-brand-yellow text-brand-dark px-10 py-5 rounded-2xl font-bold text-xl hover:bg-brand-yellow-hover transition-all duration-300">
                <span class="flex items-center gap-3">
                    Simulan ang Iyong Journey
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </span>
                <span x-show="$store.priceTimer.showTimer" x-cloak class="text-xs font-medium text-brand-dark/70 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    &#8369;1,999 ends in <span x-text="$store.priceTimer.formatTime()"></span>
                </span>
            </a>

            <!-- Trust Indicators -->
            <div class="flex flex-wrap items-center justify-center gap-6 mt-8 text-gray-400 text-sm">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-green" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    30-Day Money Back
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-green" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    Lifetime na Knowledge
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-green" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    Puro Tagalog
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Problem Section -->
<section class="bg-gray-50 py-16 md:py-20" x-data="{ shown: false }" x-intersect:enter.once="shown = true">
    <div class="max-w-5xl mx-auto px-4">
        <div class="text-center mb-12 transition-all duration-700"
             :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-brand-dark mb-4" style="font-family: 'Instrument Sans', sans-serif;">
                Pamilyar Ba Sa Iyo Ang Mga Ito?
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Karamihan ng farmers ay nakakaranas ng mga problemang ito. Hindi ka nag-iisa.
            </p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
            @php
            $problems = [
                ['icon' => 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6', 'title' => 'Mababang Ani', 'desc' => 'Kahit anong gawin, hindi tumataas ang harvest'],
                ['icon' => 'M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z', 'title' => 'Lugi sa Tag-ulan', 'desc' => 'Nasasayang ang investment dahil sa panahon'],
                ['icon' => 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Walang Tamang Gabay', 'desc' => 'Hindi sigurado kung tama ang ginagawa'],
                ['icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Gastos > Kita', 'desc' => 'Mas malaki pa ang gastos kaysa kita'],
            ];
            @endphp

            @foreach($problems as $index => $problem)
            <div class="bg-white rounded-2xl p-6 border border-gray-100 card-hover transition-all duration-700"
                 :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                 style="transition-delay: {{ ($index + 1) * 100 }}ms">
                <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $problem['icon'] }}"/></svg>
                </div>
                <h3 class="font-bold text-brand-dark mb-2">{{ $problem['title'] }}</h3>
                <p class="text-gray-500 text-sm">{{ $problem['desc'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-12 transition-all duration-700 delay-500"
             :class="shown ? 'opacity-100' : 'opacity-0'">
            <div class="inline-flex items-center gap-3 bg-brand-green/10 text-brand-green px-6 py-3 rounded-full font-medium">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                May solusyon! At iyon ang course na ito.
            </div>
        </div>
    </div>
</section>

<!-- What You'll Learn Section -->
<section class="bg-white py-16 md:py-20" x-data="{ shown: false }" x-intersect:enter.once="shown = true">
    <div class="max-w-5xl mx-auto px-4">
        <div class="text-center mb-12 transition-all duration-700"
             :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <span class="inline-block bg-brand-green/10 text-brand-green px-4 py-1 rounded-full text-sm font-medium mb-4">Ang Matututunan Mo</span>
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-brand-dark mb-4" style="font-family: 'Instrument Sans', sans-serif;">
                Lahat Ng Kailangan Mo Para<br class="hidden sm:block"> Madagdagan Ang Iyong Ani
            </h2>
        </div>

        <div class="grid md:grid-cols-2 gap-5">
            @php
            $modules = [
                ['num' => '01', 'title' => 'Proven Techniques para sa 30-50% Yield Increase', 'desc' => 'Step-by-step methods na ginagamit ng mga top farmers sa Pilipinas.', 'color' => 'brand-green'],
                ['num' => '02', 'title' => 'Deep Understanding sa Fertilization', 'desc' => 'Alamin kung kailan, magkano, at paano mag-apply ng tamang fertilizer.', 'color' => 'brand-yellow'],
                ['num' => '03', 'title' => 'Soil Health at Preparation', 'desc' => 'Paano gawing mas productive ang iyong lupa season after season.', 'color' => 'brand-green'],
                ['num' => '04', 'title' => 'Protection sa Rainy Season', 'desc' => 'Mga strategy para hindi masayang ang iyong tanim kahit umuulan.', 'color' => 'brand-yellow'],
                ['num' => '05', 'title' => 'Water Management Mastery', 'desc' => 'Tamang timpla ng tubig para sa bawat stage ng crop growth.', 'color' => 'brand-green'],
                ['num' => '06', 'title' => 'Pest at Disease Prevention', 'desc' => 'Iwasan ang pagkalugi dahil sa mga peste at sakit ng halaman.', 'color' => 'brand-yellow'],
            ];
            @endphp

            @foreach($modules as $index => $module)
            <div class="flex gap-4 p-5 rounded-2xl border border-gray-100 hover:border-{{ $module['color'] }}/30 hover:bg-gray-50 transition-all duration-300"
                 x-data :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                 style="transition-delay: {{ ($index + 1) * 80 }}ms">
                <div class="flex-shrink-0 w-14 h-14 bg-{{ $module['color'] }}/10 rounded-xl flex items-center justify-center">
                    <span class="text-{{ $module['color'] }} font-bold text-lg">{{ $module['num'] }}</span>
                </div>
                <div>
                    <h3 class="font-bold text-brand-dark mb-1">{{ $module['title'] }}</h3>
                    <p class="text-gray-500 text-sm">{{ $module['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-8 text-gray-500 text-sm">
            + 14 pang modules na puro actionable techniques
        </div>
    </div>
</section>

<!-- Course Features -->
<section class="bg-brand-dark py-16 md:py-20 bg-pattern" x-data="{ shown: false }" x-intersect:enter.once="shown = true">
    <div class="max-w-5xl mx-auto px-4">
        <div class="text-center mb-12 transition-all duration-700"
             :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white mb-4" style="font-family: 'Instrument Sans', sans-serif;">
                Bakit Ito Ang Pinakamabuting<br class="hidden sm:block"> Investment Mo
            </h2>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
            $features = [
                ['icon' => 'M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129', 'title' => 'Puro Tagalog', 'desc' => 'Madaling maintindihan ng kahit sino'],
                ['icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Sariling Oras', 'desc' => 'Panoorin kahit kailan, kahit saan'],
                ['icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'title' => '1 Year Access', 'desc' => 'Buong taon mong mapapanood'],
                ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'title' => 'Money Back', 'desc' => '30-day full refund guarantee'],
            ];
            @endphp

            @foreach($features as $index => $feature)
            <div class="text-center p-6 rounded-2xl bg-white/5 border border-white/10 transition-all duration-700"
                 :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                 style="transition-delay: {{ ($index + 1) * 100 }}ms">
                <div class="w-14 h-14 bg-brand-yellow/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-brand-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $feature['icon'] }}"/></svg>
                </div>
                <h3 class="font-bold text-white mb-1">{{ $feature['title'] }}</h3>
                <p class="text-gray-400 text-sm">{{ $feature['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="bg-white py-16 md:py-20" x-data="{ shown: false }" x-intersect:enter.once="shown = true">
    <div class="max-w-5xl mx-auto px-4">
        <div class="text-center mb-12 transition-all duration-700"
             :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <span class="inline-block bg-brand-yellow/10 text-brand-yellow-hover px-4 py-1 rounded-full text-sm font-medium mb-4">Success Stories</span>
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-brand-dark" style="font-family: 'Instrument Sans', sans-serif;">
                Mga Farmer na Nagbago ang Buhay
            </h2>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @php
            $testimonials = [
                [
                    'name' => 'Pedro S.',
                    'location' => 'Nueva Ecija',
                    'quote' => 'Dati 80 cavans lang ang ani ko. Ngayon consistently 120 cavans na! Sobrang worth it ng investment.',
                    'increase' => '+50%'
                ],
                [
                    'name' => 'Maria D.',
                    'location' => 'Pangasinan',
                    'quote' => 'Nagdalawang isip ako kasi mahal ang ₱1,999. Pero sobrang sulit! Bumawi agad sa unang harvest.',
                    'increase' => '+35%'
                ],
                [
                    'name' => 'Juan R.',
                    'location' => 'Isabela',
                    'quote' => 'Simple lang ang explanation. Kahit matanda na ako, naintindihan ko lahat. Highly recommended!',
                    'increase' => '+40%'
                ],
            ];
            @endphp

            @foreach($testimonials as $index => $testimonial)
            <div class="bg-gray-50 rounded-2xl p-6 transition-all duration-700 card-hover"
                 :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                 style="transition-delay: {{ ($index + 1) * 150 }}ms">
                <!-- Rating -->
                <div class="flex items-center gap-1 mb-4">
                    @for($i = 0; $i < 5; $i++)
                    <svg class="w-5 h-5 text-brand-yellow" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>

                <!-- Quote -->
                <p class="text-gray-600 mb-6 leading-relaxed">"{{ $testimonial['quote'] }}"</p>

                <!-- Author -->
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-bold text-brand-dark">{{ $testimonial['name'] }}</p>
                        <p class="text-gray-500 text-sm">{{ $testimonial['location'] }}</p>
                    </div>
                    <div class="bg-brand-green/10 text-brand-green px-3 py-1 rounded-full text-sm font-bold">
                        {{ $testimonial['increase'] }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Ecosystem Section -->
<section class="bg-gradient-to-br from-brand-green to-brand-green-dark py-16 md:py-20 overflow-hidden" x-data="{ shown: false }" x-intersect:enter.once="shown = true">
    <div class="max-w-5xl mx-auto px-4">
        <div class="grid lg:grid-cols-2 gap-10 items-center">
            <div class="transition-all duration-700"
                 :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-8'">
                <span class="inline-block bg-white/20 text-white px-4 py-1 rounded-full text-sm font-medium mb-4">BONUS</span>
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white mb-6" style="font-family: 'Instrument Sans', sans-serif;">
                    Susi sa Buong AniSenso Ecosystem
                </h2>
                <p class="text-white/80 mb-8 leading-relaxed">
                    Kapag nag-enroll ka, hindi lang course ang makukuha mo. Ma-unlock mo rin ang access sa exclusive na AniSenso community at mga benefits:
                </p>

                <ul class="space-y-4">
                    @php
                    $benefits = [
                        'Access sa advanced courses (coming soon)',
                        'Exclusive discounts sa farming products',
                        'Private Facebook community ng farmers',
                        'Direct support mula sa mga experts',
                        'Certificate of Completion'
                    ];
                    @endphp
                    @foreach($benefits as $benefit)
                    <li class="flex items-center gap-3 text-white">
                        <div class="flex-shrink-0 w-6 h-6 bg-brand-yellow rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-brand-dark" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                        {{ $benefit }}
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="transition-all duration-700 delay-200"
                 :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-8'">
                <div class="relative">
                    <div class="absolute -inset-4 bg-brand-yellow/20 rounded-3xl blur-2xl"></div>
                    <img src="https://images.unsplash.com/photo-1593113630400-ea4288922497?w=600&h=450&fit=crop" alt="Farmer Community" class="relative rounded-2xl shadow-2xl w-full">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Value Proposition -->
<section class="bg-gray-50 py-16 md:py-20" x-data="{ shown: false }" x-intersect:enter.once="shown = true">
    <div class="max-w-4xl mx-auto px-4">
        <div class="text-center transition-all duration-700"
             :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-brand-dark mb-6" style="font-family: 'Instrument Sans', sans-serif;">
                Isipin Mo Ito...
            </h2>
            <p class="text-xl text-gray-600 mb-10 leading-relaxed max-w-2xl mx-auto">
                Ang <span class="font-bold text-brand-dark">₱1,999</span> ay isang beses lang mong babayaran.
                Pero ang knowledge na makukuha mo ay magagamit mo <span class="text-brand-green font-bold">habambuhay</span>
                para madagdagan ang ani mo <span class="text-brand-green font-bold">season after season</span>.
            </p>
        </div>

        <!-- Comparison Cards -->
        <div class="grid md:grid-cols-2 gap-6 transition-all duration-700 delay-200"
             :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <!-- Without -->
            <div class="bg-white rounded-2xl p-6 border-2 border-red-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </div>
                    <h3 class="font-bold text-brand-dark">Kung Hindi Ka Mag-Enroll</h3>
                </div>
                <ul class="space-y-3">
                    @php
                    $withoutItems = [
                        'Mananatiling mababa ang ani mo',
                        'Patuloy na malulugi sa tag-ulan',
                        'Trial and error pa rin sa fertilizer',
                        'Gastos na hindi bumabalik'
                    ];
                    @endphp
                    @foreach($withoutItems as $item)
                    <li class="flex items-start gap-3 text-gray-600">
                        <svg class="w-5 h-5 text-red-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                        {{ $item }}
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- With -->
            <div class="bg-white rounded-2xl p-6 border-2 border-brand-green/30 relative">
                <div class="absolute -top-3 right-4 bg-brand-green text-white text-xs font-bold px-3 py-1 rounded-full">
                    RECOMMENDED
                </div>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-brand-green/10 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <h3 class="font-bold text-brand-dark">Kung Mag-Enroll Ka</h3>
                </div>
                <ul class="space-y-3">
                    @php
                    $withItems = [
                        '30-50% increase sa ani',
                        'Protected ang crops sa kahit anong panahon',
                        'Confident ka na sa tamang methods',
                        'Sustainable na kita every season'
                    ];
                    @endphp
                    @foreach($withItems as $item)
                    <li class="flex items-start gap-3 text-gray-600">
                        <svg class="w-5 h-5 text-brand-green flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        {{ $item }}
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Refund Guarantee Section -->
<section class="bg-white py-16 md:py-20 overflow-hidden" x-data="{ shown: false }" x-intersect:enter.once="shown = true">
    <div class="max-w-4xl mx-auto px-4">
        <div class="relative bg-gradient-to-br from-brand-green/5 to-brand-yellow/5 rounded-3xl p-8 md:p-12 border-2 border-brand-green/20 transition-all duration-700"
             :class="shown ? 'opacity-100 scale-100' : 'opacity-0 scale-95'">

            <!-- Badge -->
            <div class="absolute -top-4 left-1/2 -translate-x-1/2">
                <span class="inline-flex items-center gap-2 bg-brand-green text-white px-5 py-2 rounded-full text-sm font-bold shadow-lg">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    ZERO RISK GUARANTEE
                </span>
            </div>

            <div class="text-center mt-4">
                <!-- Shield Icon -->
                <div class="w-20 h-20 bg-brand-green/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-brand-green" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                </div>

                <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-brand-dark mb-4" style="font-family: 'Instrument Sans', sans-serif;">
                    Hindi Tumaas Ang Ani Mo?<br class="hidden sm:block">
                    <span class="text-brand-green">Full Refund + Bonus Pa!</span>
                </h2>

                <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto leading-relaxed">
                    Ganito ka-confident kami sa course na ito: <span class="font-bold text-brand-dark">Kung na-apply mo ang lahat ng techniques sa course at hindi pa rin tumaas ang ani mo</span>, hindi lang namin ire-refund ang buong ₱1,999 mo...
                </p>

                <!-- Guarantee Details -->
                <div class="bg-white rounded-2xl p-6 md:p-8 shadow-lg max-w-xl mx-auto mb-8">
                    <p class="text-brand-dark font-bold text-lg mb-4">Ibibigay pa namin sa iyo:</p>
                    <div class="space-y-4">
                        <div class="flex items-center gap-4 text-left">
                            <div class="flex-shrink-0 w-12 h-12 bg-brand-yellow/20 rounded-full flex items-center justify-center">
                                <span class="text-2xl">💰</span>
                            </div>
                            <div>
                                <p class="font-bold text-brand-dark">100% Full Refund</p>
                                <p class="text-gray-500 text-sm">Buong ₱1,999 mo, ibabalik namin</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 text-left">
                            <div class="flex-shrink-0 w-12 h-12 bg-brand-green/20 rounded-full flex items-center justify-center">
                                <span class="text-2xl">🎁</span>
                            </div>
                            <div>
                                <p class="font-bold text-brand-dark">₱500 Bonus Gift</p>
                                <p class="text-gray-500 text-sm">Extra cash para sa susunod mong planting season</p>
                            </div>
                        </div>
                    </div>
                </div>

                <p class="text-gray-500 text-sm max-w-lg mx-auto">
                    Walang ibang course ang mag-o-offer nito. Bakit? Dahil alam namin na <span class="font-medium text-brand-dark">gumagana talaga ang mga techniques na ito</span> kapag sinunod ng tama.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Final CTA / Pricing Section -->
<section id="enroll" class="bg-brand-dark py-16 md:py-24 bg-pattern" x-data="{ shown: false }" x-intersect:enter.once="shown = true">
    <div class="max-w-3xl mx-auto px-4">
        <div class="text-center mb-10 transition-all duration-700"
             :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white mb-4" style="font-family: 'Instrument Sans', sans-serif;">
                Handa Ka Na Bang Magbago<br class="hidden sm:block"> Ang Iyong Farming Life?
            </h2>
            <p class="text-gray-400 max-w-xl mx-auto">
                Sumali na sa 10,000+ farmers na nagtransform ng kanilang farm gamit ang course na ito.
            </p>
        </div>

        <!-- Pricing Card -->
        <div class="bg-white rounded-3xl overflow-hidden shadow-2xl max-w-lg mx-auto transition-all duration-700 delay-200"
             :class="shown ? 'opacity-100 scale-100' : 'opacity-0 scale-95'">
            <!-- Header -->
            <div class="bg-gradient-to-r from-brand-green to-brand-green-dark p-6 text-center">
                <p class="text-white/80 text-sm mb-1">Complete Course Package</p>
                <!-- Discounted Price -->
                <template x-if="$store.priceTimer.showTimer">
                    <div>
                        <div class="flex items-center justify-center gap-3">
                            <span class="text-white/60 text-xl line-through">&#8369;8,000</span>
                            <span class="text-4xl md:text-5xl font-bold text-white">&#8369;1,999</span>
                        </div>
                        <p class="text-brand-yellow font-bold mt-2">75% OFF - Limited Time Only</p>
                        <div class="mt-3 inline-flex items-center gap-2 bg-white/20 text-white px-3 py-1.5 rounded-full text-sm">
                            <svg class="w-4 h-4 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Offer ends in <span class="font-bold" x-text="$store.priceTimer.formatTime()"></span></span>
                        </div>
                    </div>
                </template>
                <!-- Full Price -->
                <template x-if="!$store.priceTimer.showTimer">
                    <div>
                        <span class="text-4xl md:text-5xl font-bold text-white">&#8369;8,000</span>
                        <p class="text-white/70 font-medium mt-2">Regular Price</p>
                    </div>
                </template>
            </div>

            <!-- Content -->
            <div class="p-6 md:p-8">
                <p class="font-bold text-brand-dark mb-4">Kasama sa package:</p>
                <ul class="space-y-3 mb-8">
                    @php
                    $inclusions = [
                        '20+ Video Lessons',
                        'Downloadable Resources & Guides',
                        '1 Year Full Access',
                        'Certificate of Completion',
                        'AniSenso Community Access',
                        'Future Updates (FREE)'
                    ];
                    @endphp
                    @foreach($inclusions as $inclusion)
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-brand-green flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span class="text-gray-700">{{ $inclusion }}</span>
                    </li>
                    @endforeach
                </ul>

                <!-- CTA Button -->
                <a href="{{ route('checkout') }}" class="pulse-glow block w-full text-center bg-brand-yellow text-brand-dark py-4 rounded-xl font-bold text-lg hover:bg-brand-yellow-hover transition-all duration-300">
                    <span x-text="$store.priceTimer.showTimer ? 'Mag-Enroll Na - ₱1,999' : 'Mag-Enroll Na - ₱8,000'"></span>
                    <span x-show="$store.priceTimer.showTimer" x-cloak class="block text-xs font-medium text-brand-dark/70 mt-1">
                        <svg class="w-3 h-3 inline -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Offer ends in <span x-text="$store.priceTimer.formatTime()"></span>
                    </span>
                </a>

                <!-- Guarantee -->
                <div class="flex items-center justify-center gap-3 mt-6 pt-6 border-t border-gray-100">
                    <svg class="w-10 h-10 text-brand-green" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <div class="text-left">
                        <p class="font-bold text-brand-dark text-sm">30-Day Money Back Guarantee</p>
                        <p class="text-gray-500 text-xs">Hindi satisfied? Full refund, no questions asked.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="bg-white py-16 md:py-20" x-data="{ shown: false, openFaq: null }" x-intersect:enter.once="shown = true">
    <div class="max-w-3xl mx-auto px-4">
        <div class="text-center mb-12 transition-all duration-700"
             :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <h2 class="text-2xl md:text-3xl font-bold text-brand-dark" style="font-family: 'Instrument Sans', sans-serif;">
                Mga Frequently Asked Questions
            </h2>
        </div>

        @php
        $faqs = [
            ['q' => 'Paano ko ma-access ang course?', 'a' => 'Pagkatapos mag-enroll, makakareceive ka ng email na may login credentials. Pwede mong i-access ang course sa phone, tablet, o computer - kahit saan basta may internet.'],
            ['q' => 'Gaano katagal ko ma-access ang course?', 'a' => 'May 1 year full access ka sa lahat ng materials. Pwede mong panoorin at i-review ang lessons kahit ilang beses mo gusto within that period.'],
            ['q' => 'Pano kung hindi ko magustuhan ang course?', 'a' => 'May 30-day money back guarantee kami. Kung hindi ka satisfied sa kahit anong reason, ibabalik namin ang buong bayad mo. Walang tanong-tanong.'],
            ['q' => 'Kailangan ba ng special equipment?', 'a' => 'Hindi! Kailangan mo lang ng phone o computer na may internet connection para mapanood ang videos. Simple lang.'],
            ['q' => 'Tagalog ba talaga lahat ng lessons?', 'a' => 'Oo, 100%! Lahat ng lessons ay puro Tagalog para madaling maintindihan ng lahat ng Filipino farmers. Simple at practical ang explanations.'],
            ['q' => 'Effective ba talaga ito?', 'a' => 'Yes! Based sa feedback ng aming 10,000+ students, average na 45% ang increase sa yield nila. May mga nag-report pa ng hanggang 70% increase.'],
        ];
        @endphp

        <div class="space-y-3">
            @foreach($faqs as $index => $faq)
            <div class="border border-gray-200 rounded-xl overflow-hidden transition-all duration-500"
                 :class="[shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4', openFaq === {{ $index }} ? 'border-brand-green/30 bg-brand-green/5' : '']"
                 style="transition-delay: {{ ($index + 1) * 50 }}ms">
                <button @click="openFaq = openFaq === {{ $index }} ? null : {{ $index }}"
                        class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                    <span class="font-medium text-brand-dark pr-4">{{ $faq['q'] }}</span>
                    <svg class="w-5 h-5 text-gray-400 flex-shrink-0 transition-transform duration-300"
                         :class="openFaq === {{ $index }} ? 'rotate-180 text-brand-green' : ''"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="openFaq === {{ $index }}"
                     x-collapse
                     x-cloak>
                    <div class="px-6 pb-4">
                        <p class="text-gray-600 leading-relaxed">{{ $faq['a'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Final Banner -->
<section class="bg-brand-yellow py-8 md:py-10">
    <div class="max-w-5xl mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="text-center md:text-left">
                <h3 class="text-xl md:text-2xl font-bold text-brand-dark" style="font-family: 'Instrument Sans', sans-serif;">
                    Huwag Palampasin Ang Pagkakataong Ito
                </h3>
                <p class="text-brand-dark/70">Mag-enroll na at simulan ang journey mo sa mas mataas na ani!</p>
            </div>
            <a href="{{ route('checkout') }}" class="inline-flex flex-col items-center gap-1 bg-brand-dark text-white px-8 py-4 rounded-xl font-bold hover:bg-gray-800 transition-all duration-300 flex-shrink-0">
                <span class="flex items-center gap-2">
                    <span x-text="$store.priceTimer && $store.priceTimer.showTimer ? 'Enroll Now - ₱1,999' : 'Enroll Now - ₱8,000'"></span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </span>
                <span x-show="$store.priceTimer && $store.priceTimer.showTimer" x-cloak class="text-xs font-medium text-white/70 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Offer ends in <span x-text="$store.priceTimer.formatTime()"></span>
                </span>
            </a>
        </div>
    </div>
</section>

<!-- Minimal Footer -->
<footer class="bg-brand-dark py-8 border-t border-white/10">
    <div class="max-w-5xl mx-auto px-4 text-center">
        <img src="{{ asset('images/logo.png') }}" alt="AniSenso" class="h-8 w-auto mx-auto mb-4 opacity-60">
        <p class="text-gray-500 text-sm mb-2">&copy; {{ date('Y') }} AniSenso Academy. All rights reserved.</p>
        <div class="flex items-center justify-center gap-4 text-sm">
            <a href="{{ url('/') }}" class="text-gray-500 hover:text-white transition-colors">Home</a>
            <span class="text-gray-700">|</span>
            <a href="#" class="text-gray-500 hover:text-white transition-colors">Privacy Policy</a>
            <span class="text-gray-700">|</span>
            <a href="#" class="text-gray-500 hover:text-white transition-colors">Terms</a>
        </div>
    </div>
</footer>
@endsection

@push('scripts')
<script>
    // Cookie helper functions
    function setCookie(name, value, hours) {
        const date = new Date();
        date.setTime(date.getTime() + (hours * 60 * 60 * 1000));
        document.cookie = name + "=" + value + ";expires=" + date.toUTCString() + ";path=/";
    }

    function getCookie(name) {
        const nameEQ = name + "=";
        const ca = document.cookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i].trim();
            if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    // Exit Intent Modal Component
    function exitIntentModal() {
        const EXIT_COOKIE_NAME = 'anisenso_exit_intent_shown';
        const EXIT_COOKIE_HOURS = 8;

        return {
            showModal: false,
            originalPrice: 8000,
            exitPrice: 2499,
            checkoutUrl: '{{ route("checkout") }}',
            triggered: false,

            init() {
                // Check if already shown in the last 8 hours
                if (getCookie(EXIT_COOKIE_NAME)) {
                    return; // Don't show again
                }

                // Update prices based on promo timer status
                this.updatePrices();

                // Desktop: Mouse leave detection
                this.setupDesktopDetection();

                // Mobile: Back button and visibility change detection
                this.setupMobileDetection();
            },

            updatePrices() {
                // Check if promo is active
                const isPromoActive = Alpine.store('priceTimer') && Alpine.store('priceTimer').showTimer;

                if (isPromoActive) {
                    this.originalPrice = 1999;
                    this.exitPrice = 1500;
                } else {
                    this.originalPrice = 8000;
                    this.exitPrice = 2499;
                }

                // Update checkout URL with exit price
                this.checkoutUrl = '{{ route("checkout") }}?exit_price=' + this.exitPrice;
            },

            setupDesktopDetection() {
                // Only trigger when mouse leaves through the top of the viewport
                document.addEventListener('mouseleave', (e) => {
                    if (e.clientY <= 0 && !this.triggered) {
                        this.triggerModal();
                    }
                });
            },

            setupMobileDetection() {
                // Handle back button press (popstate)
                history.pushState(null, '', window.location.href);
                window.addEventListener('popstate', () => {
                    if (!this.triggered && !getCookie(EXIT_COOKIE_NAME)) {
                        history.pushState(null, '', window.location.href);
                        this.triggerModal();
                    }
                });

                // Handle page visibility change (tab switch, app switch)
                document.addEventListener('visibilitychange', () => {
                    if (document.visibilityState === 'hidden' && !this.triggered) {
                        // Don't show immediately, just track the intent
                    }
                });
            },

            handleMouseLeave(event) {
                // Additional check for mouse leaving viewport
                if (event.clientY <= 0 && !this.triggered && !getCookie(EXIT_COOKIE_NAME)) {
                    this.triggerModal();
                }
            },

            handleBeforeUnload() {
                // This is mainly for tracking, the modal can't be shown here
            },

            triggerModal() {
                if (this.triggered || getCookie(EXIT_COOKIE_NAME)) {
                    return;
                }

                // Update prices before showing
                this.updatePrices();

                this.triggered = true;
                this.showModal = true;
            },

            closeModal() {
                this.showModal = false;
                // Set cookie so it won't show again for 8 hours
                setCookie(EXIT_COOKIE_NAME, 'true', EXIT_COOKIE_HOURS);
            },

            acceptOffer() {
                // Set cookie so it won't show again
                setCookie(EXIT_COOKIE_NAME, 'accepted', EXIT_COOKIE_HOURS);
                // Redirect happens via the href
            }
        };
    }

    // Initialize Alpine store before Alpine starts
    document.addEventListener('alpine:init', () => {
        const COOKIE_NAME = 'anisenso_price_timer';
        const TIMER_DURATION = 13 * 60; // 13 minutes in seconds
        const COOKIE_EXPIRY_HOURS = 24;

        let initialTimeLeft = TIMER_DURATION;
        let showTimer = true;

        // Get existing timer or create new one
        const savedTimestamp = getCookie(COOKIE_NAME);

        if (savedTimestamp) {
            const startTime = parseInt(savedTimestamp);
            const now = Math.floor(Date.now() / 1000);
            const elapsed = now - startTime;
            initialTimeLeft = Math.max(0, TIMER_DURATION - elapsed);

            if (initialTimeLeft <= 0) {
                showTimer = false;
            }
        } else {
            const now = Math.floor(Date.now() / 1000);
            setCookie(COOKIE_NAME, now.toString(), COOKIE_EXPIRY_HOURS);
        }

        // Create reactive Alpine store
        Alpine.store('priceTimer', {
            timeLeft: initialTimeLeft,
            showTimer: showTimer,

            formatTime() {
                const mins = Math.floor(this.timeLeft / 60);
                const secs = this.timeLeft % 60;
                return `${mins}:${secs.toString().padStart(2, '0')}`;
            },

            startCountdown() {
                if (!this.showTimer) return;

                setInterval(() => {
                    if (this.timeLeft > 0) {
                        this.timeLeft--;
                    } else {
                        this.showTimer = false;
                    }
                }, 1000);
            }
        });

        // Start the countdown
        Alpine.store('priceTimer').startCountdown();
    });
</script>
@endpush
