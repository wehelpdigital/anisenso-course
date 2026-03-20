@extends('layouts.app')

@section('title', 'Ani-Senso Academy - Learn & Grow')

@push('styles')
<style>
    /* Floating animation for decorative shapes */
    @keyframes float {
        0%, 100% {
            transform: translateY(0) rotate(-3deg);
        }
        50% {
            transform: translateY(-15px) rotate(-1deg);
        }
    }
    @keyframes float-reverse {
        0%, 100% {
            transform: translateY(0) rotate(3deg);
        }
        50% {
            transform: translateY(-12px) rotate(5deg);
        }
    }
    @keyframes pulse-scale {
        0%, 100% {
            transform: scale(1);
            opacity: 0.8;
        }
        50% {
            transform: scale(1.1);
            opacity: 0.6;
        }
    }
    @keyframes pulse-scale-alt {
        0%, 100% {
            transform: scale(1);
            opacity: 0.8;
        }
        50% {
            transform: scale(0.9);
            opacity: 1;
        }
    }
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
    .animate-float-reverse {
        animation: float-reverse 7s ease-in-out infinite;
    }
    .animate-pulse-scale {
        animation: pulse-scale 4s ease-in-out infinite;
    }
    .animate-pulse-scale-alt {
        animation: pulse-scale-alt 5s ease-in-out infinite;
    }
</style>
@endpush

@section('content')
@php
    // BTC Check URL for assets
    $btcUrl = rtrim(config('app.btc_check_url'), '/');

    // Get Hero Section Settings
    $heroSection = $sections->get("hero");
    $heroBgImage = $heroSection?->getSetting("backgroundImage", $btcUrl . "/wp-content/uploads/2025/12/488478569_2174213226369837_7066166916975308288_n.jpg");
    $heroOverlay = $heroSection?->getSetting("overlayOpacity", 50);
    $heroSupertext = $heroSection?->getSetting("supertext", "Maximizing Crop Yields for Palay, Mais, and More");
    $heroTitle = $heroSection?->getSetting("title", "Helping Filipino Farmers Reach Maximum Yield and Income");
    $heroDescription = $heroSection?->getSetting("description", "At Ani (Yield) + Senso (Sensei means Teacher and Asenso means Success) — we help farmers maximize their yield through our exclusive technical research, support, fertilization, and management technologies.");
    $heroCtaText = $heroSection?->getSetting("ctaText", "Join Our Community Now");
    $heroCtaUrl = $heroSection?->getSetting("ctaUrl", "/courses");
    // Slider settings
    $heroSlides = $heroSection?->activeItems->where("itemType", "slide") ?? collect();
    $slideDuration = $heroSection?->getSetting("slideDuration", 5) * 1000;
    $fadeSpeed = $heroSection?->getSetting("fadeSpeed", 1000);
@endphp
<!-- Hero Section -->
<section class="relative min-h-[85vh] flex items-center overflow-hidden">
    <!-- Background Slider -->
    <div class="hero-slider absolute inset-0">
        @forelse($heroSlides as $index => $slide)
        <div class="hero-slide absolute inset-0 transition-opacity {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}"
             style="background-image: url('{{ $slide->imageUrl }}'); background-size: cover; background-position: center; transition-duration: {{ $fadeSpeed }}ms;">
        </div>
        @empty
        {{-- Fallback to single background image --}}
        <div class="hero-slide absolute inset-0 opacity-100"
             style="background-image: url('{{ $heroBgImage }}'); background-size: cover; background-position: center;">
        </div>
        @endforelse
    </div>
    <!-- Gradient overlays for depth -->
    <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/70 to-black/50" style="z-index: 1;"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent" style="z-index: 1;"></div>

    <!-- Decorative Elements -->
    <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-brand-yellow/10 rounded-full blur-3xl" style="z-index: 1;"></div>
    <div class="absolute bottom-1/3 left-1/4 w-64 h-64 bg-brand-green/10 rounded-full blur-3xl" style="z-index: 1;"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-40 w-full" style="z-index: 2;">
        <!-- Text Content - Centered -->
        <div class="text-center max-w-5xl mx-auto">
            <!-- Badge Supertext -->
            <div class="animate-on-load animate-slide-in-left mb-8">
                <div class="inline-flex items-center gap-2 bg-brand-yellow/20 backdrop-blur-sm text-brand-yellow px-5 py-2.5 rounded-full border border-brand-yellow/30">
                    <svg class="w-5 h-5" viewBox="0 0 548.40 548.40" fill="currentColor"><path d="M389.712,100.37c-58.596,15.385-78.961,65.835-75.574,86.918c1.074-0.648,2.125-1.273,3.211-1.95 c5.149-3.159,10.754-6.148,16.569-9.23c5.78-3.101,12.005-5.979,18.274-8.898c3.153-1.471,6.458-2.762,9.728-4.093l4.928-2.009 c2.125-0.835,3.433-1.179,5.185-1.792l9.879-3.287c3.434-0.98,6.843-1.938,10.218-2.896c6.831-1.886,13.429-3.55,19.851-4.875 c12.833-2.919,24.896-5.044,35.276-6.65c20.786-3.165,34.95-3.766,34.95-3.766s-3.234,1.39-8.91,3.812 c-5.698,2.371-13.825,5.512-23.611,9.272c-4.928,1.792-10.217,3.742-15.822,5.797c-5.616,1.997-11.549,4.087-17.667,6.253 c-6.061,2.137-12.284,4.367-18.648,6.638c-6.224,2.102-12.717,4.589-19.232,7.088c-6.072,2.271-12.378,5.296-18.566,7.748 c-6.142,2.796-16.675,6.458-22.63,9.003c-7.182,3.013-11.725,4.642-16.29,7.059c-51.116,29.829-73.764,82.633-87.578,138.508 c-2.452-52.489-13.464-103.413-51.356-140.972c0.035-0.023,0.087-0.035,0.123-0.064c-5.132-4.805-10.463-9.972-15.951-15.507 c-4.507-4.647-9.271-9.266-13.907-14.193c-4.758-4.636-9.435-9.826-14.205-14.252c-5.085-4.805-10.106-9.563-15.069-13.907 c-5.01-4.496-9.908-8.933-14.684-13.236c-4.84-4.338-9.517-8.524-13.942-12.518c-4.385-4.041-8.571-7.871-12.395-11.409 c-7.619-7.187-13.954-13.212-18.298-17.58c-4.304-4.408-6.756-6.93-6.756-6.93s12.845,5.967,30.852,16.821 c8.979,5.453,19.308,12.016,30.074,19.612c5.424,3.696,10.889,7.748,16.476,12.086c2.75,2.189,5.546,4.367,8.32,6.568l7.882,6.813 c1.384,1.244,2.464,2.043,4.099,3.637l3.807,3.743c2.534,2.487,5.08,4.951,7.421,7.497c4.723,5.08,9.341,10.13,13.516,15.198 c4.192,5.068,8.227,9.972,11.776,14.854c0.753,1.051,1.46,2.008,2.213,3.024c11.204-18.187,11.642-72.597-36.66-109.199 C103.99,39.287,30.693,57.153,0,42.422c30.991,47.409,25.041,79.06,77.104,131.087c34.792,34.809,67.284,36.964,89.172,30.909 c44.519,42.855,51.467,108.188,51.49,170.708c-4.554-3.69-10.089-6.586-16.476-6.586c-18.018,0-31.138,10.135-37.426,24.592 c-39.661-13.499-66.004,17.877-68.287,44.303c-18.87-7.018-42.809,14.689-42.809,33.549c0,18.625,14.719,33.699,33.157,34.482 l291.945,0.514c0,0,31.107-16.769,31.107-35.008c0-19.115-15.495-34.635-34.61-34.635c-2.651,0-5.186,0.35-7.637,0.91 c0.163-1.342-3.34-60.125-54.416-36.514c-3.97-18.392-9.178-32.193-39.865-32.193c-15.116,0-25.352,5.488-31.902,11.069 c12.781-65.019,32.533-132.944,90.101-166.544c0.631-0.356,0.958-0.835,1.401-1.267c17.796,14.275,48.904,25.304,95.075,6.13 c67.961-28.229,74.535-59.746,121.278-91.724C514.446,128.109,453.515,83.625,389.712,100.37z M230.611,390.552l1.909-1.915 c-0.963,1.495-1.553,2.581-1.553,2.581S230.774,390.844,230.611,390.552z"/></svg>
                    <span class="text-sm font-semibold tracking-wide uppercase">{!! $heroSupertext !!}</span>
                </div>
            </div>

            <!-- Main Title -->
            <h1 class="animate-on-load animate-fade-in-up delay-100 text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-medium text-white leading-tight mb-8" style="font-family: 'Instrument Sans', sans-serif;">
                Helping Filipino Farmers<br class="hidden md:inline"> Reach <span class="text-brand-yellow">Maximum Yield</span><br class="hidden md:inline"> and Income
            </h1>

            <!-- Description -->
            <div class="animate-on-load animate-slide-in-left delay-200 mb-10">
                <p class="text-xl text-white/80 max-w-3xl mx-auto leading-relaxed">
                    {!! $heroDescription !!}
                </p>
            </div>

            <!-- CTA Button -->
            <div class="animate-on-load animate-slide-in-right delay-300 mb-12">
                <a href="{{ url($heroCtaUrl) }}" class="group inline-flex items-center gap-2 bg-brand-yellow text-brand-dark px-10 py-4 rounded-full font-bold text-lg hover:bg-brand-yellow-hover transition-all shadow-lg shadow-brand-yellow/30 hover:shadow-xl hover:shadow-brand-yellow/40">
                    {{ $heroCtaText }}
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>

            <!-- Stats Row -->
            <div class="animate-on-load animate-fade-in delay-400 flex flex-wrap justify-center gap-8 md:gap-12">
                <div class="text-center">
                    <p class="text-4xl md:text-5xl font-bold text-brand-yellow">45+</p>
                    <p class="text-white/60 text-sm mt-1">Years Experience</p>
                </div>
                <div class="w-px bg-white/20 hidden sm:block"></div>
                <div class="text-center">
                    <p class="text-4xl md:text-5xl font-bold text-brand-yellow">10K+</p>
                    <p class="text-white/60 text-sm mt-1">Farmers Trained</p>
                </div>
                <div class="w-px bg-white/20 hidden sm:block"></div>
                <div class="text-center">
                    <p class="text-4xl md:text-5xl font-bold text-brand-yellow">50%</p>
                    <p class="text-white/60 text-sm mt-1">Yield Increase</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Trusted Partners Bar -->
    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-black/40 backdrop-blur-sm py-6 border-t border-white/10" style="z-index: 2;">
        <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-16">
            <p class="text-center text-white/50 text-xs md:text-sm uppercase tracking-widest mb-5">Our Technology Featured In</p>
            <div class="flex items-center justify-center gap-8 md:gap-12 lg:gap-16">
                <!-- CBS -->
                <div class="opacity-60 hover:opacity-100 transition-opacity duration-300">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/4e/CBS_logo.svg/200px-CBS_logo.svg.png" alt="CBS" class="h-8 md:h-10 w-auto brightness-0 invert">
                </div>
                <!-- Wall Street Select -->
                <div class="opacity-60 hover:opacity-100 transition-opacity duration-300 hidden sm:block">
                    <span class="text-white font-bold text-lg md:text-xl tracking-tight">Wall Street Select</span>
                </div>
                <!-- Barchart -->
                <div class="opacity-60 hover:opacity-100 transition-opacity duration-300 hidden md:block">
                    <span class="text-white font-bold text-lg md:text-xl tracking-tight">Barchart</span>
                </div>
                <!-- Street Insider -->
                <div class="opacity-60 hover:opacity-100 transition-opacity duration-300 hidden lg:block">
                    <span class="text-white font-bold text-lg md:text-xl tracking-tight">Street Insider</span>
                </div>
                <!-- NBC -->
                <div class="opacity-60 hover:opacity-100 transition-opacity duration-300 hidden xl:block">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3f/NBC_logo.svg/200px-NBC_logo.svg.png" alt="NBC" class="h-8 md:h-10 w-auto brightness-0 invert">
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-28 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 animate-bounce" style="z-index: 3;">
        <span class="text-white/40 text-xs uppercase tracking-widest">Scroll</span>
        <svg class="w-5 h-5 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
    </div>
