@extends('layouts.app')

@section('title', 'Unladsaka Rhizocote - Micronutrient Fertilizer for High Yield Crops')

@push('styles')
<style>
    .gradient-text {
        background: linear-gradient(135deg, #f5c518 0%, #4a7c2a 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* ===== INTRO ANIMATIONS ===== */

    /* Base state for animated elements */
    [x-cloak-anim] {
        opacity: 0;
    }

    /* Fade In Up */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Fade In Down */
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Fade In Left */
    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-40px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Fade In Right */
    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(40px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Scale In */
    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Pop In (for badges) */
    @keyframes popIn {
        0% {
            opacity: 0;
            transform: scale(0.8);
        }
        70% {
            transform: scale(1.05);
        }
        100% {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Blur In */
    @keyframes blurIn {
        from {
            opacity: 0;
            filter: blur(10px);
        }
        to {
            opacity: 1;
            filter: blur(0);
        }
    }

    /* Animation Classes */
    .anim-fade-in-up {
        animation: fadeInUp 0.8s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }

    .anim-fade-in-down {
        animation: fadeInDown 0.8s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }

    .anim-fade-in-left {
        animation: fadeInLeft 0.8s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }

    .anim-fade-in-right {
        animation: fadeInRight 0.8s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }

    .anim-scale-in {
        animation: scaleIn 0.8s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }

    .anim-pop-in {
        animation: popIn 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }

    .anim-blur-in {
        animation: blurIn 1s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }

    /* Delay Classes */
    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }
    .delay-300 { animation-delay: 0.3s; }
    .delay-400 { animation-delay: 0.4s; }
    .delay-500 { animation-delay: 0.5s; }
    .delay-600 { animation-delay: 0.6s; }
    .delay-700 { animation-delay: 0.7s; }
    .delay-800 { animation-delay: 0.8s; }
    .delay-900 { animation-delay: 0.9s; }
    .delay-1000 { animation-delay: 1s; }

    /* Scroll-triggered animation base */
    .scroll-animate {
        opacity: 0;
    }

    .scroll-animate.animated {
        opacity: 1;
    }

    /* Logo Slider Animation */
    @keyframes scroll {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(-50%);
        }
    }

    .logo-slider {
        overflow: hidden;
        position: relative;
    }

    .logo-slider::before,
    .logo-slider::after {
        content: '';
        position: absolute;
        top: 0;
        width: 100px;
        height: 100%;
        z-index: 2;
    }

    .logo-slider::before {
        left: 0;
        background: linear-gradient(to right, #1a1a1a, transparent);
    }

    .logo-slider::after {
        right: 0;
        background: linear-gradient(to left, #1a1a1a, transparent);
    }

    .logo-track {
        display: flex;
        animation: scroll 20s linear infinite;
        width: fit-content;
    }

    .logo-track:hover {
        animation-play-state: paused;
    }

    /* Organizations Logo Slider */
    .logo-slider-orgs {
        overflow: hidden;
        position: relative;
    }

    .logo-slider-orgs::before,
    .logo-slider-orgs::after {
        content: '';
        position: absolute;
        top: 0;
        width: 150px;
        height: 100%;
        z-index: 2;
    }

    .logo-slider-orgs::before {
        left: 0;
        background: linear-gradient(to right, #f3f4f6, transparent);
    }

    .logo-slider-orgs::after {
        right: 0;
        background: linear-gradient(to left, #f3f4f6, transparent);
    }

    .logo-track-orgs {
        display: flex;
        animation: scrollOrgs 25s linear infinite;
        width: fit-content;
    }

    .logo-track-orgs:hover {
        animation-play-state: paused;
    }

    @keyframes scrollOrgs {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(-50%);
        }
    }

    /* Masked Image Effect */
    .masked-image {
        -webkit-mask-image: url('{{ asset('images/mask.png') }}');
        mask-image: url('{{ asset('images/mask.png') }}');
        -webkit-mask-size: cover;
        mask-size: cover;
        -webkit-mask-position-x: 29%;
        mask-position-x: 29%;
        -webkit-mask-position-y: 0%;
        mask-position-y: 0%;
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="relative min-h-[85vh] flex items-center overflow-hidden">
    <!-- Background Image -->
    <div class="absolute inset-0">
        <img src="{{ asset('images/rhizo-hero-bg.jpg') }}" alt="" class="w-full h-full object-cover scale-105">
        <!-- Gradient overlays -->
        <div class="absolute inset-0 bg-gradient-to-r from-brand-dark via-brand-dark/90 to-brand-dark/60"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-brand-dark via-transparent to-transparent"></div>
    </div>

    <!-- Decorative Elements -->
    <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-brand-yellow/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-1/4 left-1/4 w-64 h-64 bg-brand-green/10 rounded-full blur-3xl"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-20 w-full">
        <!-- Breadcrumb -->
        <nav class="flex justify-end mb-8 opacity-0 anim-fade-in-right delay-100" style="animation-fill-mode: forwards;">
            <ol class="flex items-center gap-2 text-sm bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full">
                <li>
                    <a href="{{ url('/') }}" class="text-white/70 hover:text-white transition-colors">Home</a>
                </li>
                <li class="text-white/30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </li>
                <li>
                    <span class="text-white/70">Ecosystem</span>
                </li>
                <li class="text-white/30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </li>
                <li>
                    <span class="text-brand-yellow font-medium">Rhizocote</span>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <!-- Left Content -->
            <div>
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 bg-brand-yellow/20 backdrop-blur-sm text-brand-yellow px-5 py-2.5 rounded-full mb-8 border border-brand-yellow/30 opacity-0 anim-fade-in-left delay-200" style="animation-fill-mode: forwards;">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L9.19 8.63 2 9.24l5.46 4.73L5.82 21 12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2z"/></svg>
                    <span class="text-sm font-semibold uppercase tracking-wide">Award-Winning Technology</span>
                </div>

                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-white mb-8 leading-tight opacity-0 anim-fade-in-up delay-300" style="font-family: 'Instrument Sans', sans-serif; animation-fill-mode: forwards;">
                    Unladsaka <br><span class="text-brand-yellow">Rhizocote</span>
                </h1>

                <p class="text-xl md:text-2xl text-white/80 mb-10 leading-relaxed max-w-xl opacity-0 anim-fade-in-up delay-400" style="animation-fill-mode: forwards;">
                    Revolutionary micronutrient fertilizer technology designed to <strong class="text-white">maximize crop yields</strong> for Filipino farmers.
                </p>

                <!-- CTA Button -->
                <div class="mb-12 opacity-0 anim-fade-in-up delay-500" style="animation-fill-mode: forwards;">
                    <a href="{{ route('community.join') }}" class="group inline-flex items-center gap-2 bg-brand-yellow text-brand-dark px-8 py-4 rounded-full font-bold text-lg hover:bg-brand-yellow-hover transition-all shadow-lg shadow-brand-yellow/30">
                        Join the Community
                        <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>

                <!-- Stats -->
                <div class="flex flex-wrap gap-8">
                    <div class="text-center opacity-0 anim-fade-in-up delay-600" style="animation-fill-mode: forwards;">
                        <p class="text-4xl font-bold text-brand-yellow">30-50%</p>
                        <p class="text-white/60 text-sm mt-1">Yield Increase</p>
                    </div>
                    <div class="w-px bg-white/20 hidden sm:block opacity-0 anim-fade-in-up delay-600" style="animation-fill-mode: forwards;"></div>
                    <div class="text-center opacity-0 anim-fade-in-up delay-700" style="animation-fill-mode: forwards;">
                        <p class="text-4xl font-bold text-brand-yellow">1997</p>
                        <p class="text-white/60 text-sm mt-1">WIPO Gold Medal</p>
                    </div>
                    <div class="w-px bg-white/20 hidden sm:block opacity-0 anim-fade-in-up delay-700" style="animation-fill-mode: forwards;"></div>
                    <div class="text-center opacity-0 anim-fade-in-up delay-800" style="animation-fill-mode: forwards;">
                        <p class="text-4xl font-bold text-brand-yellow">25+</p>
                        <p class="text-white/60 text-sm mt-1">Years Trusted</p>
                    </div>
                </div>
            </div>

            <!-- Right - Product Video -->
            <div class="relative opacity-0 anim-scale-in delay-400" style="animation-fill-mode: forwards;">
                <!-- Decorative frame -->
                <div class="absolute -top-4 -right-4 w-full h-full border-2 border-brand-yellow/30 rounded-3xl opacity-0 anim-fade-in-right delay-600" style="animation-fill-mode: forwards;"></div>
                <div class="absolute -bottom-4 -left-4 w-full h-full border-2 border-white/10 rounded-3xl opacity-0 anim-fade-in-left delay-700" style="animation-fill-mode: forwards;"></div>

                <div class="relative bg-gradient-to-br from-brand-green/20 to-brand-dark/50 p-2 rounded-3xl backdrop-blur-sm">
                    <video class="w-full rounded-2xl shadow-2xl" autoplay muted loop playsinline>
                        <source src="{{ asset('images/rhizo-video.mp4') }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>

                <!-- Floating Badge -->
                <div class="absolute -bottom-6 -left-6 bg-white px-6 py-4 rounded-2xl shadow-xl opacity-0 anim-pop-in delay-800" style="animation-fill-mode: forwards;">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-brand-green/20 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs">Certified by</p>
                            <p class="text-gray-900 font-bold">DOST & WIPO</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 animate-bounce">
        <span class="text-white/50 text-xs uppercase tracking-widest">Scroll</span>
        <svg class="w-6 h-6 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
    </div>
</section>

<!-- Trusted Companies Logo Slider -->
<section class="py-12 bg-brand-dark border-t border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-center text-white/60 text-sm uppercase tracking-widest mb-8">
            Tested By The Largest Philippine Agricultural Export Companies
        </p>

        <div class="logo-slider">
            <div class="logo-track">
                <!-- First set of logos -->
                <div class="flex items-center gap-16 px-8">
                    <div class="flex-shrink-0">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/43/Dole_Logo.svg/200px-Dole_Logo.svg.png" alt="Dole" class="h-12 w-auto brightness-0 invert opacity-70 hover:opacity-100 transition-opacity">
                    </div>
                    <div class="flex-shrink-0">
                        <span class="text-white/70 hover:text-white font-bold text-2xl tracking-tight transition-colors">STANFILCO</span>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="text-white/70 hover:text-white font-bold text-2xl tracking-tight transition-colors">TADECO</span>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="text-white/70 hover:text-white font-bold text-2xl tracking-tight transition-colors">SUMIFRU</span>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="text-white/70 hover:text-white font-bold text-2xl tracking-tight transition-colors">LAPANDAY</span>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="text-white/70 hover:text-white font-bold text-2xl tracking-tight transition-colors">UNIFRUTTI</span>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="text-white/70 hover:text-white font-bold text-2xl tracking-tight transition-colors">DEL MONTE</span>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="text-white/70 hover:text-white font-bold text-2xl tracking-tight transition-colors">MARSMAN</span>
                    </div>
                </div>
                <!-- Duplicate set for seamless loop -->
                <div class="flex items-center gap-16 px-8">
                    <div class="flex-shrink-0">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/43/Dole_Logo.svg/200px-Dole_Logo.svg.png" alt="Dole" class="h-12 w-auto brightness-0 invert opacity-70 hover:opacity-100 transition-opacity">
                    </div>
                    <div class="flex-shrink-0">
                        <span class="text-white/70 hover:text-white font-bold text-2xl tracking-tight transition-colors">STANFILCO</span>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="text-white/70 hover:text-white font-bold text-2xl tracking-tight transition-colors">TADECO</span>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="text-white/70 hover:text-white font-bold text-2xl tracking-tight transition-colors">SUMIFRU</span>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="text-white/70 hover:text-white font-bold text-2xl tracking-tight transition-colors">LAPANDAY</span>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="text-white/70 hover:text-white font-bold text-2xl tracking-tight transition-colors">UNIFRUTTI</span>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="text-white/70 hover:text-white font-bold text-2xl tracking-tight transition-colors">DEL MONTE</span>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="text-white/70 hover:text-white font-bold text-2xl tracking-tight transition-colors">MARSMAN</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Key Benefits Section -->
<section id="learn-more" class="py-24 bg-gradient-to-b from-gray-50 to-white relative overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute top-0 left-0 w-96 h-96 bg-brand-green/5 rounded-full -translate-x-1/2 -translate-y-1/2 blur-3xl"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-brand-yellow/5 rounded-full translate-x-1/2 translate-y-1/2 blur-3xl"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-20"
             x-data="{ shown: false }"
             x-intersect:enter.threshold.25="shown = true">
            <div class="inline-flex items-center gap-2 bg-brand-green/10 text-brand-green px-5 py-2.5 rounded-full mb-6 transition-all duration-700"
                 :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                <span class="text-sm font-semibold uppercase tracking-wide">Why Choose Rhizocote</span>
            </div>
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-6 transition-all duration-700 delay-100"
                :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                style="font-family: 'Instrument Sans', sans-serif;">
                Maximize Your <span class="text-brand-green">Crop Yields</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed transition-all duration-700 delay-200"
               :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                Rhizocote delivers essential micronutrients directly to your crops' root systems, ensuring optimal absorption and maximum growth potential.
            </p>
        </div>

        <!-- Row 1: Image Left, Content Right -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center mb-24"
             x-data="{ shown: false }"
             x-intersect:enter.threshold.15="shown = true">
            <div class="relative transition-all duration-1000"
                 :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-12'">
                <div class="absolute -top-6 -left-6 w-32 h-32 bg-brand-green/10 rounded-3xl -z-10"></div>
                <img src="{{ asset('images/grains-min.webp') }}" alt="Increased Yield" class="w-full h-[450px] object-cover rounded-3xl shadow-2xl masked-image">
                <!-- Stats Badge -->
                <div class="absolute -bottom-6 -right-6 bg-white px-6 py-4 rounded-2xl shadow-xl border border-gray-100 transition-all duration-700 delay-500"
                     :class="shown ? 'opacity-100 scale-100' : 'opacity-0 scale-90'">
                    <p class="text-brand-green font-bold text-3xl">30-50%</p>
                    <p class="text-gray-500 text-sm">Yield Increase</p>
                </div>
            </div>
            <div class="lg:pl-8 transition-all duration-1000 delay-200"
                 :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-12'">
                <div class="inline-flex items-center gap-2 bg-brand-green/10 text-brand-green px-4 py-2 rounded-full mb-6">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    <span class="text-sm font-semibold">Benefit #1</span>
                </div>
                <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Increased Yield</h3>
                <p class="text-gray-600 leading-relaxed text-lg mb-4">
                    Farmers report up to <strong class="text-brand-green">30-50% increase</strong> in crop yields when using Rhizocote compared to traditional fertilizers.
                </p>
                <p class="text-gray-600 leading-relaxed mb-8">
                    Our proprietary micronutrient blend ensures your crops receive exactly what they need at every growth stage, resulting in healthier plants and more abundant harvests.
                </p>
                <a href="#" class="group inline-flex items-center gap-2 bg-brand-green text-white px-7 py-3.5 rounded-full font-semibold hover:bg-brand-green-dark transition-all shadow-lg shadow-brand-green/25">
                    Learn More
                    <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>

        <!-- Row 2: Content Left, Image Right -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center mb-24"
             x-data="{ shown: false }"
             x-intersect:enter.threshold.15="shown = true">
            <div class="lg:pr-8 lg:text-right order-2 lg:order-1 transition-all duration-1000 delay-200"
                 :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-12'">
                <div class="inline-flex items-center gap-2 bg-brand-yellow/10 text-brand-yellow-hover px-4 py-2 rounded-full mb-6 lg:ml-auto">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <span class="text-sm font-semibold">Benefit #2</span>
                </div>
                <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Disease Resistance</h3>
                <p class="text-gray-600 leading-relaxed text-lg mb-4">
                    Enhanced micronutrient absorption <strong class="text-gray-900">strengthens plant immunity</strong>, reducing susceptibility to common crop diseases.
                </p>
                <p class="text-gray-600 leading-relaxed mb-8">
                    Plants treated with Rhizocote develop stronger cell walls and more robust defense mechanisms, naturally protecting against fungal, bacterial, and viral infections.
                </p>
                <a href="#" class="group inline-flex items-center gap-2 bg-brand-yellow text-brand-dark px-7 py-3.5 rounded-full font-semibold hover:bg-brand-yellow-hover transition-all shadow-lg shadow-brand-yellow/25">
                    Learn More
                    <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
            <div class="relative order-1 lg:order-2 transition-all duration-1000"
                 :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-12'">
                <div class="absolute -top-6 -right-6 w-32 h-32 bg-brand-yellow/10 rounded-3xl -z-10"></div>
                <img src="{{ asset('images/rhizo-hero-bg.jpg') }}" alt="Disease Resistance" class="w-full h-[450px] object-cover rounded-3xl shadow-2xl masked-image">
            </div>
        </div>

        <!-- Row 3: Image Left, Content Right -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center mb-24"
             x-data="{ shown: false }"
             x-intersect:enter.threshold.15="shown = true">
            <div class="relative transition-all duration-1000"
                 :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-12'">
                <div class="absolute -top-6 -left-6 w-32 h-32 bg-brand-green/10 rounded-3xl -z-10"></div>
                <img src="{{ asset('images/rhizo-hero-bg.jpg') }}" alt="Cost Effective" class="w-full h-[450px] object-cover rounded-3xl shadow-2xl masked-image">
                <!-- Stats Badge -->
                <div class="absolute -bottom-6 -right-6 bg-white px-6 py-4 rounded-2xl shadow-xl border border-gray-100 transition-all duration-700 delay-500"
                     :class="shown ? 'opacity-100 scale-100' : 'opacity-0 scale-90'">
                    <p class="text-brand-green font-bold text-3xl">1st</p>
                    <p class="text-gray-500 text-sm">Season ROI</p>
                </div>
            </div>
            <div class="lg:pl-8 transition-all duration-1000 delay-200"
                 :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-12'">
                <div class="inline-flex items-center gap-2 bg-brand-green/10 text-brand-green px-4 py-2 rounded-full mb-6">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-semibold">Benefit #3</span>
                </div>
                <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Cost Effective</h3>
                <p class="text-gray-600 leading-relaxed text-lg mb-4">
                    Lower application rates and higher efficiency mean <strong class="text-brand-green">better returns</strong> on your investment per hectare.
                </p>
                <p class="text-gray-600 leading-relaxed mb-8">
                    With Rhizocote's concentrated formula, you use less product while achieving superior results. Many farmers see their investment pay off within the first harvest season.
                </p>
                <a href="#" class="group inline-flex items-center gap-2 bg-brand-green text-white px-7 py-3.5 rounded-full font-semibold hover:bg-brand-green-dark transition-all shadow-lg shadow-brand-green/25">
                    Learn More
                    <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>

        <!-- Row 4: Content Left, Image Right -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center"
             x-data="{ shown: false }"
             x-intersect:enter.threshold.15="shown = true">
            <div class="lg:pr-8 lg:text-right order-2 lg:order-1 transition-all duration-1000 delay-200"
                 :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-12'">
                <div class="inline-flex items-center gap-2 bg-brand-yellow/10 text-brand-yellow-hover px-4 py-2 rounded-full mb-6 lg:ml-auto">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                    <span class="text-sm font-semibold">Benefit #4</span>
                </div>
                <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Science-Backed Formula</h3>
                <p class="text-gray-600 leading-relaxed text-lg mb-4">
                    Developed through <strong class="text-gray-900">years of agricultural research</strong> and field testing with Filipino farmers and crops.
                </p>
                <p class="text-gray-600 leading-relaxed mb-8">
                    Our team of agricultural scientists has perfected the Rhizocote formula specifically for Philippine soil conditions and crop varieties, ensuring optimal performance in local farming environments.
                </p>
                <a href="#" class="group inline-flex items-center gap-2 bg-brand-yellow text-brand-dark px-7 py-3.5 rounded-full font-semibold hover:bg-brand-yellow-hover transition-all shadow-lg shadow-brand-yellow/25">
                    Learn More
                    <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
            <div class="relative order-1 lg:order-2 transition-all duration-1000"
                 :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-12'">
                <div class="absolute -top-6 -right-6 w-32 h-32 bg-brand-yellow/10 rounded-3xl -z-10"></div>
                <img src="{{ asset('images/rhizo-hero-bg.jpg') }}" alt="Science-Backed" class="w-full h-[450px] object-cover rounded-3xl shadow-2xl masked-image">
            </div>
        </div>
    </div>
</section>

<!-- Trusted Organizations Logo Slider -->
<section class="py-16 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10"
             x-data="{ shown: false }"
             x-intersect:enter.threshold.25="shown = true">
            <div class="inline-flex items-center gap-2 bg-brand-green/10 text-brand-green px-4 py-2 rounded-full mb-4 transition-all duration-700"
                 :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                <span class="text-sm font-semibold uppercase tracking-wide">Certified Excellence</span>
            </div>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 transition-all duration-700 delay-150"
                :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
                style="font-family: 'Instrument Sans', sans-serif;">
                Rhizocote Is Trusted and Recognized by <span class="text-brand-green">These Organizations</span>
            </h2>
        </div>

        <div class="logo-slider-orgs relative">
            <div class="logo-track-orgs flex items-center">
                <!-- First set of organization logos -->
                <div class="flex items-center gap-16 px-8">
                    <div class="flex-shrink-0 bg-white px-8 py-4 rounded-xl shadow-sm">
                        <span class="text-gray-700 font-bold text-xl tracking-tight">DOST</span>
                    </div>
                    <div class="flex-shrink-0 bg-white px-8 py-4 rounded-xl shadow-sm">
                        <span class="text-gray-700 font-bold text-xl tracking-tight">WIPO</span>
                    </div>
                    <div class="flex-shrink-0 bg-white px-8 py-4 rounded-xl shadow-sm">
                        <span class="text-gray-700 font-bold text-xl tracking-tight">NEDA</span>
                    </div>
                    <div class="flex-shrink-0 bg-white px-8 py-4 rounded-xl shadow-sm">
                        <span class="text-gray-700 font-bold text-xl tracking-tight">FIS</span>
                    </div>
                    <div class="flex-shrink-0 bg-white px-8 py-4 rounded-xl shadow-sm">
                        <span class="text-gray-700 font-bold text-xl tracking-tight">DA</span>
                    </div>
                    <div class="flex-shrink-0 bg-white px-8 py-4 rounded-xl shadow-sm">
                        <span class="text-gray-700 font-bold text-xl tracking-tight">PNVSCA</span>
                    </div>
                    <div class="flex-shrink-0 bg-white px-8 py-4 rounded-xl shadow-sm">
                        <span class="text-gray-700 font-bold text-xl tracking-tight">UPLB</span>
                    </div>
                    <div class="flex-shrink-0 bg-white px-8 py-4 rounded-xl shadow-sm">
                        <span class="text-gray-700 font-bold text-xl tracking-tight">PhilRice</span>
                    </div>
                </div>
                <!-- Duplicate set for seamless loop -->
                <div class="flex items-center gap-16 px-8">
                    <div class="flex-shrink-0 bg-white px-8 py-4 rounded-xl shadow-sm">
                        <span class="text-gray-700 font-bold text-xl tracking-tight">DOST</span>
                    </div>
                    <div class="flex-shrink-0 bg-white px-8 py-4 rounded-xl shadow-sm">
                        <span class="text-gray-700 font-bold text-xl tracking-tight">WIPO</span>
                    </div>
                    <div class="flex-shrink-0 bg-white px-8 py-4 rounded-xl shadow-sm">
                        <span class="text-gray-700 font-bold text-xl tracking-tight">NEDA</span>
                    </div>
                    <div class="flex-shrink-0 bg-white px-8 py-4 rounded-xl shadow-sm">
                        <span class="text-gray-700 font-bold text-xl tracking-tight">FIS</span>
                    </div>
                    <div class="flex-shrink-0 bg-white px-8 py-4 rounded-xl shadow-sm">
                        <span class="text-gray-700 font-bold text-xl tracking-tight">DA</span>
                    </div>
                    <div class="flex-shrink-0 bg-white px-8 py-4 rounded-xl shadow-sm">
                        <span class="text-gray-700 font-bold text-xl tracking-tight">PNVSCA</span>
                    </div>
                    <div class="flex-shrink-0 bg-white px-8 py-4 rounded-xl shadow-sm">
                        <span class="text-gray-700 font-bold text-xl tracking-tight">UPLB</span>
                    </div>
                    <div class="flex-shrink-0 bg-white px-8 py-4 rounded-xl shadow-sm">
                        <span class="text-gray-700 font-bold text-xl tracking-tight">PhilRice</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Award Winning Technology Section -->
<section class="py-24 bg-brand-green-dark relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.4\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Row 1: Image Left, Content Right -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center mb-24"
             x-data="{ shown: false }"
             x-intersect:enter.threshold.15="shown = true">
            <!-- Left Image -->
            <div class="relative transition-all duration-1000"
                 :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-12'">
                <div class="absolute -top-4 -left-4 w-24 h-24 bg-brand-yellow/20 rounded-full blur-2xl"></div>
                <img src="{{ asset('images/rhizo-hero-bg.jpg') }}" alt="WIPO Gold Medal Award" class="w-full h-[450px] object-cover rounded-3xl shadow-2xl border border-white/10">
                <!-- Award Badge -->
                <div class="absolute -bottom-6 -right-6 bg-brand-yellow text-brand-dark px-6 py-3 rounded-2xl shadow-xl transition-all duration-700 delay-500"
                     :class="shown ? 'opacity-100 scale-100' : 'opacity-0 scale-90'">
                    <div class="flex items-center gap-3">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L9.19 8.63 2 9.24l5.46 4.73L5.82 21 12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2z"/></svg>
                        <div>
                            <p class="text-xs font-semibold uppercase">WIPO</p>
                            <p class="text-lg font-bold">Gold Medal</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Right Content -->
            <div class="lg:pl-8 transition-all duration-1000 delay-200"
                 :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-12'">
                <div class="inline-flex items-center gap-2 bg-brand-yellow/20 text-brand-yellow px-4 py-2 rounded-full mb-6">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L9.19 8.63 2 9.24l5.46 4.73L5.82 21 12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2z"/></svg>
                    <span class="text-sm font-semibold uppercase tracking-wide">Award Winning Technology</span>
                </div>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-8" style="font-family: 'Instrument Sans', sans-serif;">
                    Gold Medal Invention, <br><span class="text-brand-yellow">Local & International</span>
                </h2>
                <p class="text-lg text-white/80 leading-relaxed mb-6">
                    Rhizocote earned recognition as <strong class="text-white">Most Outstanding Invention</strong> from the Department of Science and Technology and Filipino Inventors Society.
                </p>
                <p class="text-lg text-white/80 leading-relaxed mb-8">
                    The World Intellectual Property Organization awarded this Filipino innovation the prestigious <strong class="text-brand-yellow">WIPO Gold Medal in 1997</strong>.
                </p>
                <div class="flex flex-wrap gap-4">
                    <div class="bg-white/10 backdrop-blur-sm px-5 py-3 rounded-xl border border-white/20">
                        <p class="text-brand-yellow font-bold text-lg">DOST</p>
                        <p class="text-white/60 text-sm">Most Outstanding</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm px-5 py-3 rounded-xl border border-white/20">
                        <p class="text-brand-yellow font-bold text-lg">WIPO</p>
                        <p class="text-white/60 text-sm">Gold Medal 1997</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm px-5 py-3 rounded-xl border border-white/20">
                        <p class="text-brand-yellow font-bold text-lg">NEDA</p>
                        <p class="text-white/60 text-sm">Outstanding Worker</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <div class="flex justify-center mb-24">
            <div class="w-[300px] h-[2px] bg-white/20"></div>
        </div>

        <!-- Row 2: Content Left, Image Right -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center"
             x-data="{ shown: false }"
             x-intersect:enter.threshold.15="shown = true">
            <!-- Left Content -->
            <div class="lg:pr-8 lg:text-right order-2 lg:order-1 transition-all duration-1000 delay-200"
                 :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-12'">
                <div class="inline-flex items-center gap-2 bg-brand-yellow/20 text-brand-yellow px-4 py-2 rounded-full mb-6 lg:ml-auto">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    <span class="text-sm font-semibold uppercase tracking-wide">Proven Excellence</span>
                </div>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-8" style="font-family: 'Instrument Sans', sans-serif;">
                    Transforming Philippine <br><span class="text-brand-yellow">Agriculture</span>
                </h2>
                <p class="text-lg text-white/80 leading-relaxed mb-6">
                    These local and international honors validate Rhizocote's proven effectiveness in transforming Philippine agriculture through scientific innovation.
                </p>
                <p class="text-lg text-white/80 leading-relaxed mb-8">
                    For decades, Filipino farmers have trusted Rhizocote to deliver exceptional results and higher yields across various crops nationwide.
                </p>
                <a href="#" class="group inline-flex items-center gap-2 bg-brand-yellow text-brand-dark px-8 py-4 rounded-full font-semibold text-lg hover:bg-brand-yellow-hover transition-all lg:ml-auto">
                    Learn Our Story
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
            <!-- Right Image -->
            <div class="relative order-1 lg:order-2 transition-all duration-1000"
                 :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-12'">
                <div class="absolute -top-4 -right-4 w-24 h-24 bg-brand-yellow/20 rounded-full blur-2xl"></div>
                <img src="{{ asset('images/rhizo-hero-bg.jpg') }}" alt="Philippine Agriculture" class="w-full h-[450px] object-cover rounded-3xl shadow-2xl border border-white/10">
            </div>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section class="py-24 bg-white" x-data="{
    lightboxOpen: false,
    currentImage: '',
    currentCaption: '',
    openLightbox(image, caption) {
        this.currentImage = image;
        this.currentCaption = caption;
        this.lightboxOpen = true;
        document.body.style.overflow = 'hidden';
    },
    closeLightbox() {
        this.lightboxOpen = false;
        document.body.style.overflow = 'auto';
    }
}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-16"
             x-data="{ shown: false }"
             x-intersect:enter.threshold.25="shown = true">
            <div class="inline-flex items-center gap-2 bg-brand-green/10 text-brand-green px-5 py-2.5 rounded-full mb-6 transition-all duration-700"
                 :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span class="text-sm font-semibold uppercase tracking-wide">Success Stories</span>
            </div>
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-6 transition-all duration-700 delay-100"
                :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                style="font-family: 'Instrument Sans', sans-serif;">
                See Rhizocote <span class="text-brand-green">In Action</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed transition-all duration-700 delay-200"
               :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                Browse through our gallery of successful harvests and satisfied farmers using Rhizocote technology across the Philippines.
            </p>
        </div>

        <!-- Square Grid Gallery -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"
             x-data="{ shown: false }"
             x-intersect:enter.threshold.10="shown = true">
            <!-- Gallery Item 1 -->
            <div class="group cursor-pointer transition-all duration-700"
                 :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                 style="transition-delay: 0ms;"
                 @click="openLightbox('{{ asset('images/rhizo-hero-bg.jpg') }}', 'Rice field in Camarines Sur showing 40% yield increase after Rhizocote application')">
                <div class="relative overflow-hidden rounded-2xl bg-gray-100 aspect-square">
                    <img src="{{ asset('images/rhizo-hero-bg.jpg') }}" alt="Rice Harvest" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                        <p class="text-white font-semibold text-sm">Rice Harvest - Camarines Sur</p>
                        <p class="text-white/70 text-xs">40% Yield Increase</p>
                    </div>
                    <div class="absolute top-3 right-3 w-9 h-9 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                    </div>
                </div>
            </div>

            <!-- Gallery Item 2 -->
            <div class="group cursor-pointer transition-all duration-700"
                 :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                 style="transition-delay: 75ms;"
                 @click="openLightbox('{{ asset('images/grains-min.webp') }}', 'Golden grains ready for harvest - Result of proper Rhizocote application')">
                <div class="relative overflow-hidden rounded-2xl bg-gray-100 aspect-square">
                    <img src="{{ asset('images/grains-min.webp') }}" alt="Golden Grains" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                        <p class="text-white font-semibold text-sm">Golden Harvest</p>
                        <p class="text-white/70 text-xs">Premium Quality Grains</p>
                    </div>
                    <div class="absolute top-3 right-3 w-9 h-9 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                    </div>
                </div>
            </div>

            <!-- Gallery Item 3 -->
            <div class="group cursor-pointer transition-all duration-700"
                 :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                 style="transition-delay: 150ms;"
                 @click="openLightbox('{{ asset('images/rhizo-hero-bg.jpg') }}', 'Corn plantation in Mindanao with exceptional growth using Rhizocote')">
                <div class="relative overflow-hidden rounded-2xl bg-gray-100 aspect-square">
                    <img src="{{ asset('images/rhizo-hero-bg.jpg') }}" alt="Corn Plantation" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                        <p class="text-white font-semibold text-sm">Corn Plantation - Mindanao</p>
                        <p class="text-white/70 text-xs">Exceptional Growth</p>
                    </div>
                    <div class="absolute top-3 right-3 w-9 h-9 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                    </div>
                </div>
            </div>

            <!-- Gallery Item 4 -->
            <div class="group cursor-pointer transition-all duration-700"
                 :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                 style="transition-delay: 225ms;"
                 @click="openLightbox('{{ asset('images/grains-min.webp') }}', 'Farmer inspecting rice quality after successful harvest')">
                <div class="relative overflow-hidden rounded-2xl bg-gray-100 aspect-square">
                    <img src="{{ asset('images/grains-min.webp') }}" alt="Quality Inspection" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                        <p class="text-white font-semibold text-sm">Quality Inspection</p>
                        <p class="text-white/70 text-xs">Premium Grade Rice</p>
                    </div>
                    <div class="absolute top-3 right-3 w-9 h-9 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                    </div>
                </div>
            </div>

            <!-- Gallery Item 5 -->
            <div class="group cursor-pointer transition-all duration-700"
                 :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                 style="transition-delay: 300ms;"
                 @click="openLightbox('{{ asset('images/rhizo-hero-bg.jpg') }}', 'Vegetable farm in Benguet using Rhizocote for organic produce')">
                <div class="relative overflow-hidden rounded-2xl bg-gray-100 aspect-square">
                    <img src="{{ asset('images/rhizo-hero-bg.jpg') }}" alt="Vegetable Farm" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                        <p class="text-white font-semibold text-sm">Vegetable Farm - Benguet</p>
                        <p class="text-white/70 text-xs">Organic Excellence</p>
                    </div>
                    <div class="absolute top-3 right-3 w-9 h-9 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                    </div>
                </div>
            </div>

            <!-- Gallery Item 6 -->
            <div class="group cursor-pointer transition-all duration-700"
                 :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                 style="transition-delay: 375ms;"
                 @click="openLightbox('{{ asset('images/grains-min.webp') }}', 'Banana plantation thriving with Rhizocote micronutrients')">
                <div class="relative overflow-hidden rounded-2xl bg-gray-100 aspect-square">
                    <img src="{{ asset('images/grains-min.webp') }}" alt="Banana Plantation" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                        <p class="text-white font-semibold text-sm">Banana Plantation</p>
                        <p class="text-white/70 text-xs">Thriving Growth</p>
                    </div>
                    <div class="absolute top-3 right-3 w-9 h-9 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                    </div>
                </div>
            </div>

            <!-- Gallery Item 7 -->
            <div class="group cursor-pointer transition-all duration-700"
                 :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                 style="transition-delay: 450ms;"
                 @click="openLightbox('{{ asset('images/rhizo-hero-bg.jpg') }}', 'WIPO Gold Medal Award Ceremony 1997')">
                <div class="relative overflow-hidden rounded-2xl bg-gray-100 aspect-square">
                    <img src="{{ asset('images/rhizo-hero-bg.jpg') }}" alt="Award Ceremony" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                        <p class="text-white font-semibold text-sm">WIPO Gold Medal</p>
                        <p class="text-white/70 text-xs">Award Ceremony 1997</p>
                    </div>
                    <div class="absolute top-3 right-3 w-9 h-9 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                    </div>
                </div>
            </div>

            <!-- Gallery Item 8 -->
            <div class="group cursor-pointer transition-all duration-700"
                 :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                 style="transition-delay: 525ms;"
                 @click="openLightbox('{{ asset('images/grains-min.webp') }}', 'Happy farmers in Nueva Ecija after successful rice harvest')">
                <div class="relative overflow-hidden rounded-2xl bg-gray-100 aspect-square">
                    <img src="{{ asset('images/grains-min.webp') }}" alt="Happy Farmers" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                        <p class="text-white font-semibold text-sm">Nueva Ecija Farmers</p>
                        <p class="text-white/70 text-xs">Successful Harvest</p>
                    </div>
                    <div class="absolute top-3 right-3 w-9 h-9 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lightbox Modal -->
    <div x-show="lightboxOpen"
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @keydown.escape.window="closeLightbox()"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/90 backdrop-blur-sm">

        <!-- Close Button -->
        <button @click="closeLightbox()" class="absolute top-6 right-6 w-12 h-12 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center transition-colors">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>

        <!-- Image Container -->
        <div @click.away="closeLightbox()" class="max-w-5xl w-full">
            <img :src="currentImage" alt="Gallery Image" class="w-full max-h-[75vh] object-contain rounded-2xl shadow-2xl">

            <!-- Caption -->
            <div class="mt-6 text-center">
                <p x-text="currentCaption" class="text-white text-lg md:text-xl leading-relaxed"></p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-brand-green-dark">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center"
         x-data="{ shown: false }"
         x-intersect:enter.threshold.25="shown = true">
        <h2 class="text-4xl md:text-5xl font-bold text-white mb-6 transition-all duration-700"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
            style="font-family: 'Instrument Sans', sans-serif;">
            Ready to Transform Your Farm?
        </h2>
        <p class="text-xl text-white/80 mb-10 transition-all duration-700 delay-150"
           :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            Join thousands of Filipino farmers who have increased their yields with Rhizocote technology. Get started today and learn proper application techniques from our expert community.
        </p>
        <a href="{{ route('community.join') }}" class="group inline-flex items-center gap-2 bg-brand-yellow text-brand-dark px-10 py-4 rounded-full font-bold text-lg hover:bg-brand-yellow-hover transition-all shadow-lg shadow-brand-yellow/30 duration-700 delay-300"
           :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            Join the Community
            <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
        </a>
    </div>
</section>
@endsection
