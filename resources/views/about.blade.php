@extends('layouts.app')

@section('title', 'About Us - AniSenso | Complete Farming Ecosystem')

@push('styles')
<style>
    /* Smooth Scroll */
    html {
        scroll-behavior: smooth;
    }

    /* Animation Keyframes */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInLeft {
        from { opacity: 0; transform: translateX(-30px); }
        to { opacity: 1; transform: translateX(0); }
    }
    @keyframes fadeInRight {
        from { opacity: 0; transform: translateX(30px); }
        to { opacity: 1; transform: translateX(0); }
    }
    @keyframes scaleIn {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }
    @keyframes countUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .anim-fade-in-up { animation: fadeInUp 0.7s cubic-bezier(0.22, 1, 0.36, 1) forwards; }
    .anim-fade-in-down { animation: fadeInDown 0.7s cubic-bezier(0.22, 1, 0.36, 1) forwards; }
    .anim-fade-in-left { animation: fadeInLeft 0.7s cubic-bezier(0.22, 1, 0.36, 1) forwards; }
    .anim-fade-in-right { animation: fadeInRight 0.7s cubic-bezier(0.22, 1, 0.36, 1) forwards; }
    .anim-scale-in { animation: scaleIn 0.7s cubic-bezier(0.22, 1, 0.36, 1) forwards; }
    .anim-delay-100 { animation-delay: 0.1s; }
    .anim-delay-200 { animation-delay: 0.2s; }
    .anim-delay-300 { animation-delay: 0.3s; }
    .anim-delay-400 { animation-delay: 0.4s; }
    .anim-delay-500 { animation-delay: 0.5s; }

    [class*="anim-"]:not(.anim-active) { opacity: 0; }

    .ecosystem-card {
        transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
    }
    .ecosystem-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.15);
    }

    .stat-card {
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        transform: scale(1.05);
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="relative min-h-[70vh] flex items-center overflow-hidden">
    <!-- Background -->
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=1920&h=1080&fit=crop" alt="Filipino farmland" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-brand-dark via-brand-dark/95 to-brand-dark/80"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-brand-dark via-transparent to-transparent"></div>
    </div>

    <!-- Decorative Elements -->
    <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-brand-yellow/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-1/4 left-1/4 w-64 h-64 bg-brand-green/10 rounded-full blur-3xl"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-20 w-full">
        <!-- Breadcrumb -->
        <nav class="flex justify-end mb-8 anim-fade-in-down anim-delay-100">
            <ol class="flex items-center gap-2 text-sm bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full">
                <li>
                    <a href="{{ url('/') }}" class="text-white/70 hover:text-white transition-colors">Home</a>
                </li>
                <li class="text-white/30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </li>
                <li>
                    <span class="text-brand-yellow font-medium">About</span>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 bg-brand-green/20 backdrop-blur-sm text-white px-5 py-2.5 rounded-full mb-6 border border-brand-green/30 anim-fade-in-up anim-delay-100">
                    <svg class="w-5 h-5 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="text-sm font-semibold uppercase tracking-wide">The Complete Farming Ecosystem</span>
                </div>

                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight anim-fade-in-up anim-delay-200" style="font-family: 'Instrument Sans', sans-serif;">
                    Empowering <span class="text-brand-yellow">Filipino Farmers</span> for a Better Tomorrow
                </h1>

                <p class="text-xl text-white/80 leading-relaxed mb-8 anim-fade-in-up anim-delay-300">
                    AniSenso is more than just a product or service. We are a complete ecosystem designed to transform Philippine agriculture through education, technology, quality inputs, and continuous innovation.
                </p>

                <div class="flex flex-wrap gap-4 anim-fade-in-up anim-delay-400">
                    <a href="#ecosystem"
                       @click.prevent="document.getElementById('ecosystem').scrollIntoView({ behavior: 'smooth', block: 'start' })"
                       class="group inline-flex items-center gap-2 bg-brand-yellow text-brand-dark px-6 py-3 rounded-full font-bold hover:bg-brand-yellow-hover transition-all cursor-pointer">
                        Explore Our Ecosystem
                        <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-y-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </a>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 gap-4 anim-fade-in-right anim-delay-300">
                <div class="stat-card bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                    <div class="text-4xl md:text-5xl font-bold text-brand-yellow mb-2">10K+</div>
                    <div class="text-white/70">Farmers Empowered</div>
                </div>
                <div class="stat-card bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                    <div class="text-4xl md:text-5xl font-bold text-brand-green mb-2">50%</div>
                    <div class="text-white/70">Avg. Yield Increase</div>
                </div>
                <div class="stat-card bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                    <div class="text-4xl md:text-5xl font-bold text-white mb-2">40+</div>
                    <div class="text-white/70">Provinces Reached</div>
                </div>
                <div class="stat-card bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                    <div class="text-4xl md:text-5xl font-bold text-brand-yellow mb-2">5+</div>
                    <div class="text-white/70">Years of R&D</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Problem Section - The Reality Filipino Farmers Face -->
<section class="relative py-24 overflow-hidden" x-data="{ shown: false }" x-intersect:enter.once="shown = true">
    <!-- Background Image -->
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=1920&h=1080&fit=crop&q=80" alt="Philippine farmland" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-gray-900/95 via-gray-900/90 to-gray-900/70"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            <!-- Left: Content -->
            <div>
                <div class="inline-flex items-center gap-2 bg-red-500/20 backdrop-blur-sm text-red-300 px-4 py-2 rounded-full mb-6 border border-red-500/30 transition-all duration-500"
                     :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span class="text-sm font-semibold uppercase tracking-wide">The Reality</span>
                </div>

                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-6 leading-tight transition-all duration-500 delay-100" style="font-family: 'Instrument Sans', sans-serif;"
                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                    Filipino Farmers <span class="text-red-400">Deserve Better</span>
                </h2>

                <p class="text-xl text-white/80 mb-8 leading-relaxed transition-all duration-500 delay-200"
                   :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                    Despite being the backbone of our nation, millions of Filipino farmers struggle daily with challenges that keep them trapped in a cycle of low productivity and uncertain income.
                </p>

                <!-- Statistics -->
                <div class="grid grid-cols-2 gap-4 mb-10 transition-all duration-500 delay-300"
                     :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/10">
                        <div class="text-3xl font-bold text-red-400 mb-1">5.6M</div>
                        <div class="text-white/60 text-sm">Filipino farming households</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/10">
                        <div class="text-3xl font-bold text-red-400 mb-1">₱9K</div>
                        <div class="text-white/60 text-sm">Average monthly income</div>
                    </div>
                </div>

                <p class="text-white/60 text-sm italic transition-all duration-500 delay-400"
                   :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                    "Kung mayroon lang sanang paraan para madagdagan ang ani namin at mabawasan ang gastos..." — Filipino farmer from Nueva Ecija
                </p>
            </div>

            <!-- Right: Challenges List -->
            <div class="space-y-4">
                <!-- Challenge 1 -->
                <div class="group bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10 hover:bg-white/10 transition-all duration-500"
                     :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-12'"
                     :style="shown ? 'transition-delay: 200ms' : ''">
                    <div class="flex items-start gap-5">
                        <div class="w-14 h-14 bg-red-500/20 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-red-500/30 transition-colors">
                            <svg class="w-7 h-7 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white mb-2">Low Yields & Poor Harvests</h3>
                            <p class="text-white/60 text-sm leading-relaxed">Outdated techniques and nutrient-deficient soils result in harvests that are 40-60% below their true potential, leaving farmers struggling to make ends meet.</p>
                        </div>
                    </div>
                </div>

                <!-- Challenge 2 -->
                <div class="group bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10 hover:bg-white/10 transition-all duration-500"
                     :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-12'"
                     :style="shown ? 'transition-delay: 300ms' : ''">
                    <div class="flex items-start gap-5">
                        <div class="w-14 h-14 bg-red-500/20 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-red-500/30 transition-colors">
                            <svg class="w-7 h-7 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white mb-2">Financial Uncertainty</h3>
                            <p class="text-white/60 text-sm leading-relaxed">Rising input costs, unpredictable weather, and volatile market prices create a constant state of financial stress with no guarantee of return on investment.</p>
                        </div>
                    </div>
                </div>

                <!-- Challenge 3 -->
                <div class="group bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10 hover:bg-white/10 transition-all duration-500"
                     :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-12'"
                     :style="shown ? 'transition-delay: 400ms' : ''">
                    <div class="flex items-start gap-5">
                        <div class="w-14 h-14 bg-red-500/20 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-red-500/30 transition-colors">
                            <svg class="w-7 h-7 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white mb-2">Wasted Time & Resources</h3>
                            <p class="text-white/60 text-sm leading-relaxed">Without proper scheduling tools and knowledge, farmers often apply inputs at wrong times or in wrong amounts, wasting money and reducing effectiveness.</p>
                        </div>
                    </div>
                </div>

                <!-- Challenge 4 -->
                <div class="group bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10 hover:bg-white/10 transition-all duration-500"
                     :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-12'"
                     :style="shown ? 'transition-delay: 500ms' : ''">
                    <div class="flex items-start gap-5">
                        <div class="w-14 h-14 bg-red-500/20 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-red-500/30 transition-colors">
                            <svg class="w-7 h-7 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white mb-2">Limited Access to Knowledge</h3>
                            <p class="text-white/60 text-sm leading-relaxed">Modern agricultural innovations and best practices rarely reach rural farming communities, leaving farmers to rely on outdated methods passed down through generations.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom: Transition to Solution -->
        <div class="mt-16 text-center transition-all duration-500 delay-500"
             :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <div class="inline-flex items-center gap-3 text-white/60">
                <div class="h-px w-12 bg-gradient-to-r from-transparent to-white/30"></div>
                <span class="text-sm uppercase tracking-wider">But there is hope</span>
                <div class="h-px w-12 bg-gradient-to-l from-transparent to-white/30"></div>
            </div>
            <div class="mt-4">
                <svg class="w-8 h-8 text-brand-yellow mx-auto animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
            </div>
        </div>
    </div>
</section>

<!-- Ecosystem Section -->
<section id="ecosystem" class="py-20 bg-gray-100" x-data="{ shown: false }" x-intersect:enter.once="shown = true">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <div class="inline-flex items-center gap-2 bg-brand-green/10 text-brand-green px-4 py-2 rounded-full mb-6 transition-all duration-500"
                 :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                <span class="text-sm font-semibold uppercase tracking-wide">Our Solution</span>
            </div>

            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-6 transition-all duration-500 delay-100" style="font-family: 'Instrument Sans', sans-serif;"
                :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                The AniSenso <span class="text-brand-green">Ecosystem</span>
            </h2>

            <p class="text-xl text-gray-600 transition-all duration-500 delay-200"
               :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                Six integrated pillars working together to revolutionize how Filipino farmers grow, learn, and succeed.
            </p>
        </div>

        <div class="space-y-16 lg:space-y-24">
            <!-- Pillar 1: Education - Image Left -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-center transition-all duration-700"
                 x-data="{ itemShown: false }" x-intersect:enter.once="itemShown = true"
                 :class="itemShown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'">
                <div class="relative rounded-2xl overflow-hidden shadow-xl group">
                    <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=800&h=600&fit=crop" alt="Education & Learning" class="w-full h-64 lg:h-96 object-cover transition-transform duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                    <div class="absolute top-4 left-4">
                        <span class="bg-brand-yellow text-brand-dark text-xs font-bold px-4 py-2 rounded-full">01 - Education</span>
                    </div>
                </div>
                <div>
                    <h3 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-4" style="font-family: 'Instrument Sans', sans-serif;">Education & Learning</h3>
                    <p class="text-gray-600 text-lg mb-6 leading-relaxed">
                        Comprehensive courses and training programs covering modern farming techniques, best practices, and agricultural science. Our education platform empowers farmers with knowledge that translates directly to improved yields and sustainable practices.
                    </p>
                    <p class="text-gray-500 mb-6">
                        From beginner fundamentals to advanced techniques, our curriculum is designed by agricultural experts and validated through real-world application across thousands of Filipino farms.
                    </p>
                    <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <li class="flex items-center gap-3 text-gray-700">
                            <span class="w-6 h-6 bg-brand-green/10 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            Online & field training
                        </li>
                        <li class="flex items-center gap-3 text-gray-700">
                            <span class="w-6 h-6 bg-brand-green/10 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            Expert-led workshops
                        </li>
                        <li class="flex items-center gap-3 text-gray-700">
                            <span class="w-6 h-6 bg-brand-green/10 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            Certification programs
                        </li>
                        <li class="flex items-center gap-3 text-gray-700">
                            <span class="w-6 h-6 bg-brand-green/10 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            Video tutorials library
                        </li>
                    </ul>
                    <a href="{{ route('community.join') }}" class="group inline-flex items-center gap-2 bg-brand-yellow text-brand-dark px-6 py-3 rounded-full font-semibold mt-6 hover:bg-brand-yellow-hover transition-all">
                        Join the Community
                        <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            </div>

            <!-- Pillar 2: AI Tools - Image Right -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-center transition-all duration-700"
                 x-data="{ itemShown: false }" x-intersect:enter.once="itemShown = true"
                 :class="itemShown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'">
                <div class="order-1 lg:order-2 relative rounded-2xl overflow-hidden shadow-xl group">
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&h=600&fit=crop" alt="AI-Powered Tools" class="w-full h-64 lg:h-96 object-cover transition-transform duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                    <div class="absolute top-4 left-4">
                        <span class="bg-blue-500 text-white text-xs font-bold px-4 py-2 rounded-full">02 - Technology</span>
                    </div>
                </div>
                <div class="order-2 lg:order-1">
                    <h3 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-4" style="font-family: 'Instrument Sans', sans-serif;">AI-Powered Tools</h3>
                    <p class="text-gray-600 text-lg mb-6 leading-relaxed">
                        Smart technology solutions that help farmers make data-driven decisions for better outcomes and efficiency. Our AI tools analyze soil conditions, weather patterns, and crop health to provide actionable recommendations.
                    </p>
                    <p class="text-gray-500 mb-6">
                        Leverage the power of artificial intelligence to optimize every aspect of your farming operation, from planting schedules to harvest timing, ensuring maximum yield with minimum waste.
                    </p>
                    <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <li class="flex items-center gap-3 text-gray-700">
                            <span class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            Crop health analysis
                        </li>
                        <li class="flex items-center gap-3 text-gray-700">
                            <span class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            Yield prediction
                        </li>
                        <li class="flex items-center gap-3 text-gray-700">
                            <span class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            Smart scheduling
                        </li>
                        <li class="flex items-center gap-3 text-gray-700">
                            <span class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            Weather integration
                        </li>
                    </ul>
                    <span class="inline-flex items-center gap-2 bg-gray-200 text-gray-500 px-6 py-3 rounded-full font-semibold mt-6 cursor-not-allowed">
                        Coming Soon
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </span>
                </div>
            </div>

            <!-- Pillar 3: Fertilization - Image Left -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-center transition-all duration-700"
                 x-data="{ itemShown: false }" x-intersect:enter.once="itemShown = true"
                 :class="itemShown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'">
                <div class="relative rounded-2xl overflow-hidden shadow-xl group">
                    <img src="https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=800&h=600&fit=crop" alt="Fertilization Solutions" class="w-full h-64 lg:h-96 object-cover transition-transform duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                    <div class="absolute top-4 left-4">
                        <span class="bg-brand-green text-white text-xs font-bold px-4 py-2 rounded-full">03 - Fertilization</span>
                    </div>
                </div>
                <div>
                    <h3 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-4" style="font-family: 'Instrument Sans', sans-serif;">Fertilization Solutions</h3>
                    <p class="text-gray-600 text-lg mb-6 leading-relaxed">
                        Advanced micronutrient fertilizers like Rhizocote that address soil deficiencies and maximize plant health. Our scientifically-formulated products ensure your crops receive the precise nutrients they need at every growth stage.
                    </p>
                    <p class="text-gray-500 mb-6">
                        Philippine soils often lack essential micronutrients. Our fertilization solutions are specifically designed to address these deficiencies, promoting stronger root systems, better disease resistance, and higher quality harvests.
                    </p>
                    <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <li class="flex items-center gap-3 text-gray-700">
                            <span class="w-6 h-6 bg-brand-green/10 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            Rhizocote micronutrients
                        </li>
                        <li class="flex items-center gap-3 text-gray-700">
                            <span class="w-6 h-6 bg-brand-green/10 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            Biostimulants
                        </li>
                        <li class="flex items-center gap-3 text-gray-700">
                            <span class="w-6 h-6 bg-brand-green/10 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            Soil amendments
                        </li>
                        <li class="flex items-center gap-3 text-gray-700">
                            <span class="w-6 h-6 bg-brand-green/10 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            Foliar applications
                        </li>
                    </ul>
                    <a href="{{ route('community.join') }}" class="group inline-flex items-center gap-2 bg-brand-green text-white px-6 py-3 rounded-full font-semibold mt-6 hover:bg-brand-green/90 transition-all">
                        Join the Community
                        <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            </div>

            <!-- Pillar 4: Equipment - Image Right -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-center transition-all duration-700"
                 x-data="{ itemShown: false }" x-intersect:enter.once="itemShown = true"
                 :class="itemShown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'">
                <div class="order-1 lg:order-2 relative rounded-2xl overflow-hidden shadow-xl group">
                    <img src="https://images.unsplash.com/photo-1544197150-b99a580bb7a8?w=800&h=600&fit=crop" alt="Modern Equipment" class="w-full h-64 lg:h-96 object-cover transition-transform duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                    <div class="absolute top-4 left-4">
                        <span class="bg-orange-500 text-white text-xs font-bold px-4 py-2 rounded-full">04 - Equipment</span>
                    </div>
                </div>
                <div class="order-2 lg:order-1">
                    <h3 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-4" style="font-family: 'Instrument Sans', sans-serif;">Modern Equipment</h3>
                    <p class="text-gray-600 text-lg mb-6 leading-relaxed">
                        Access to modern farming tools and machinery that improve efficiency and reduce manual labor. The right equipment can dramatically increase productivity while reducing physical strain on farmers.
                    </p>
                    <p class="text-gray-500 mb-6">
                        From precision sprayers to soil testing kits, we provide access to equipment that helps farmers work smarter, not harder. Our equipment solutions are selected for Philippine farming conditions and crop types.
                    </p>
                    <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <li class="flex items-center gap-3 text-gray-700">
                            <span class="w-6 h-6 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            Precision sprayers
                        </li>
                        <li class="flex items-center gap-3 text-gray-700">
                            <span class="w-6 h-6 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            Soil testing kits
                        </li>
                        <li class="flex items-center gap-3 text-gray-700">
                            <span class="w-6 h-6 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            Monitoring devices
                        </li>
                        <li class="flex items-center gap-3 text-gray-700">
                            <span class="w-6 h-6 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            Irrigation systems
                        </li>
                    </ul>
                    <span class="inline-flex items-center gap-2 bg-gray-200 text-gray-500 px-6 py-3 rounded-full font-semibold mt-6 cursor-not-allowed">
                        Coming Soon
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </span>
                </div>
            </div>

            <!-- Pillar 5: R&D - Image Left -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-center transition-all duration-700"
                 x-data="{ itemShown: false }" x-intersect:enter.once="itemShown = true"
                 :class="itemShown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'">
                <div class="relative rounded-2xl overflow-hidden shadow-xl group">
                    <img src="https://images.unsplash.com/photo-1582719471384-894fbb16e074?w=800&h=600&fit=crop" alt="Research & Development" class="w-full h-64 lg:h-96 object-cover transition-transform duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                    <div class="absolute top-4 left-4">
                        <span class="bg-purple-500 text-white text-xs font-bold px-4 py-2 rounded-full">05 - R&D</span>
                    </div>
                </div>
                <div>
                    <h3 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-4" style="font-family: 'Instrument Sans', sans-serif;">Research & Development</h3>
                    <p class="text-gray-600 text-lg mb-6 leading-relaxed">
                        Continuous scientific research and field experiments to develop better solutions for Filipino farmers. Our R&D team works tirelessly to stay ahead of agricultural challenges and opportunities.
                    </p>
                    <p class="text-gray-500 mb-6">
                        We partner with universities, agricultural institutions, and international research bodies to bring cutting-edge innovations to Philippine agriculture. Every product and recommendation is backed by rigorous scientific testing.
                    </p>
                    <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <li class="flex items-center gap-3 text-gray-700">
                            <span class="w-6 h-6 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            Field trials
                        </li>
                        <li class="flex items-center gap-3 text-gray-700">
                            <span class="w-6 h-6 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            Product development
                        </li>
                        <li class="flex items-center gap-3 text-gray-700">
                            <span class="w-6 h-6 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            Scientific partnerships
                        </li>
                        <li class="flex items-center gap-3 text-gray-700">
                            <span class="w-6 h-6 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            Innovation labs
                        </li>
                    </ul>
                    <span class="inline-flex items-center gap-2 bg-gray-200 text-gray-500 px-6 py-3 rounded-full font-semibold mt-6 cursor-not-allowed">
                        Coming Soon
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </span>
                </div>
            </div>

            <!-- Pillar 6: Community - Image Right -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-center transition-all duration-700"
                 x-data="{ itemShown: false }" x-intersect:enter.once="itemShown = true"
                 :class="itemShown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'">
                <div class="order-1 lg:order-2 relative rounded-2xl overflow-hidden shadow-xl group">
                    <img src="https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8?w=800&h=600&fit=crop" alt="Community & Support" class="w-full h-64 lg:h-96 object-cover transition-transform duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                    <div class="absolute top-4 left-4">
                        <span class="bg-pink-500 text-white text-xs font-bold px-4 py-2 rounded-full">06 - Community</span>
                    </div>
                </div>
                <div class="order-2 lg:order-1">
                    <h3 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-4" style="font-family: 'Instrument Sans', sans-serif;">Community & Support</h3>
                    <p class="text-gray-600 text-lg mb-6 leading-relaxed">
                        A supportive network of farmers, experts, and agricultural technicians ready to help you succeed. Farming doesn't have to be a solitary journey—our community is here to support you every step of the way.
                    </p>
                    <p class="text-gray-500 mb-6">
                        Connect with fellow farmers, share experiences, ask questions, and learn from each other. Our expert team provides personalized guidance and troubleshooting to ensure you never face challenges alone.
                    </p>
                    <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <li class="flex items-center gap-3 text-gray-700">
                            <span class="w-6 h-6 bg-pink-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            Farmer networks
                        </li>
                        <li class="flex items-center gap-3 text-gray-700">
                            <span class="w-6 h-6 bg-pink-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            Expert consultations
                        </li>
                        <li class="flex items-center gap-3 text-gray-700">
                            <span class="w-6 h-6 bg-pink-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            24/7 support
                        </li>
                        <li class="flex items-center gap-3 text-gray-700">
                            <span class="w-6 h-6 bg-pink-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            Regional meetups
                        </li>
                    </ul>
                    <a href="{{ route('community.join') }}" class="group inline-flex items-center gap-2 bg-pink-500 text-white px-6 py-3 rounded-full font-semibold mt-6 hover:bg-pink-600 transition-all">
                        Join the Community
                        <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Impact Section -->
<section id="impact" class="relative overflow-hidden" x-data="{ shown: false }" x-intersect:enter.once="shown = true">
    <!-- Top: Full-width image with stats overlay -->
    <div class="relative h-[500px] lg:h-[600px]">
        <img src="https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=1920&h=1080&fit=crop&q=80" alt="Successful harvest" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/70 to-gray-900/40"></div>

        <!-- Floating Stats -->
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="text-center mb-12">
                    <div class="inline-flex items-center gap-2 bg-brand-yellow/20 backdrop-blur-sm text-brand-yellow px-4 py-2 rounded-full mb-6 border border-brand-yellow/30 transition-all duration-500"
                         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        <span class="text-sm font-semibold uppercase tracking-wide">Proven Results</span>
                    </div>

                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4 transition-all duration-500 delay-100" style="font-family: 'Instrument Sans', sans-serif;"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                        What We Help <span class="text-brand-yellow">Achieve</span>
                    </h2>

                    <p class="text-lg text-white/70 max-w-2xl mx-auto transition-all duration-500 delay-200"
                       :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                        Real outcomes from real farmers using the AniSenso ecosystem
                    </p>
                </div>

                <!-- Big Stats Grid -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 text-center transition-all duration-500 hover:bg-white/20 hover:scale-105"
                         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
                         :style="shown ? 'transition-delay: 200ms' : ''">
                        <div class="text-4xl md:text-5xl lg:text-6xl font-bold text-brand-yellow mb-2">50%</div>
                        <div class="text-white font-semibold mb-1">Higher Yields</div>
                        <div class="text-white/50 text-sm">Average increase</div>
                    </div>

                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 text-center transition-all duration-500 hover:bg-white/20 hover:scale-105"
                         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
                         :style="shown ? 'transition-delay: 300ms' : ''">
                        <div class="text-4xl md:text-5xl lg:text-6xl font-bold text-brand-green mb-2">30%</div>
                        <div class="text-white font-semibold mb-1">Cost Reduction</div>
                        <div class="text-white/50 text-sm">Input savings</div>
                    </div>

                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 text-center transition-all duration-500 hover:bg-white/20 hover:scale-105"
                         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
                         :style="shown ? 'transition-delay: 400ms' : ''">
                        <div class="text-4xl md:text-5xl lg:text-6xl font-bold text-blue-400 mb-2">2x</div>
                        <div class="text-white font-semibold mb-1">Faster Growth</div>
                        <div class="text-white/50 text-sm">Root development</div>
                    </div>

                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 text-center transition-all duration-500 hover:bg-white/20 hover:scale-105"
                         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
                         :style="shown ? 'transition-delay: 500ms' : ''">
                        <div class="text-4xl md:text-5xl lg:text-6xl font-bold text-purple-400 mb-2">95%</div>
                        <div class="text-white font-semibold mb-1">Satisfaction</div>
                        <div class="text-white/50 text-sm">Farmer rating</div>
                    </div>
                </div>

                <!-- CTA below stats -->
                <div class="mt-10 text-center transition-all duration-500 delay-500"
                     :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                    <a href="{{ route('community.join') }}" class="group inline-flex items-center gap-3 bg-brand-yellow text-brand-dark px-8 py-4 rounded-full font-bold text-lg hover:bg-brand-yellow-hover transition-all shadow-lg hover:shadow-xl hover:scale-105">
                        Join the Community
                        <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                    <p class="text-white/50 text-sm mt-3">Start your journey to better farming today</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom: Detailed Benefits - Alternating Layout -->
    <div class="bg-gray-900 py-16 lg:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16" x-data="{ headShown: false }" x-intersect:enter.once="headShown = true">
                <h3 class="text-2xl lg:text-3xl font-bold text-white mb-4 transition-all duration-500" style="font-family: 'Instrument Sans', sans-serif;"
                    :class="headShown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                    Transforming Farms Across the Philippines
                </h3>
                <p class="text-white/60 max-w-2xl mx-auto transition-all duration-500 delay-100"
                   :class="headShown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                    Our comprehensive approach delivers real, measurable improvements to farming operations of all sizes.
                </p>
            </div>

            <div class="space-y-16 lg:space-y-24">
                <!-- Benefit 1: Maximize Harvest - Image Left -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-center transition-all duration-700"
                     x-data="{ itemShown: false }" x-intersect:enter.once="itemShown = true"
                     :class="itemShown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'">
                    <div class="relative rounded-2xl overflow-hidden shadow-xl group">
                        <img src="https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=800&h=600&fit=crop" alt="Abundant harvest" class="w-full h-64 lg:h-96 object-cover transition-transform duration-700 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                        <div class="absolute top-4 left-4">
                            <span class="bg-brand-green text-white text-xs font-bold px-4 py-2 rounded-full">+50% Average Yield</span>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 bg-brand-green/20 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            </div>
                            <h4 class="text-2xl lg:text-3xl font-bold text-white" style="font-family: 'Instrument Sans', sans-serif;">Maximize Your Harvest</h4>
                        </div>
                        <p class="text-white/70 text-lg mb-6 leading-relaxed">
                            Scientifically-proven techniques and premium inputs push your crops to their full genetic potential. Our farmers consistently report significant yield improvements within just one growing season.
                        </p>
                        <p class="text-white/50 mb-6">
                            Through proper soil nutrition, optimized planting schedules, and advanced micronutrient formulations like Rhizocote, we help your plants develop stronger root systems that translate directly into bigger, healthier harvests.
                        </p>
                        <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-6">
                            <li class="flex items-center gap-3 text-white/70">
                                <span class="w-6 h-6 bg-brand-green/20 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </span>
                                Optimized nutrient delivery
                            </li>
                            <li class="flex items-center gap-3 text-white/70">
                                <span class="w-6 h-6 bg-brand-green/20 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </span>
                                Stronger root systems
                            </li>
                            <li class="flex items-center gap-3 text-white/70">
                                <span class="w-6 h-6 bg-brand-green/20 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </span>
                                Disease resistance
                            </li>
                            <li class="flex items-center gap-3 text-white/70">
                                <span class="w-6 h-6 bg-brand-green/20 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </span>
                                Better crop quality
                            </li>
                        </ul>
                        <a href="{{ route('community.join') }}" class="group inline-flex items-center gap-2 bg-brand-green text-white px-6 py-3 rounded-full font-semibold hover:bg-brand-green/90 transition-all">
                            Join the Community
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Benefit 2: Secure Investment - Image Right -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-center transition-all duration-700"
                     x-data="{ itemShown: false }" x-intersect:enter.once="itemShown = true"
                     :class="itemShown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'">
                    <div class="order-1 lg:order-2 relative rounded-2xl overflow-hidden shadow-xl group">
                        <img src="https://images.unsplash.com/photo-1579621970563-ebec7560ff3e?w=800&h=600&fit=crop" alt="Financial security" class="w-full h-64 lg:h-96 object-cover transition-transform duration-700 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                        <div class="absolute top-4 left-4">
                            <span class="bg-brand-yellow text-brand-dark text-xs font-bold px-4 py-2 rounded-full">Predictable ROI</span>
                        </div>
                    </div>
                    <div class="order-2 lg:order-1">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 bg-brand-yellow/20 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-brand-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <h4 class="text-2xl lg:text-3xl font-bold text-white" style="font-family: 'Instrument Sans', sans-serif;">Secure Your Investment</h4>
                        </div>
                        <p class="text-white/70 text-lg mb-6 leading-relaxed">
                            Reduce uncertainty with data-driven farming decisions. Know exactly when to plant, what to apply, and when to harvest for maximum financial returns on every peso invested.
                        </p>
                        <p class="text-white/50 mb-6">
                            Our proven protocols eliminate the guesswork that leads to wasted inputs and missed opportunities. With AniSenso, you'll have the confidence that comes from using tested, validated methods that have worked for thousands of Filipino farmers.
                        </p>
                        <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-6">
                            <li class="flex items-center gap-3 text-white/70">
                                <span class="w-6 h-6 bg-brand-yellow/20 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-brand-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </span>
                                30% lower input costs
                            </li>
                            <li class="flex items-center gap-3 text-white/70">
                                <span class="w-6 h-6 bg-brand-yellow/20 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-brand-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </span>
                                Proven protocols
                            </li>
                            <li class="flex items-center gap-3 text-white/70">
                                <span class="w-6 h-6 bg-brand-yellow/20 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-brand-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </span>
                                Better market timing
                            </li>
                            <li class="flex items-center gap-3 text-white/70">
                                <span class="w-6 h-6 bg-brand-yellow/20 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-brand-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </span>
                                Risk mitigation
                            </li>
                        </ul>
                        <a href="{{ route('community.join') }}" class="group inline-flex items-center gap-2 bg-brand-yellow text-brand-dark px-6 py-3 rounded-full font-semibold hover:bg-brand-yellow-hover transition-all">
                            Join the Community
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Benefit 3: Save Time & Resources - Image Left -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-center transition-all duration-700"
                     x-data="{ itemShown: false }" x-intersect:enter.once="itemShown = true"
                     :class="itemShown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'">
                    <div class="relative rounded-2xl overflow-hidden shadow-xl group">
                        <img src="https://images.unsplash.com/photo-1530836369250-ef72a3f5cda8?w=800&h=600&fit=crop" alt="Efficient farming" class="w-full h-64 lg:h-96 object-cover transition-transform duration-700 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                        <div class="absolute top-4 left-4">
                            <span class="bg-blue-500 text-white text-xs font-bold px-4 py-2 rounded-full">Work Smarter</span>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <h4 class="text-2xl lg:text-3xl font-bold text-white" style="font-family: 'Instrument Sans', sans-serif;">Save Time & Resources</h4>
                        </div>
                        <p class="text-white/70 text-lg mb-6 leading-relaxed">
                            Smart scheduling and optimized application methods mean less wasted inputs, reduced labor requirements, and more time for what matters most to you and your family.
                        </p>
                        <p class="text-white/50 mb-6">
                            Our AI-powered tools help you plan your activities efficiently, sending reminders for critical tasks and ensuring you never miss the optimal window for planting, fertilizing, or harvesting. Work smarter, not harder.
                        </p>
                        <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-6">
                            <li class="flex items-center gap-3 text-white/70">
                                <span class="w-6 h-6 bg-blue-500/20 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </span>
                                Automated scheduling
                            </li>
                            <li class="flex items-center gap-3 text-white/70">
                                <span class="w-6 h-6 bg-blue-500/20 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </span>
                                Zero product waste
                            </li>
                            <li class="flex items-center gap-3 text-white/70">
                                <span class="w-6 h-6 bg-blue-500/20 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </span>
                                Reduced manual labor
                            </li>
                            <li class="flex items-center gap-3 text-white/70">
                                <span class="w-6 h-6 bg-blue-500/20 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </span>
                                Smart reminders
                            </li>
                        </ul>
                        <a href="{{ route('community.join') }}" class="group inline-flex items-center gap-2 bg-blue-500 text-white px-6 py-3 rounded-full font-semibold hover:bg-blue-600 transition-all">
                            Join the Community
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Benefit 4: Grow Knowledge - Image Right -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-center transition-all duration-700"
                     x-data="{ itemShown: false }" x-intersect:enter.once="itemShown = true"
                     :class="itemShown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'">
                    <div class="order-1 lg:order-2 relative rounded-2xl overflow-hidden shadow-xl group">
                        <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=800&h=600&fit=crop" alt="Learning and education" class="w-full h-64 lg:h-96 object-cover transition-transform duration-700 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                        <div class="absolute top-4 left-4">
                            <span class="bg-purple-500 text-white text-xs font-bold px-4 py-2 rounded-full">Lifetime Access</span>
                        </div>
                    </div>
                    <div class="order-2 lg:order-1">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 bg-purple-500/20 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                            </div>
                            <h4 class="text-2xl lg:text-3xl font-bold text-white" style="font-family: 'Instrument Sans', sans-serif;">Grow Your Knowledge</h4>
                        </div>
                        <p class="text-white/70 text-lg mb-6 leading-relaxed">
                            Access expert-led courses, real-time support from agricultural specialists, and a thriving community of farmers sharing their insights and experiences from across the Philippines.
                        </p>
                        <p class="text-white/50 mb-6">
                            Knowledge is power in farming. Our comprehensive education platform covers everything from soil science to market strategies, delivered in Tagalog and regional dialects so every farmer can learn effectively.
                        </p>
                        <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-6">
                            <li class="flex items-center gap-3 text-white/70">
                                <span class="w-6 h-6 bg-purple-500/20 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </span>
                                Expert video courses
                            </li>
                            <li class="flex items-center gap-3 text-white/70">
                                <span class="w-6 h-6 bg-purple-500/20 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </span>
                                24/7 tech support
                            </li>
                            <li class="flex items-center gap-3 text-white/70">
                                <span class="w-6 h-6 bg-purple-500/20 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </span>
                                10,000+ farmer network
                            </li>
                            <li class="flex items-center gap-3 text-white/70">
                                <span class="w-6 h-6 bg-purple-500/20 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </span>
                                Regional language support
                            </li>
                        </ul>
                        <a href="{{ route('community.join') }}" class="group inline-flex items-center gap-2 bg-purple-500 text-white px-6 py-3 rounded-full font-semibold hover:bg-purple-600 transition-all">
                            Join the Community
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="relative py-24 overflow-hidden" x-data="{ shown: false }" x-intersect:enter.once="shown = true">
    <!-- Background Image -->
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=1920&h=800&fit=crop&q=80" alt="Farm landscape" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-brand-dark via-brand-dark/95 to-brand-dark/90"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left: Content -->
            <div>
                <div class="inline-flex items-center gap-2 bg-brand-yellow/20 backdrop-blur-sm text-brand-yellow px-4 py-2 rounded-full mb-6 border border-brand-yellow/30 transition-all duration-500"
                     :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span class="text-sm font-semibold uppercase tracking-wide">Join 10,000+ Farmers</span>
                </div>

                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-6 leading-tight transition-all duration-500 delay-100" style="font-family: 'Instrument Sans', sans-serif;"
                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                    Ready to Transform <span class="text-brand-yellow">Your Farm?</span>
                </h2>

                <p class="text-xl text-white/70 mb-8 leading-relaxed transition-all duration-500 delay-200"
                   :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                    Join the AniSenso community today and get free access to education, tools, products, and expert support that will help you achieve your farming goals.
                </p>

                <a href="{{ route('community.join') }}" class="group inline-flex items-center justify-center gap-3 bg-brand-yellow text-brand-dark px-8 py-4 rounded-full font-bold text-lg hover:bg-brand-yellow-hover transition-all shadow-lg shadow-brand-yellow/30 transition-all duration-500 delay-300"
                   :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                    Join the Community
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>

            <!-- Right: Benefits Cards -->
            <div class="grid grid-cols-2 gap-4 transition-all duration-500 delay-300"
                 :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-12'">
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-5 border border-white/10">
                    <div class="w-12 h-12 bg-brand-green/20 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <h4 class="text-white font-bold mb-1">Free Courses</h4>
                    <p class="text-white/60 text-sm">Expert-led training in Filipino</p>
                </div>

                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-5 border border-white/10">
                    <div class="w-12 h-12 bg-brand-yellow/20 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-brand-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                    </div>
                    <h4 class="text-white font-bold mb-1">Smart Tools</h4>
                    <p class="text-white/60 text-sm">AI-powered farming assistant</p>
                </div>

                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-5 border border-white/10">
                    <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/></svg>
                    </div>
                    <h4 class="text-white font-bold mb-1">24/7 Support</h4>
                    <p class="text-white/60 text-sm">Expert help when you need it</p>
                </div>

                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-5 border border-white/10">
                    <div class="w-12 h-12 bg-purple-500/20 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <h4 class="text-white font-bold mb-1">Community</h4>
                    <p class="text-white/60 text-sm">Connect with fellow farmers</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