</section>

<!-- Award Winning Section - Video Background -->
@php
    $awardSection = $sections->get("award");
    $awardVideoUrl = $awardSection?->getSetting("videoUrl", "https://www.youtube.com/embed/V34MyFVO7kU");
    $awardSideImage = $awardSection?->getSetting("sideImage", $btcUrl . "/wp-content/uploads/2025/12/palay-08.jpg");
    $awardBadge = $awardSection?->getSetting("badge", $awardSection?->getSetting("supertext", "Locally and Internationally Recognized"));
    $awardTitle = $awardSection?->getSetting("title", "Award Winning");
    $awardTitleHighlight = $awardSection?->getSetting("titleHighlight", "Technology");
    $awardStatNumber = $awardSection?->getSetting("statNumber", "45+");
    $awardStatLabel = $awardSection?->getSetting("statLabel", "Years of Innovation");
    $awardDescription = $awardSection?->getSetting("description", "Proven track record of helping Filipino farmers achieve maximum crop yields through science-backed fertilization and management technologies.");
    $awardCtaText = $awardSection?->getSetting("ctaText", "Learn More");
    $awardCtaUrl = $awardSection?->getSetting("ctaUrl", "/about");
@endphp
<section class="relative py-24 overflow-hidden" style="background-color: #2d5016;">
    <!-- YouTube Video Background -->
    @if($awardVideoUrl)
    <div class="absolute inset-0 overflow-hidden">
        <iframe
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[300%] h-[300%] min-w-full min-h-full pointer-events-none"
            src="{{ $awardVideoUrl }}?autoplay=1&mute=1&loop=1&controls=0&showinfo=0&rel=0&modestbranding=1&playsinline=1&enablejsapi=1"
            frameborder="0"
            allow="autoplay; encrypted-media"
            allowfullscreen>
        </iframe>
    </div>
    @endif
    <!-- Dark Green Overlay -->
    <div class="absolute inset-0 bg-brand-green-dark/85"></div>

    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.4\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <!-- Left - Image with decorative elements -->
            <div class="relative">
                <!-- Decorative blur -->
                <div class="absolute -top-8 -left-8 w-32 h-32 bg-brand-yellow/20 rounded-full blur-2xl"></div>
                <div class="absolute -bottom-8 -right-8 w-24 h-24 bg-brand-green/30 rounded-full blur-2xl"></div>

                <!-- Decorative frame -->
                <div class="absolute -top-3 -right-3 w-full h-full border-2 border-brand-yellow/30 rounded-3xl"></div>

                <img src="{{ $awardSideImage }}" alt="Rice Field" class="relative rounded-3xl shadow-2xl w-full h-[400px] lg:h-[500px] object-cover border border-white/10">

                <!-- Floating Badge -->
                <div class="absolute -bottom-6 -left-6 bg-brand-yellow text-brand-dark px-6 py-4 rounded-2xl shadow-xl">
                    <div class="flex items-center gap-3">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L9.19 8.63 2 9.24l5.46 4.73L5.82 21 12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2z"/></svg>
                        <div>
                            <p class="text-xs font-semibold uppercase">WIPO</p>
                            <p class="text-lg font-bold">Gold Medal</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right - Content -->
            <div class="lg:pl-8">
                <div class="inline-flex items-center gap-2 bg-brand-yellow/20 text-brand-yellow px-4 py-2 rounded-full mb-6 border border-brand-yellow/30">
                    <svg class="w-5 h-5" viewBox="0 0 548.40 548.40" fill="currentColor"><path d="M389.712,100.37c-58.596,15.385-78.961,65.835-75.574,86.918c1.074-0.648,2.125-1.273,3.211-1.95 c5.149-3.159,10.754-6.148,16.569-9.23c5.78-3.101,12.005-5.979,18.274-8.898c3.153-1.471,6.458-2.762,9.728-4.093l4.928-2.009 c2.125-0.835,3.433-1.179,5.185-1.792l9.879-3.287c3.434-0.98,6.843-1.938,10.218-2.896c6.831-1.886,13.429-3.55,19.851-4.875 c12.833-2.919,24.896-5.044,35.276-6.65c20.786-3.165,34.95-3.766,34.95-3.766s-3.234,1.39-8.91,3.812 c-5.698,2.371-13.825,5.512-23.611,9.272c-4.928,1.792-10.217,3.742-15.822,5.797c-5.616,1.997-11.549,4.087-17.667,6.253 c-6.061,2.137-12.284,4.367-18.648,6.638c-6.224,2.102-12.717,4.589-19.232,7.088c-6.072,2.271-12.378,5.296-18.566,7.748 c-6.142,2.796-16.675,6.458-22.63,9.003c-7.182,3.013-11.725,4.642-16.29,7.059c-51.116,29.829-73.764,82.633-87.578,138.508 c-2.452-52.489-13.464-103.413-51.356-140.972c0.035-0.023,0.087-0.035,0.123-0.064c-5.132-4.805-10.463-9.972-15.951-15.507 c-4.507-4.647-9.271-9.266-13.907-14.193c-4.758-4.636-9.435-9.826-14.205-14.252c-5.085-4.805-10.106-9.563-15.069-13.907 c-5.01-4.496-9.908-8.933-14.684-13.236c-4.84-4.338-9.517-8.524-13.942-12.518c-4.385-4.041-8.571-7.871-12.395-11.409 c-7.619-7.187-13.954-13.212-18.298-17.58c-4.304-4.408-6.756-6.93-6.756-6.93s12.845,5.967,30.852,16.821 c8.979,5.453,19.308,12.016,30.074,19.612c5.424,3.696,10.889,7.748,16.476,12.086c2.75,2.189,5.546,4.367,8.32,6.568l7.882,6.813 c1.384,1.244,2.464,2.043,4.099,3.637l3.807,3.743c2.534,2.487,5.08,4.951,7.421,7.497c4.723,5.08,9.341,10.13,13.516,15.198 c4.192,5.068,8.227,9.972,11.776,14.854c0.753,1.051,1.46,2.008,2.213,3.024c11.204-18.187,11.642-72.597-36.66-109.199 C103.99,39.287,30.693,57.153,0,42.422c30.991,47.409,25.041,79.06,77.104,131.087c34.792,34.809,67.284,36.964,89.172,30.909 c44.519,42.855,51.467,108.188,51.49,170.708c-4.554-3.69-10.089-6.586-16.476-6.586c-18.018,0-31.138,10.135-37.426,24.592 c-39.661-13.499-66.004,17.877-68.287,44.303c-18.87-7.018-42.809,14.689-42.809,33.549c0,18.625,14.719,33.699,33.157,34.482 l291.945,0.514c0,0,31.107-16.769,31.107-35.008c0-19.115-15.495-34.635-34.61-34.635c-2.651,0-5.186,0.35-7.637,0.91 c0.163-1.342-3.34-60.125-54.416-36.514c-3.97-18.392-9.178-32.193-39.865-32.193c-15.116,0-25.352,5.488-31.902,11.069 c12.781-65.019,32.533-132.944,90.101-166.544c0.631-0.356,0.958-0.835,1.401-1.267c17.796,14.275,48.904,25.304,95.075,6.13 c67.961-28.229,74.535-59.746,121.278-91.724C514.446,128.109,453.515,83.625,389.712,100.37z M230.611,390.552l1.909-1.915 c-0.963,1.495-1.553,2.581-1.553,2.581S230.774,390.844,230.611,390.552z"/></svg>
                    <span class="text-sm font-semibold uppercase tracking-wide">{{ $awardBadge }}</span>
                </div>

                <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-8" style="font-family: 'Instrument Sans', sans-serif;">
                    {{ $awardTitle }}<br><span class="text-brand-yellow">{{ $awardTitleHighlight }}</span>
                </h2>

                <div class="flex flex-col md:flex-row items-start gap-8 mb-8">
                    <div class="text-center md:text-left">
                        <div class="text-7xl md:text-8xl font-bold text-brand-yellow" style="font-family: 'Instrument Sans', sans-serif;">{{ $awardStatNumber }}</div>
                        <div class="text-white/60 text-lg">{{ $awardStatLabel }}</div>
                    </div>
                    <div class="flex-1">
                        <p class="text-white/80 text-lg leading-relaxed mb-6">
                            {{ $awardDescription }}
                        </p>
                        <a href="{{ url($awardCtaUrl) }}" class="group inline-flex items-center gap-2 bg-brand-yellow text-brand-dark px-8 py-4 rounded-full font-bold hover:bg-brand-yellow-hover transition-all shadow-lg shadow-brand-yellow/25">
                            {{ $awardCtaText }}
                            <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Award Badges -->
                <div class="flex flex-wrap gap-4">
                    <div class="bg-white/10 backdrop-blur-sm px-5 py-3 rounded-xl border border-white/20">
                        <p class="text-brand-yellow font-bold text-lg">DOST</p>
                        <p class="text-white/60 text-sm">Most Outstanding</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm px-5 py-3 rounded-xl border border-white/20">
                        <p class="text-brand-yellow font-bold text-lg">WIPO</p>
                        <p class="text-white/60 text-sm">Gold Medal</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm px-5 py-3 rounded-xl border border-white/20">
                        <p class="text-brand-yellow font-bold text-lg">FIS</p>
                        <p class="text-white/60 text-sm">Certified</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About Us Section - White Background -->
