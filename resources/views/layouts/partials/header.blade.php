@php $btcUrl = rtrim(config('app.btc_check_url'), '/'); @endphp
<header class="absolute top-0 left-0 right-0 z-50 bg-black/40 backdrop-blur-sm border-b border-white/10" x-data="{ mobileMenuOpen: false, searchOpen: false }" style="font-family: 'Instrument Sans', sans-serif;">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between" style="height: 90px;">

            <!-- Logo -->
            <a href="{{ url('/') }}" class="flex-shrink-0">
                <img src="{{ $btcUrl }}/wp-content/uploads/2025/12/test-logo-big-2-scaled.png" alt="AniSenso" class="h-12 md:h-14 w-auto">
            </a>

            <!-- Desktop Navigation - Centered -->
            <nav class="hidden lg:flex items-center space-x-6 xl:space-x-8">
                <a href="{{ url('/') }}" class="text-white hover:text-brand-green-light transition-colors font-bold text-base capitalize {{ request()->is('/') ? 'text-brand-green-light' : '' }}">
                    Home
                </a>
                <a href="{{ url('/about') }}" class="text-white hover:text-brand-green-light transition-colors font-bold text-base capitalize {{ request()->is('about') ? 'text-brand-green-light' : '' }}">
                    About
                </a>
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false" class="flex items-center gap-1 text-white hover:text-brand-green-light transition-colors font-bold text-base capitalize">
                        Ecosystem
                        <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-cloak class="absolute top-full left-0 mt-2 w-56 bg-white rounded-lg shadow-xl py-2">
                        <a href="{{ route('tech.rhizocote') }}" class="block px-4 py-2 text-gray-800 hover:bg-brand-green hover:text-white transition-colors text-sm">Rhizocote</a>
                        <span class="block px-4 py-2 text-gray-400 text-sm cursor-not-allowed">Technology <span class="text-xs">(Coming Soon)</span></span>
                        <span class="block px-4 py-2 text-gray-400 text-sm cursor-not-allowed">Biostimulants <span class="text-xs">(Coming Soon)</span></span>
                        <span class="block px-4 py-2 text-gray-400 text-sm cursor-not-allowed">Equipments <span class="text-xs">(Coming Soon)</span></span>
                        <span class="block px-4 py-2 text-gray-400 text-sm cursor-not-allowed">Vita Crop <span class="text-xs">(Coming Soon)</span></span>
                    </div>
                </div>
                <a href="{{ url('/blog') }}" class="text-white hover:text-brand-green-light transition-colors font-bold text-base capitalize {{ request()->is('blog*') ? 'text-brand-green-light' : '' }}">
                    Blog
                </a>
                <span class="text-gray-400 font-bold text-base cursor-not-allowed">
                    Shop <span class="text-xs font-normal">(Members Only)</span>
                </span>
            </nav>

            <!-- Right Section -->
            <div class="flex items-center gap-3">
                <!-- Search -->
                <div class="hidden md:flex items-center relative">
                    <button @click="searchOpen = !searchOpen" class="text-white hover:text-brand-green-light transition-colors p-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                    <!-- Search Box -->
                    <div x-show="searchOpen" x-cloak @click.away="searchOpen = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute top-full right-0 mt-2 w-72 bg-white rounded-lg shadow-xl p-3">
                        <input type="text" placeholder="Search..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-green focus:border-transparent text-gray-800">
                    </div>
                </div>

                <!-- CTA Buttons -->
                @auth('client')
                    <a href="{{ route('dashboard') }}" class="hidden md:inline-flex items-center gap-2 bg-brand-yellow text-brand-dark px-5 py-2.5 rounded-md font-semibold text-sm hover:bg-brand-yellow-hover transition-colors">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="hidden md:inline-flex items-center gap-2 border-2 border-brand-yellow text-brand-yellow px-5 py-2 rounded-md font-semibold text-sm hover:bg-brand-yellow hover:text-brand-dark transition-colors">
                        Member Login
                    </a>
                    <a href="{{ route('community.join') }}" class="group hidden md:inline-flex items-center gap-2 bg-brand-yellow text-brand-dark px-5 py-2.5 rounded-md font-semibold text-sm hover:bg-brand-yellow-hover transition-colors">
                        Join the Community
                        <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                @endauth

                <!-- Mobile Menu Button -->
                <button
                    @click="mobileMenuOpen = !mobileMenuOpen"
                    class="lg:hidden p-2 text-white hover:text-brand-yellow transition-colors"
                >
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div
            x-show="mobileMenuOpen"
            x-cloak
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="lg:hidden py-4 bg-brand-dark/95 backdrop-blur-sm rounded-lg mt-2"
        >
            <nav class="flex flex-col space-y-1 px-2">
                <a href="{{ url('/') }}" class="px-4 py-3 text-white hover:bg-brand-yellow hover:text-brand-dark rounded-lg transition-colors font-medium">Home</a>
                <a href="{{ url('/about') }}" class="px-4 py-3 text-white hover:bg-brand-yellow hover:text-brand-dark rounded-lg transition-colors font-medium">About</a>
                <!-- Tech with sub-items -->
                <div x-data="{ techOpen: false }">
                    <button @click="techOpen = !techOpen" class="w-full px-4 py-3 text-white hover:bg-brand-yellow hover:text-brand-dark rounded-lg transition-colors font-medium flex items-center justify-between">
                        Ecosystem
                        <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': techOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="techOpen" x-cloak class="pl-4 mt-1 space-y-1">
                        <a href="{{ route('tech.rhizocote') }}" class="block px-4 py-2 text-white/80 hover:bg-brand-yellow hover:text-brand-dark rounded-lg transition-colors text-sm">Rhizocote</a>
                        <span class="block px-4 py-2 text-gray-500 text-sm cursor-not-allowed">Technology <span class="text-xs">(Coming Soon)</span></span>
                        <span class="block px-4 py-2 text-gray-500 text-sm cursor-not-allowed">Biostimulants <span class="text-xs">(Coming Soon)</span></span>
                        <span class="block px-4 py-2 text-gray-500 text-sm cursor-not-allowed">Equipments <span class="text-xs">(Coming Soon)</span></span>
                        <span class="block px-4 py-2 text-gray-500 text-sm cursor-not-allowed">Vita Crop <span class="text-xs">(Coming Soon)</span></span>
                    </div>
                </div>
                <a href="{{ url('/blog') }}" class="px-4 py-3 text-white hover:bg-brand-yellow hover:text-brand-dark rounded-lg transition-colors font-medium {{ request()->is('blog*') ? 'bg-brand-yellow text-brand-dark' : '' }}">Blog</a>
                <span class="px-4 py-3 text-gray-500 rounded-lg font-medium cursor-not-allowed">Shop <span class="text-xs">(Members Only)</span></span>
            </nav>
            <!-- Mobile Search -->
            <div class="px-4 mt-3">
                <input type="text" placeholder="Search..." class="w-full px-4 py-2 border border-gray-600 bg-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-yellow text-white placeholder-gray-400">
            </div>
            <div class="mt-4 pt-4 border-t border-gray-700 px-4 space-y-3">
                @auth('client')
                    <a href="{{ route('dashboard') }}" class="flex items-center justify-center gap-2 bg-brand-yellow text-brand-dark px-5 py-3 rounded-full font-semibold">
                        Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="mt-2">
                        @csrf
                        <button type="submit" class="w-full text-center py-2 text-gray-400 hover:text-white transition-colors">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 border-2 border-brand-yellow text-brand-yellow px-5 py-3 rounded-full font-semibold">
                        Member Login
                    </a>
                    <a href="{{ route('community.join') }}" class="group flex items-center justify-center gap-2 bg-brand-yellow text-brand-dark px-5 py-3 rounded-full font-semibold">
                        Join the Community
                        <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>