<section class="py-24 bg-gradient-to-b from-white to-gray-50 relative overflow-hidden" x-data="{ shown: false }" x-intersect:enter.once="shown = true">
    <!-- Decorative Elements -->
    <div class="absolute top-0 left-0 w-96 h-96 bg-brand-green/5 rounded-full -translate-x-1/2 -translate-y-1/2 blur-3xl"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-brand-yellow/5 rounded-full translate-x-1/2 translate-y-1/2 blur-3xl"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header with animation -->
        <div class="text-center mb-16 transition-all duration-700"
             :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <div class="inline-flex items-center gap-2 bg-brand-green/10 text-brand-green px-5 py-2.5 rounded-full mb-6">
                <svg class="w-5 h-5" viewBox="0 0 548.40 548.40" fill="currentColor"><path d="M389.712,100.37c-58.596,15.385-78.961,65.835-75.574,86.918c1.074-0.648,2.125-1.273,3.211-1.95 c5.149-3.159,10.754-6.148,16.569-9.23c5.78-3.101,12.005-5.979,18.274-8.898c3.153-1.471,6.458-2.762,9.728-4.093l4.928-2.009 c2.125-0.835,3.433-1.179,5.185-1.792l9.879-3.287c3.434-0.98,6.843-1.938,10.218-2.896c6.831-1.886,13.429-3.55,19.851-4.875 c12.833-2.919,24.896-5.044,35.276-6.65c20.786-3.165,34.95-3.766,34.95-3.766s-3.234,1.39-8.91,3.812 c-5.698,2.371-13.825,5.512-23.611,9.272c-4.928,1.792-10.217,3.742-15.822,5.797c-5.616,1.997-11.549,4.087-17.667,6.253 c-6.061,2.137-12.284,4.367-18.648,6.638c-6.224,2.102-12.717,4.589-19.232,7.088c-6.072,2.271-12.378,5.296-18.566,7.748 c-6.142,2.796-16.675,6.458-22.63,9.003c-7.182,3.013-11.725,4.642-16.29,7.059c-51.116,29.829-73.764,82.633-87.578,138.508 c-2.452-52.489-13.464-103.413-51.356-140.972c0.035-0.023,0.087-0.035,0.123-0.064c-5.132-4.805-10.463-9.972-15.951-15.507 c-4.507-4.647-9.271-9.266-13.907-14.193c-4.758-4.636-9.435-9.826-14.205-14.252c-5.085-4.805-10.106-9.563-15.069-13.907 c-5.01-4.496-9.908-8.933-14.684-13.236c-4.84-4.338-9.517-8.524-13.942-12.518c-4.385-4.041-8.571-7.871-12.395-11.409 c-7.619-7.187-13.954-13.212-18.298-17.58c-4.304-4.408-6.756-6.93-6.756-6.93s12.845,5.967,30.852,16.821 c8.979,5.453,19.308,12.016,30.074,19.612c5.424,3.696,10.889,7.748,16.476,12.086c2.75,2.189,5.546,4.367,8.32,6.568l7.882,6.813 c1.384,1.244,2.464,2.043,4.099,3.637l3.807,3.743c2.534,2.487,5.08,4.951,7.421,7.497c4.723,5.08,9.341,10.13,13.516,15.198 c4.192,5.068,8.227,9.972,11.776,14.854c0.753,1.051,1.46,2.008,2.213,3.024c11.204-18.187,11.642-72.597-36.66-109.199 C103.99,39.287,30.693,57.153,0,42.422c30.991,47.409,25.041,79.06,77.104,131.087c34.792,34.809,67.284,36.964,89.172,30.909 c44.519,42.855,51.467,108.188,51.49,170.708c-4.554-3.69-10.089-6.586-16.476-6.586c-18.018,0-31.138,10.135-37.426,24.592 c-39.661-13.499-66.004,17.877-68.287,44.303c-18.87-7.018-42.809,14.689-42.809,33.549c0,18.625,14.719,33.699,33.157,34.482 l291.945,0.514c0,0,31.107-16.769,31.107-35.008c0-19.115-15.495-34.635-34.61-34.635c-2.651,0-5.186,0.35-7.637,0.91 c0.163-1.342-3.34-60.125-54.416-36.514c-3.97-18.392-9.178-32.193-39.865-32.193c-15.116,0-25.352,5.488-31.902,11.069 c12.781-65.019,32.533-132.944,90.101-166.544c0.631-0.356,0.958-0.835,1.401-1.267c17.796,14.275,48.904,25.304,95.075,6.13 c67.961-28.229,74.535-59.746,121.278-91.724C514.446,128.109,453.515,83.625,389.712,100.37z M230.611,390.552l1.909-1.915 c-0.963,1.495-1.553,2.581-1.553,2.581S230.774,390.844,230.611,390.552z"/></svg>
                <span class="text-sm font-semibold uppercase tracking-wide">About Us</span>
            </div>
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-6" style="font-family: 'Instrument Sans', sans-serif;">
                Real Science and <span class="text-brand-green">Support</span> Combined
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                We combine cutting-edge agricultural science with hands-on technical support to help Filipino farmers achieve unprecedented results.
            </p>
        </div>

        <!-- 4 Service Cards with staggered animations -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
            <!-- Service 1: Fertilization -->
            <div class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:border-brand-green/20 hover:-translate-y-2"
                 :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
                 style="transition-delay: 150ms">
                <div class="w-20 h-20 mx-auto mb-6 bg-brand-green/10 group-hover:bg-brand-green/20 rounded-2xl flex items-center justify-center transition-colors">
                    <img src="{{ asset('images/icons/fertilizer.png') }}" alt="Fertilization" class="w-12 h-12 object-contain">
                </div>
                <h3 class="font-bold text-gray-900 text-xl mb-3 text-center">Fertilization</h3>
                <p class="text-gray-600 text-center leading-relaxed">Advanced nutrient delivery systems for optimal plant growth and health.</p>
            </div>

            <!-- Service 2: Biostimulants -->
            <div class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:border-brand-yellow/30 hover:-translate-y-2"
                 :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
                 style="transition-delay: 250ms">
                <div class="w-20 h-20 mx-auto mb-6 bg-brand-yellow/10 group-hover:bg-brand-yellow/20 rounded-2xl flex items-center justify-center transition-colors">
                    <img src="{{ asset('images/icons/biostimulant.png') }}" alt="Biostimulants" class="w-12 h-12 object-contain">
                </div>
                <h3 class="font-bold text-gray-900 text-xl mb-3 text-center">Biostimulants</h3>
                <p class="text-gray-600 text-center leading-relaxed">Natural compounds that enhance plant vitality and stress resistance.</p>
            </div>

            <!-- Service 3: Soil Restoration -->
            <div class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:border-brand-green/20 hover:-translate-y-2"
                 :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
                 style="transition-delay: 350ms">
                <div class="w-20 h-20 mx-auto mb-6 bg-brand-green/10 group-hover:bg-brand-green/20 rounded-2xl flex items-center justify-center transition-colors">
                    <img src="{{ asset('images/icons/soil-restoration.png') }}" alt="Soil Restoration" class="w-12 h-12 object-contain">
                </div>
                <h3 class="font-bold text-gray-900 text-xl mb-3 text-center">Soil Restoration</h3>
                <p class="text-gray-600 text-center leading-relaxed">Revitalize depleted soils and rebuild healthy microbial ecosystems.</p>
            </div>

            <!-- Service 4: Technician Support -->
            <div class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:border-brand-yellow/30 hover:-translate-y-2"
                 :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
                 style="transition-delay: 450ms">
                <div class="w-20 h-20 mx-auto mb-6 bg-brand-yellow/10 group-hover:bg-brand-yellow/20 rounded-2xl flex items-center justify-center transition-colors">
                    <img src="{{ asset('images/icons/technician-support.png') }}" alt="Technician Support" class="w-12 h-12 object-contain">
                </div>
                <h3 class="font-bold text-gray-900 text-xl mb-3 text-center">Technician Support</h3>
                <p class="text-gray-600 text-center leading-relaxed">Expert guidance and on-site assistance from experienced agricultural technicians.</p>
            </div>
        </div>

        <!-- CTA with animation -->
        <div class="text-center mt-16 transition-all duration-700 delay-500"
             :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <a href="{{ route('community.join') }}" class="group inline-flex items-center gap-3 bg-brand-green text-white px-10 py-4 rounded-full font-bold text-lg hover:bg-brand-green-dark transition-all shadow-lg shadow-brand-green/25 hover:shadow-xl">
                Join the Community
                <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            <p class="text-gray-500 mt-4 text-sm">Get access to courses, tools, and expert support</p>
        </div>
    </div>
</section>

<!-- Before & After Section -->
@php
    $beforeAfterSection = $sections->get('before_after');
    $beforeAfterTitle = $beforeAfterSection?->getSetting('title', 'Before & After');
    $beforeAfterSubtitle = $beforeAfterSection?->getSetting('subtitle', 'Results That Speak');
    $beforeAfterDescription = $beforeAfterSection?->getSetting('description', 'See the remarkable transformation achieved by farmers using AniSenso Technology');
    $beforeAfterItems = $beforeAfterSection?->activeItems ?? collect();

    // Default items if none exist
    $defaultBeforeAfterItems = [
        [
            'title' => 'Rice Field Transformation',
            'description' => 'This rice field in Nueva Ecija showed remarkable improvement after just 3 months of using AniSenso fertilization techniques. Yield increased by 45% compared to the previous harvest season.',
            'beforeImage' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=800&h=600&fit=crop',
            'afterImage' => 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=800&h=600&fit=crop',
        ],
        [
            'title' => 'Corn Crop Revival',
            'description' => 'A struggling corn farm in Isabela was revitalized using our soil restoration program. The farmer reported healthier stalks and doubled production within one growing cycle.',
            'beforeImage' => 'https://images.unsplash.com/photo-1471193945509-9ad0617afabf?w=800&h=600&fit=crop',
            'afterImage' => 'https://images.unsplash.com/photo-1601593768498-5eb79ac14ec5?w=800&h=600&fit=crop',
        ],
        [
            'title' => 'Vegetable Garden Success',
            'description' => 'This backyard vegetable garden was transformed from barren soil to a thriving produce source. The owner now supplies fresh vegetables to local markets.',
            'beforeImage' => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=800&h=600&fit=crop',
            'afterImage' => 'https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?w=800&h=600&fit=crop',
        ],
        [
            'title' => 'Organic Farm Expansion',
            'description' => 'Starting with just half a hectare, this farmer expanded to 3 hectares of organic produce using sustainable AniSenso methods. Income increased by 300%.',
            'beforeImage' => 'https://images.unsplash.com/photo-1500076656116-558758c991c1?w=800&h=600&fit=crop',
            'afterImage' => 'https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=800&h=600&fit=crop',
        ],
    ];
@endphp
@if($beforeAfterSection?->isEnabled !== false)
<section class="py-24 bg-gray-100 relative overflow-hidden" x-data="{
    lightboxOpen: false,
    currentImage: null,
    currentTitle: '',
    currentDescription: '',
    currentType: '',
    openLightbox(image, title, description, type) {
        this.currentImage = image;
        this.currentTitle = title;
        this.currentDescription = description;
        this.currentType = type;
        this.lightboxOpen = true;
        document.body.style.overflow = 'hidden';
    },
    closeLightbox() {
        this.lightboxOpen = false;
        this.currentImage = null;
        this.currentTitle = '';
        this.currentDescription = '';
        this.currentType = '';
        document.body.style.overflow = '';
    }
}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-2 bg-brand-green/10 text-brand-green px-5 py-2.5 rounded-full mb-6">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                <span class="text-sm font-semibold uppercase tracking-wide">{{ $beforeAfterSubtitle }}</span>
            </div>
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-6" style="font-family: 'Instrument Sans', sans-serif;">
                {!! $beforeAfterTitle !!}
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                {{ $beforeAfterDescription }}
            </p>
        </div>

        <!-- Before & After Grid - 2 Columns -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @forelse($beforeAfterItems as $item)
            <!-- Dynamic Item from Database -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                <div class="relative">
                    <div class="grid grid-cols-2">
                        <!-- Before - Clickable -->
                        <div class="relative cursor-pointer group/before overflow-hidden"
                             @click="openLightbox('{{ $item->imageUrl }}', '{{ addslashes($item->title) }}', '{{ addslashes($item->description) }}', 'Before')">
                            @if($item->imageUrl)
                                <img src="{{ $item->imageUrl }}" alt="Before" class="w-full h-48 md:h-56 object-cover transition-transform group-hover/before:scale-105">
                            @else
                                <div class="w-full h-48 md:h-56 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400">No image</span>
                                </div>
                            @endif
                            <div class="absolute top-3 left-3 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                                BEFORE
                            </div>
                            <!-- Hover Overlay -->
                            <div class="absolute inset-0 bg-black/0 group-hover/before:bg-black/30 transition-all flex items-center justify-center opacity-0 group-hover/before:opacity-100">
                                <div class="bg-white rounded-full p-2 shadow-lg transform scale-75 group-hover/before:scale-100 transition-transform">
                                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <!-- After - Clickable -->
                        <div class="relative cursor-pointer group/after overflow-hidden"
                             @click="openLightbox('{{ $item->image2Url }}', '{{ addslashes($item->title) }}', '{{ addslashes($item->description) }}', 'After')">
                            @if($item->image2Url)
                                <img src="{{ $item->image2Url }}" alt="After" class="w-full h-48 md:h-56 object-cover transition-transform group-hover/after:scale-105">
                            @else
                                <div class="w-full h-48 md:h-56 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400">No image</span>
                                </div>
                            @endif
                            <div class="absolute top-3 left-3 bg-brand-green text-white text-xs font-bold px-3 py-1 rounded-full">
                                AFTER
                            </div>
                            <!-- Hover Overlay -->
                            <div class="absolute inset-0 bg-black/0 group-hover/after:bg-black/30 transition-all flex items-center justify-center opacity-0 group-hover/after:opacity-100">
                                <div class="bg-white rounded-full p-2 shadow-lg transform scale-75 group-hover/after:scale-100 transition-transform">
                                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-gray-900 text-lg mb-1">{{ $item->title }}</h3>
                    <p class="text-gray-500 text-sm line-clamp-2">{{ Str::limit($item->description, 80) }}</p>
                    <span class="text-gray-400 text-xs mt-2 block">Click on each image to view full size</span>
                </div>
            </div>
            @empty
            <!-- Default Items when no database items exist -->
            @foreach($defaultBeforeAfterItems as $index => $item)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                <div class="relative">
                    <div class="grid grid-cols-2">
                        <!-- Before - Clickable -->
                        <div class="relative cursor-pointer group/before overflow-hidden"
                             @click="openLightbox('{{ $item['beforeImage'] }}', '{{ addslashes($item['title']) }}', '{{ addslashes($item['description']) }}', 'Before')">
                            <img src="{{ $item['beforeImage'] }}" alt="Before" class="w-full h-48 md:h-56 object-cover transition-transform group-hover/before:scale-105">
                            <div class="absolute top-3 left-3 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                                BEFORE
                            </div>
                            <!-- Hover Overlay -->
                            <div class="absolute inset-0 bg-black/0 group-hover/before:bg-black/30 transition-all flex items-center justify-center opacity-0 group-hover/before:opacity-100">
                                <div class="bg-white rounded-full p-2 shadow-lg transform scale-75 group-hover/before:scale-100 transition-transform">
                                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <!-- After - Clickable -->
                        <div class="relative cursor-pointer group/after overflow-hidden"
                             @click="openLightbox('{{ $item['afterImage'] }}', '{{ addslashes($item['title']) }}', '{{ addslashes($item['description']) }}', 'After')">
                            <img src="{{ $item['afterImage'] }}" alt="After" class="w-full h-48 md:h-56 object-cover transition-transform group-hover/after:scale-105">
                            <div class="absolute top-3 left-3 bg-brand-green text-white text-xs font-bold px-3 py-1 rounded-full">
                                AFTER
                            </div>
                            <!-- Hover Overlay -->
                            <div class="absolute inset-0 bg-black/0 group-hover/after:bg-black/30 transition-all flex items-center justify-center opacity-0 group-hover/after:opacity-100">
                                <div class="bg-white rounded-full p-2 shadow-lg transform scale-75 group-hover/after:scale-100 transition-transform">
                                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-gray-900 text-lg mb-1">{{ $item['title'] }}</h3>
                    <p class="text-gray-500 text-sm line-clamp-2">{{ Str::limit($item['description'], 80) }}</p>
                    <span class="text-gray-400 text-xs mt-2 block">Click on each image to view full size</span>
                </div>
            </div>
            @endforeach
            @endforelse
        </div>

        <!-- CTA -->
        <div class="text-center mt-12">
            <a href="{{ route('community.join') }}" class="group inline-flex items-center gap-3 bg-brand-green text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-brand-green-dark transition-all shadow-lg hover:shadow-xl">
                Join the Community
                <svg class="w-6 h-6 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            <p class="text-gray-500 mt-4 text-sm">Join thousands of farmers who have transformed their farms</p>
        </div>
    </div>

    <!-- Lightbox Modal -->
    <div x-show="lightboxOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4"
         style="display: none;"
         @keydown.escape.window="closeLightbox()">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/90" @click="closeLightbox()"></div>

        <!-- Modal Content -->
        <div x-show="lightboxOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="relative bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
            <!-- Close Button -->
            <button @click="closeLightbox()" class="absolute top-4 right-4 z-10 bg-white/90 hover:bg-white rounded-full p-2 shadow-lg transition-colors">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <!-- Single Image -->
            <div class="relative">
                <img :src="currentImage" :alt="currentType" class="w-full h-64 md:h-96 lg:h-[500px] object-cover">
                <!-- Type Badge -->
                <div class="absolute top-4 left-4 text-white text-sm font-bold px-4 py-2 rounded-full shadow-lg"
                     :class="currentType === 'Before' ? 'bg-red-500' : 'bg-brand-green'"
                     x-text="currentType.toUpperCase()">
                </div>
            </div>

            <!-- Description -->
            <div class="p-6 md:p-8">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold"
                          :class="currentType === 'Before' ? 'bg-red-100 text-red-600' : 'bg-green-100 text-brand-green'"
                          x-text="currentType + ' Photo'"></span>
                </div>
                <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3" x-text="currentTitle"></h3>
                <p class="text-gray-600 text-lg leading-relaxed" x-text="currentDescription"></p>
                <div class="mt-6 flex gap-4">
                    <a href="{{ route('community.join') }}" class="group inline-flex items-center gap-2 bg-brand-green text-white px-6 py-3 rounded-full font-semibold hover:bg-brand-green-dark transition-colors">
                        Join the Community
                        <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    <button @click="closeLightbox()" class="inline-flex items-center gap-2 bg-gray-100 text-gray-700 px-6 py-3 rounded-full font-semibold hover:bg-gray-200 transition-colors">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Seasonal CTA Section - Video Background -->
<section class="relative py-16 md:py-24 overflow-hidden" style="background-color: #2d5016;">
    <!-- YouTube Video Background -->
    <div class="absolute inset-0 overflow-hidden">
        <iframe
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[200%] h-[200%] min-w-full min-h-full pointer-events-none"
            src="https://www.youtube.com/embed/qVk6thNT_uM?autoplay=1&mute=1&loop=1&playlist=qVk6thNT_uM&controls=0&showinfo=0&rel=0&modestbranding=1&playsinline=1&enablejsapi=1"
            frameborder="0"
            allow="autoplay; encrypted-media"
            allowfullscreen>
        </iframe>
    </div>
    <!-- Dark Green Overlay -->
    <div class="absolute inset-0 bg-brand-green-dark/85"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header - Centered -->
        <div class="text-center mb-12">
            <div class="flex items-center justify-center gap-2 text-brand-yellow text-sm font-semibold uppercase tracking-wide mb-4">
                <svg class="w-5 h-5" viewBox="0 0 548.40 548.40" fill="currentColor"><path d="M389.712,100.37c-58.596,15.385-78.961,65.835-75.574,86.918c1.074-0.648,2.125-1.273,3.211-1.95 c5.149-3.159,10.754-6.148,16.569-9.23c5.78-3.101,12.005-5.979,18.274-8.898c3.153-1.471,6.458-2.762,9.728-4.093l4.928-2.009 c2.125-0.835,3.433-1.179,5.185-1.792l9.879-3.287c3.434-0.98,6.843-1.938,10.218-2.896c6.831-1.886,13.429-3.55,19.851-4.875 c12.833-2.919,24.896-5.044,35.276-6.65c20.786-3.165,34.95-3.766,34.95-3.766s-3.234,1.39-8.91,3.812 c-5.698,2.371-13.825,5.512-23.611,9.272c-4.928,1.792-10.217,3.742-15.822,5.797c-5.616,1.997-11.549,4.087-17.667,6.253 c-6.061,2.137-12.284,4.367-18.648,6.638c-6.224,2.102-12.717,4.589-19.232,7.088c-6.072,2.271-12.378,5.296-18.566,7.748 c-6.142,2.796-16.675,6.458-22.63,9.003c-7.182,3.013-11.725,4.642-16.29,7.059c-51.116,29.829-73.764,82.633-87.578,138.508 c-2.452-52.489-13.464-103.413-51.356-140.972c0.035-0.023,0.087-0.035,0.123-0.064c-5.132-4.805-10.463-9.972-15.951-15.507 c-4.507-4.647-9.271-9.266-13.907-14.193c-4.758-4.636-9.435-9.826-14.205-14.252c-5.085-4.805-10.106-9.563-15.069-13.907 c-5.01-4.496-9.908-8.933-14.684-13.236c-4.84-4.338-9.517-8.524-13.942-12.518c-4.385-4.041-8.571-7.871-12.395-11.409 c-7.619-7.187-13.954-13.212-18.298-17.58c-4.304-4.408-6.756-6.93-6.756-6.93s12.845,5.967,30.852,16.821 c8.979,5.453,19.308,12.016,30.074,19.612c5.424,3.696,10.889,7.748,16.476,12.086c2.75,2.189,5.546,4.367,8.32,6.568l7.882,6.813 c1.384,1.244,2.464,2.043,4.099,3.637l3.807,3.743c2.534,2.487,5.08,4.951,7.421,7.497c4.723,5.08,9.341,10.13,13.516,15.198 c4.192,5.068,8.227,9.972,11.776,14.854c0.753,1.051,1.46,2.008,2.213,3.024c11.204-18.187,11.642-72.597-36.66-109.199 C103.99,39.287,30.693,57.153,0,42.422c30.991,47.409,25.041,79.06,77.104,131.087c34.792,34.809,67.284,36.964,89.172,30.909 c44.519,42.855,51.467,108.188,51.49,170.708c-4.554-3.69-10.089-6.586-16.476-6.586c-18.018,0-31.138,10.135-37.426,24.592 c-39.661-13.499-66.004,17.877-68.287,44.303c-18.87-7.018-42.809,14.689-42.809,33.549c0,18.625,14.719,33.699,33.157,34.482 l291.945,0.514c0,0,31.107-16.769,31.107-35.008c0-19.115-15.495-34.635-34.61-34.635c-2.651,0-5.186,0.35-7.637,0.91 c0.163-1.342-3.34-60.125-54.416-36.514c-3.97-18.392-9.178-32.193-39.865-32.193c-15.116,0-25.352,5.488-31.902,11.069 c12.781-65.019,32.533-132.944,90.101-166.544c0.631-0.356,0.958-0.835,1.401-1.267c17.796,14.275,48.904,25.304,95.075,6.13 c67.961-28.229,74.535-59.746,121.278-91.724C514.446,128.109,453.515,83.625,389.712,100.37z M230.611,390.552l1.909-1.915 c-0.963,1.495-1.553,2.581-1.553,2.581S230.774,390.844,230.611,390.552z"/></svg>
                <span>Maximum Income and Sustainability</span>
            </div>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-black text-white leading-tight mb-6">
                Reach Your Crop's Maximum Potential for the Season
            </h2>
            <p class="text-gray-300 text-sm md:text-base leading-relaxed max-w-3xl mx-auto">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            </p>
        </div>

        <!-- Bottom Row: Image Carousel with Button - Full Width -->
        <div class="w-full" x-data="{
            currentSlide: 0,
            visibleSlides: 4,
            autoplayInterval: null,
            images: [
                { src: '{{ $btcUrl }}/wp-content/uploads/2025/12/banana.png', alt: 'Banana' },
                { src: '{{ $btcUrl }}/wp-content/uploads/2025/12/palm.png', alt: 'Palm' },
                { src: '{{ $btcUrl }}/wp-content/uploads/2025/12/mango.png', alt: 'Mango' },
                { src: '{{ $btcUrl }}/wp-content/uploads/2025/12/banana.png', alt: 'Banana Harvest' },
                { src: '{{ $btcUrl }}/wp-content/uploads/2025/12/palm.png', alt: 'Palm Grove' },
                { src: '{{ $btcUrl }}/wp-content/uploads/2025/12/mango.png', alt: 'Mango Orchard' },
                { src: '{{ $btcUrl }}/wp-content/uploads/2025/12/banana.png', alt: 'Banana Farm' },
                { src: '{{ $btcUrl }}/wp-content/uploads/2025/12/palm.png', alt: 'Palm Plantation' }
            ],
            get totalSlides() {
                return this.images.length;
            },
            get maxSlide() {
                return Math.max(0, this.totalSlides - this.visibleSlides);
            },
            next() {
                this.currentSlide = this.currentSlide >= this.maxSlide ? 0 : this.currentSlide + 1;
            },
            prev() {
                this.currentSlide = this.currentSlide <= 0 ? this.maxSlide : this.currentSlide - 1;
            },
            goTo(index) {
                this.currentSlide = Math.min(index, this.maxSlide);
            },
            startAutoplay() {
                this.autoplayInterval = setInterval(() => this.next(), 3000);
            },
            stopAutoplay() {
                clearInterval(this.autoplayInterval);
            }
        }" x-init="startAutoplay()" @mouseenter="stopAutoplay()" @mouseleave="startAutoplay()">

            <!-- Carousel Container - Full Width aligned with content above -->
            <div class="relative w-full mb-6">
                <!-- Slides Container - No extra margin, aligned with grid above -->
                <div class="overflow-hidden">
                    <div class="flex transition-transform duration-500 ease-in-out -mx-2" :style="'transform: translateX(-' + (currentSlide * 25) + '%)'">
                        <template x-for="(image, index) in images" :key="index">
                            <div class="flex-shrink-0 w-1/2 md:w-1/4 px-2">
                                <div class="w-full h-48 sm:h-56 md:h-64 lg:h-72 rounded-2xl overflow-hidden shadow-2xl">
                                    <img :src="image.src" :alt="image.alt" class="w-full h-full object-cover">
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Dots Indicator -->
                <div class="flex justify-center gap-2 mt-4">
                    <template x-for="(_, index) in (maxSlide + 1)" :key="index">
                        <button @click="goTo(index)"
                            class="w-2 h-2 rounded-full transition-colors"
                            :class="currentSlide === index ? 'bg-brand-yellow' : 'bg-white/40'">
                        </button>
                    </template>
                </div>
            </div>

            <!-- Button Centered Below Carousel -->
            <div class="text-center">
                <a href="{{ route('community.join') }}" class="group inline-flex items-center gap-2 bg-brand-yellow text-brand-dark px-6 py-3 rounded-full font-bold hover:bg-brand-yellow-hover transition-colors shadow-lg">
                    Join the Community
                    <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
                <p class="text-white/70 mt-3 text-sm">Access all courses and expert support</p>
            </div>
        </div>
    </div>
</section>

<!-- Real Results Section -->
<section class="py-24 bg-gradient-to-b from-gray-50 to-white relative overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute top-1/4 right-0 w-64 h-64 bg-brand-yellow/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-1/4 left-0 w-64 h-64 bg-brand-green/10 rounded-full blur-3xl"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header - Centered -->
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-2 bg-brand-green/10 text-brand-green px-5 py-2.5 rounded-full mb-6">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="text-sm font-semibold uppercase tracking-wide">Real Results from Real People</span>
            </div>
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-6" style="font-family: 'Instrument Sans', sans-serif;">
                Success <span class="text-brand-green">Stories</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                See how Filipino farmers transformed their harvests with our proven techniques
            </p>
        </div>

        <!-- 3 Column Image Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <!-- Image 1 -->
            <div class="group">
                <div class="relative aspect-square rounded-2xl overflow-hidden shadow-lg mb-4">
                    <img src="https://placehold.co/400x400/4a7c2a/ffffff?text=Farmer+1" alt="Juan Santos - Rice Farmer" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    <!-- Hover Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <!-- Result Badge -->
                    <div class="absolute top-4 right-4 bg-brand-yellow text-brand-dark px-3 py-1 rounded-full text-sm font-bold shadow-lg">
                        +45% Yield
                    </div>
                </div>
                <div class="text-center">
                    <h3 class="font-bold text-gray-900 text-lg">Juan Santos</h3>
                    <p class="text-gray-600 text-sm">Increased rice yield by 45% in one season</p>
                    <p class="text-brand-green text-sm font-medium mt-1">Nueva Ecija</p>
                </div>
            </div>

            <!-- Image 2 -->
            <div class="group">
                <div class="relative aspect-square rounded-2xl overflow-hidden shadow-lg mb-4">
                    <img src="https://placehold.co/400x400/2d5016/ffffff?text=Farmer+2" alt="Maria Cruz - Farm Owner" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    <!-- Hover Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <!-- Result Badge -->
                    <div class="absolute top-4 right-4 bg-brand-yellow text-brand-dark px-3 py-1 rounded-full text-sm font-bold shadow-lg">
                        3 Months
                    </div>
                </div>
                <div class="text-center">
                    <h3 class="font-bold text-gray-900 text-lg">Maria Cruz</h3>
                    <p class="text-gray-600 text-sm">Complete farm transformation in 3 months</p>
                    <p class="text-brand-green text-sm font-medium mt-1">Isabela</p>
                </div>
            </div>

            <!-- Image 3 -->
            <div class="group">
                <div class="relative aspect-square rounded-2xl overflow-hidden shadow-lg mb-4">
                    <img src="https://placehold.co/400x400/6b9f3d/ffffff?text=Farmer+3" alt="Pedro Reyes - Organic Farmer" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    <!-- Hover Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <!-- Result Badge -->
                    <div class="absolute top-4 right-4 bg-brand-yellow text-brand-dark px-3 py-1 rounded-full text-sm font-bold shadow-lg">
                        100% Organic
                    </div>
                </div>
                <div class="text-center">
                    <h3 class="font-bold text-gray-900 text-lg">Pedro Reyes</h3>
                    <p class="text-gray-600 text-sm">Achieved sustainable organic farming</p>
                    <p class="text-brand-green text-sm font-medium mt-1">Benguet</p>
                </div>
            </div>
        </div>

        <!-- CTA Button -->
        <div class="text-center">
            <a href="{{ route('community.join') }}" class="group inline-flex items-center gap-2 bg-brand-yellow text-brand-dark px-10 py-4 rounded-full font-bold text-lg hover:bg-brand-yellow-hover transition-all shadow-lg shadow-brand-yellow/25 hover:shadow-xl">
                Join the Community
                <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            <p class="text-gray-500 mt-4 text-sm">See real results from Filipino farmers just like you</p>
        </div>
    </div>
</section>

<!-- Why Choose AniSenso - Alternating Image/Content Section -->
<section class="py-24 bg-gradient-to-b from-gray-50 to-gray-100 overflow-hidden relative">
    <!-- Decorative Background Elements -->
    <div class="absolute top-0 left-0 w-96 h-96 bg-brand-green/5 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-brand-yellow/5 rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-20" x-data="{ shown: false }" x-intersect:enter.once="shown = true">
            <div class="inline-flex items-center gap-2 bg-brand-green/10 text-brand-green px-5 py-2.5 rounded-full text-sm font-semibold uppercase tracking-wide mb-6 transition-all duration-500"
                 :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                Why Choose AniSenso
            </div>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-black text-gray-900 mb-6 transition-all duration-500 delay-100" style="font-family: 'Instrument Sans', sans-serif;"
                :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                Transform Your Farm <span class="text-brand-green">With Us</span>
            </h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto transition-all duration-500 delay-200"
               :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                Discover how our proven agricultural innovations, expert guidance, and dedicated support can help you achieve sustainable farming success and maximize your crop yields.
            </p>
        </div>

        <!-- Row 1: Image Left, Content Right - Expert Training -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center mb-32"
             x-data="{ shown: false }" x-intersect:enter.once="shown = true">
            <!-- Image -->
            <div class="relative transition-all duration-700"
                 :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-12'">
                <div class="overflow-hidden rounded-2xl shadow-2xl group">
                    <img src="https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=800&h=600&fit=crop" alt="Expert Training" class="w-full h-[400px] lg:h-[500px] object-cover transition-transform duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                </div>
                <!-- Floating Badge -->
                <div class="absolute -bottom-6 -right-6 bg-white rounded-2xl shadow-xl p-5 hidden lg:block">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-brand-green/10 rounded-xl flex items-center justify-center">
                            <svg class="w-7 h-7 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <div>
                            <div class="text-2xl font-black text-gray-900">50+</div>
                            <div class="text-sm text-gray-500">Video Courses</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Content -->
            <div class="lg:pl-4 transition-all duration-700 delay-200"
                 :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-12'">
                <span class="inline-flex items-center gap-2 bg-brand-green/10 text-brand-green px-4 py-2 rounded-full text-sm font-semibold mb-4">
                    <span class="w-2 h-2 bg-brand-green rounded-full animate-pulse"></span>
                    Expert Training
                </span>
                <h3 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-6" style="font-family: 'Instrument Sans', sans-serif;">Learn From Industry Experts</h3>
                <p class="text-gray-600 text-lg leading-relaxed mb-6">
                    Our courses are designed by agricultural scientists and experienced farmers who have spent decades perfecting sustainable farming techniques. Get access to proven methodologies that have helped thousands of Filipino farmers increase their yields.
                </p>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-start gap-4 p-3 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex-shrink-0 w-10 h-10 bg-brand-green rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-900">Research-backed techniques</span>
                            <p class="text-gray-500 text-sm">Proven methods from agricultural experts</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-4 p-3 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex-shrink-0 w-10 h-10 bg-brand-green rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-900">HD video tutorials</span>
                            <p class="text-gray-500 text-sm">Step-by-step visual guides in Filipino</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-4 p-3 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex-shrink-0 w-10 h-10 bg-brand-green rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-900">Lifetime access</span>
                            <p class="text-gray-500 text-sm">Learn at your own pace, forever</p>
                        </div>
                    </li>
                </ul>
                <a href="{{ route('community.join') }}" class="group inline-flex items-center gap-2 bg-brand-green text-white px-8 py-4 rounded-full font-semibold hover:bg-brand-green/90 transition-all shadow-lg shadow-brand-green/30 hover:shadow-xl hover:shadow-brand-green/40">
                    Join the Community
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>

        <!-- Row 2: Content Left, Image Right - Support -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center mb-32"
             x-data="{ shown: false }" x-intersect:enter.once="shown = true">
            <!-- Content -->
            <div class="lg:pr-4 order-2 lg:order-1 transition-all duration-700"
                 :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-12'">
                <span class="inline-flex items-center gap-2 bg-brand-yellow/20 text-brand-dark px-4 py-2 rounded-full text-sm font-semibold mb-4">
                    <span class="w-2 h-2 bg-brand-yellow rounded-full animate-pulse"></span>
                    24/7 Support
                </span>
                <h3 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-6" style="font-family: 'Instrument Sans', sans-serif;">Dedicated Support Team</h3>
                <p class="text-gray-600 text-lg leading-relaxed mb-6">
                    You're never alone in your farming journey. Our team of agricultural technicians is available around the clock to answer your questions, troubleshoot problems, and provide personalized guidance.
                </p>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-start gap-4 p-3 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex-shrink-0 w-10 h-10 bg-brand-yellow rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-brand-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-900">24/7 chat support</span>
                            <p class="text-gray-500 text-sm">Get answers anytime via chat or call</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-4 p-3 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex-shrink-0 w-10 h-10 bg-brand-yellow rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-brand-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-900">On-site farm visits</span>
                            <p class="text-gray-500 text-sm">Expert technicians visit your farm</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-4 p-3 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex-shrink-0 w-10 h-10 bg-brand-yellow rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-brand-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-900">Community forums</span>
                            <p class="text-gray-500 text-sm">Connect with 10,000+ farmers</p>
                        </div>
                    </li>
                </ul>
                <a href="{{ route('community.join') }}" class="group inline-flex items-center gap-2 bg-brand-yellow text-brand-dark px-8 py-4 rounded-full font-semibold hover:bg-brand-yellow-hover transition-all shadow-lg shadow-brand-yellow/30 hover:shadow-xl hover:shadow-brand-yellow/40">
                    Join the Community
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
            <!-- Image -->
            <div class="relative order-1 lg:order-2 transition-all duration-700 delay-200"
                 :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-12'">
                <div class="overflow-hidden rounded-2xl shadow-2xl group">
                    <img src="https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=800&h=600&fit=crop" alt="Support Team" class="w-full h-[400px] lg:h-[500px] object-cover transition-transform duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                </div>
                <!-- Floating Badge -->
                <div class="absolute -bottom-6 -left-6 bg-white rounded-2xl shadow-xl p-5 hidden lg:block">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-brand-yellow/20 rounded-xl flex items-center justify-center">
                            <svg class="w-7 h-7 text-brand-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <div class="text-2xl font-black text-gray-900">&lt;5min</div>
                            <div class="text-sm text-gray-500">Response Time</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 3: Latest From Our Blog -->
        <div class="relative" x-data="{ shown: false }" x-intersect:enter.once="shown = true">
            <!-- Section Header -->
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-12">
                <div class="transition-all duration-700"
                     :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                    <div class="inline-flex items-center gap-2 bg-brand-green/10 text-brand-green px-4 py-2 rounded-full mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        <span class="text-sm font-semibold uppercase tracking-wide">Latest Insights</span>
                    </div>
                    <h3 class="text-3xl md:text-4xl font-bold text-gray-900" style="font-family: 'Instrument Sans', sans-serif;">
                        From Our <span class="text-brand-green">Blog</span>
                    </h3>
                    <p class="text-gray-600 mt-3 max-w-xl">
                        Expert farming tips, success stories, and the latest agricultural innovations to help you grow better.
                    </p>
                </div>
                <a href="{{ route('blog.index') }}" class="group inline-flex items-center gap-2 text-brand-green font-semibold hover:text-brand-green-dark transition-colors shrink-0 transition-all duration-700 delay-100"
                   :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                    View All Articles
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            <!-- Blog Grid: Featured + 2 Smaller -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8">
                @if($blogPosts->count() > 0)
                    @php $featured = $blogPosts->first(); @endphp
                    <!-- Featured Post (Large) -->
                    <div class="lg:col-span-7 transition-all duration-700 delay-150"
                         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'">
                        <a href="{{ route('blog.show', $featured['slug']) }}" class="group block relative rounded-2xl overflow-hidden h-full min-h-[400px] lg:min-h-[480px]">
                            <!-- Image -->
                            <img src="{{ $featured['image'] }}" alt="{{ $featured['title'] }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            <!-- Gradient Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/60 to-transparent"></div>
                            <!-- Content -->
                            <div class="absolute inset-0 p-6 lg:p-8 flex flex-col justify-end">
                                <div class="flex items-center gap-3 mb-4">
                                    <span class="bg-{{ $featured['category_color'] }} text-white text-xs font-bold px-3 py-1.5 rounded-full">
                                        {{ $featured['category'] }}
                                    </span>
                                    <span class="text-white/70 text-sm flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ $featured['read_time'] }}
                                    </span>
                                </div>
                                <h4 class="text-2xl lg:text-3xl font-bold text-white mb-3 group-hover:text-brand-yellow transition-colors" style="font-family: 'Instrument Sans', sans-serif;">
                                    {{ $featured['title'] }}
                                </h4>
                                <p class="text-white/80 text-base lg:text-lg line-clamp-2 mb-4">
                                    {{ $featured['excerpt'] }}
                                </p>
                                <div class="flex items-center gap-2 text-brand-yellow font-semibold">
                                    Read Article
                                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Two Smaller Posts -->
                    <div class="lg:col-span-5 flex flex-col gap-6">
                        @foreach($blogPosts->skip(1) as $post)
                            <div class="transition-all duration-700"
                                 :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
                                 style="transition-delay: {{ 200 + $loop->index * 100 }}ms">
                                <a href="{{ route('blog.show', $post['slug']) }}" class="group flex gap-5 bg-white rounded-2xl p-4 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100">
                                    <!-- Thumbnail -->
                                    <div class="relative w-32 h-32 lg:w-40 lg:h-40 rounded-xl overflow-hidden flex-shrink-0">
                                        <img src="{{ $post['image'] }}" alt="{{ $post['title'] }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                        <div class="absolute inset-0 bg-black/10 group-hover:bg-black/0 transition-colors"></div>
                                    </div>
                                    <!-- Content -->
                                    <div class="flex flex-col justify-center py-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="bg-{{ $post['category_color'] }}/10 text-{{ $post['category_color'] }} text-xs font-semibold px-2.5 py-1 rounded-full">
                                                {{ $post['category'] }}
                                            </span>
                                        </div>
                                        <h5 class="font-bold text-gray-900 group-hover:text-brand-green transition-colors line-clamp-2 mb-2" style="font-family: 'Instrument Sans', sans-serif;">
                                            {{ $post['title'] }}
                                        </h5>
                                        <p class="text-gray-500 text-sm line-clamp-2 mb-3 hidden lg:block">
                                            {{ Str::limit($post['excerpt'], 80) }}
                                        </p>
                                        <div class="flex items-center gap-3 text-xs text-gray-400">
                                            <span class="flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                {{ $post['date'] }}
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                {{ $post['read_time'] }}
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach

                        <!-- CTA Card -->
                        <div class="bg-gradient-to-br from-brand-green to-brand-green-dark rounded-2xl p-6 text-white transition-all duration-700"
                             :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
                             style="transition-delay: 400ms">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                </div>
                                <div>
                                    <h5 class="font-bold mb-1">Get Farming Tips Weekly</h5>
                                    <p class="text-white/80 text-sm mb-3">Join our community for free courses and expert advice.</p>
                                    <a href="{{ route('community.join') }}" class="inline-flex items-center gap-2 text-brand-yellow font-semibold text-sm hover:text-white transition-colors">
                                        Join the Community
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="relative py-24 overflow-hidden" style="background-color: #2d5016;" x-data="{ shown: false }" x-intersect:enter.once="shown = true">
    <!-- YouTube Video Background -->
    <div class="absolute inset-0 overflow-hidden">
        <iframe
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[300%] h-[300%] min-w-full min-h-full pointer-events-none"
            src="https://www.youtube.com/embed/IGUPJ0jcs0E?autoplay=1&mute=1&loop=1&playlist=IGUPJ0jcs0E&controls=0&showinfo=0&rel=0&modestbranding=1&playsinline=1&enablejsapi=1"
            frameborder="0"
            allow="autoplay; encrypted-media"
            allowfullscreen>
        </iframe>
    </div>
    <!-- Dark Green Overlay -->
    <div class="absolute inset-0 bg-brand-green-dark/90"></div>

    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.4\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header - Centered with animation -->
        <div class="text-center mb-16 transition-all duration-700"
             :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <div class="inline-flex items-center gap-2 bg-brand-yellow/20 text-brand-yellow px-5 py-2.5 rounded-full mb-6 border border-brand-yellow/30">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                <span class="text-sm font-semibold uppercase tracking-wide">What Our Farmers Say</span>
            </div>
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4" style="font-family: 'Instrument Sans', sans-serif;">
                Real <span class="text-brand-yellow">Testimonials</span>
            </h2>
            <p class="text-xl text-white/70 max-w-2xl mx-auto">
                Hear from farmers who have transformed their yields with our technology
            </p>
        </div>

        <!-- Testimonials Grid with staggered animations -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
            $testimonials = [
                ['initials' => 'RS', 'name' => 'Roberto Santos', 'location' => 'Nueva Ecija', 'text' => 'AniSenso Technology has completely transformed my farm. My rice yield increased by 40% in just one season.', 'color' => 'green'],
                ['initials' => 'MC', 'name' => 'Maria Elena Cruz', 'location' => 'Guimaras', 'text' => "The fruits are bigger, sweeter, and I'm getting better prices at the market. I'm now a believer!", 'color' => 'yellow'],
                ['initials' => 'JR', 'name' => 'Jose Miguel Reyes', 'location' => 'Davao del Sur', 'text' => "The soil restoration program saved my farm. Now it's healthy again and producing like never before!", 'color' => 'green'],
                ['initials' => 'AB', 'name' => 'Antonio Bautista', 'location' => 'Quezon Province', 'text' => 'The technician support alone is worth it. They really care about our success as farmers.', 'color' => 'yellow'],
                ['initials' => 'CV', 'name' => 'Carmen Villanueva', 'location' => 'Benguet', 'text' => "My vegetable farm is now organic-certified thanks to AniSenso's guidance. My customers love it!", 'color' => 'green'],
                ['initials' => 'RF', 'name' => 'Ricardo Fernandez', 'location' => 'Compostela Valley', 'text' => 'Less disease, stronger plants, consistent quality. Our export clients are very impressed!', 'color' => 'yellow'],
            ];
            @endphp

            @foreach($testimonials as $index => $testimonial)
            <div class="group bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2"
                 :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
                 style="transition-delay: {{ 100 + ($index * 100) }}ms">
                <!-- Stars -->
                <div class="flex gap-1 mb-4">
                    @for($i = 0; $i < 5; $i++)
                    <svg class="w-5 h-5 text-brand-yellow" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L9.19 8.63 2 9.24l5.46 4.73L5.82 21 12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2z"/></svg>
                    @endfor
                </div>
                <p class="text-gray-700 mb-6 leading-relaxed text-lg">
                    "{{ $testimonial['text'] }}"
                </p>
                <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                    <div class="w-12 h-12 {{ $testimonial['color'] === 'green' ? 'bg-brand-green/20' : 'bg-brand-yellow/20' }} rounded-full flex items-center justify-center">
                        <span class="{{ $testimonial['color'] === 'green' ? 'text-brand-green' : 'text-brand-dark' }} font-bold text-lg">{{ $testimonial['initials'] }}</span>
                    </div>
                    <div>
                        <p class="text-gray-900 font-bold">{{ $testimonial['name'] }}</p>
                        <p class="text-brand-green text-sm">{{ $testimonial['location'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- CTA with animation -->
        <div class="text-center mt-16 transition-all duration-700 delay-700"
             :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <a href="{{ route('community.join') }}" class="group inline-flex items-center gap-3 bg-brand-yellow text-brand-dark px-10 py-4 rounded-full font-bold text-lg hover:bg-brand-yellow-hover transition-all shadow-lg shadow-brand-yellow/25 hover:shadow-xl">
                Join the Community
                <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            <p class="text-white/60 mt-4 text-sm">Be the next farmer to transform your harvest</p>
        </div>
    </div>
</section>

<!-- Final CTA Section -->
<section class="relative py-20 overflow-hidden" x-data="{ shown: false }" x-intersect:enter.once="shown = true">
    <!-- Background Image -->
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=1920&h=600&fit=crop" alt="Farm Field" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-brand-dark/95 via-brand-dark/90 to-brand-dark/80"></div>
    </div>

    <!-- Decorative Elements -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-brand-yellow/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-brand-green/10 rounded-full blur-3xl"></div>

    <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <!-- Badge -->
        <div class="transition-all duration-700"
             :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <span class="inline-flex items-center gap-2 bg-brand-yellow/20 text-brand-yellow px-5 py-2.5 rounded-full text-sm font-semibold border border-brand-yellow/30 mb-6">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Start Your Journey Today
            </span>
        </div>

        <!-- Heading -->
        <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 transition-all duration-700 delay-100"
            style="font-family: 'Instrument Sans', sans-serif;"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            Ready to Transform<br class="hidden md:inline"> Your <span class="text-brand-yellow">Farm</span>?
        </h2>

        <!-- Description -->
        <p class="text-xl text-white/80 max-w-2xl mx-auto mb-10 transition-all duration-700 delay-200"
           :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            Join thousands of Filipino farmers who have already increased their yields by up to 50%. Get free access to courses, expert support, and proven farming techniques.
        </p>

        <!-- Stats Row -->
        <div class="flex flex-wrap justify-center gap-8 md:gap-16 mb-10 transition-all duration-700 delay-300"
             :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-bold text-brand-yellow">10,000+</div>
                <div class="text-white/60 text-sm">Farmers Joined</div>
            </div>
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-bold text-brand-green">50%</div>
                <div class="text-white/60 text-sm">Avg. Yield Increase</div>
            </div>
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-bold text-white">FREE</div>
                <div class="text-white/60 text-sm">To Join</div>
            </div>
        </div>

        <!-- CTA Button -->
        <div class="transition-all duration-700 delay-400"
             :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <a href="{{ route('community.join') }}" class="group inline-flex items-center gap-3 bg-brand-yellow text-brand-dark px-10 py-5 rounded-full font-bold text-xl hover:bg-brand-yellow-hover transition-all shadow-xl shadow-brand-yellow/30 hover:shadow-2xl hover:scale-105">
                Join the Community
                <svg class="w-6 h-6 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
            <p class="text-white/50 mt-4 text-sm">No credit card required. Start learning immediately.</p>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.hero-slide');
    if (slides.length <= 1) return;

    let currentIndex = 0;
    const slideDuration = {{ $slideDuration ?? 5000 }};

    function nextSlide() {
        // Fade out current
        slides[currentIndex].classList.remove('opacity-100');
        slides[currentIndex].classList.add('opacity-0');

        // Move to next
        currentIndex = (currentIndex + 1) % slides.length;

        // Fade in next
        slides[currentIndex].classList.remove('opacity-0');
        slides[currentIndex].classList.add('opacity-100');
    }

    // Start slideshow
    setInterval(nextSlide, slideDuration);
});
</script>
@endpush

@endsection
