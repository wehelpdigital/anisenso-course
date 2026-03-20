@extends('layouts.app')

@section('title', 'Blog - AniSenso Academy')

@push('styles')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .anim-fade-in-up { animation: fadeInUp 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards; }
    .anim-fade-in-down { animation: fadeInDown 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards; }
    .anim-delay-100 { animation-delay: 0.1s; }
    .anim-delay-200 { animation-delay: 0.2s; }
    .anim-delay-300 { animation-delay: 0.3s; }
    [class*="anim-"]:not(.anim-active) { opacity: 0; }

    .blog-card { transition: all 0.3s ease; }
    .blog-card:hover { transform: translateY(-8px); }
    .blog-card:hover .blog-image img { transform: scale(1.05); }
    .blog-image { overflow: hidden; }
    .blog-image img { transition: transform 0.5s ease; }
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="relative min-h-[50vh] flex items-center overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1500937386664-56d1dfef3854?w=1920&h=800&fit=crop" alt="" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-brand-dark via-brand-dark/90 to-brand-dark/70"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-brand-dark via-transparent to-transparent"></div>
    </div>

    <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-brand-yellow/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-1/4 left-1/4 w-64 h-64 bg-brand-green/10 rounded-full blur-3xl"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-16 w-full">
        <nav class="flex justify-end mb-8 anim-fade-in-down anim-delay-100">
            <ol class="flex items-center gap-2 text-sm bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full">
                <li><a href="{{ url('/') }}" class="text-white/70 hover:text-white transition-colors">Home</a></li>
                <li class="text-white/30"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
                <li><span class="text-brand-yellow font-medium">Blog</span></li>
            </ol>
        </nav>

        <div class="text-center max-w-4xl mx-auto">
            <div class="inline-flex items-center gap-2 bg-brand-yellow/20 backdrop-blur-sm text-brand-yellow px-5 py-2.5 rounded-full mb-8 border border-brand-yellow/30 anim-fade-in-up anim-delay-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                <span class="text-sm font-semibold uppercase tracking-wide">News & Updates</span>
            </div>

            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight anim-fade-in-up anim-delay-200" style="font-family: 'Instrument Sans', sans-serif;">
                AniSenso <span class="text-brand-yellow">Blog</span>
            </h1>

            <p class="text-xl text-white/80 max-w-2xl mx-auto leading-relaxed anim-fade-in-up anim-delay-300">
                Stay updated with the latest agricultural insights, farming tips, success stories, and news from the AniSenso community.
            </p>
        </div>
    </div>
</section>

<!-- Featured Post Section -->
@if($featuredPosts->count() > 0)
<section class="py-16 bg-white" x-data="{ shown: false }" x-intersect:enter.once="shown = true">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-16">
            <div class="flex items-center gap-2 text-brand-green text-sm font-semibold uppercase tracking-wide mb-8 transition-all duration-500"
                 :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                <span>Featured Article</span>
            </div>

            @php $featured = $featuredPosts->first(); @endphp
            <a href="{{ route('blog.show', $featured->blogSlug) }}" class="group block transition-all duration-700 delay-100"
               :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center bg-gray-50 rounded-3xl overflow-hidden">
                    @php
                        $btcCheckUrl = rtrim(config('app.btc_check_url'), '/');
                        $placeholderImages = [
                            'https://images.unsplash.com/photo-1500937386664-56d1dfef3854?w=800&h=600&fit=crop',
                            'https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=800&h=600&fit=crop',
                            'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=800&h=600&fit=crop',
                        ];
                        $featuredImage = $featured->blogFeaturedImage
                            ? $btcCheckUrl . '/' . ltrim($featured->blogFeaturedImage, '/')
                            : $placeholderImages[0];
                    @endphp
                    <div class="blog-image aspect-[4/3] lg:aspect-auto lg:h-[400px]">
                        <img src="{{ $featuredImage }}" alt="{{ $featured->blogTitle }}" class="w-full h-full object-cover">
                    </div>
                    <div class="p-8 lg:pr-12">
                        <div class="mb-4">
                            <span class="@if($featured->blogCategoryColor === 'brand-green') bg-brand-green/10 text-brand-green @elseif($featured->blogCategoryColor === 'brand-yellow') bg-brand-yellow/20 text-brand-dark @elseif($featured->blogCategoryColor === 'blue') bg-blue-100 text-blue-700 @else bg-gray-100 text-gray-700 @endif px-3 py-1 rounded-full text-sm font-medium">{{ $featured->blogCategory }}</span>
                        </div>
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4 group-hover:text-brand-green transition-colors" style="font-family: 'Instrument Sans', sans-serif;">
                            {{ $featured->blogTitle }}
                        </h2>
                        <p class="text-gray-600 text-lg leading-relaxed line-clamp-3">
                            {{ $featured->blogExcerpt }}
                        </p>
                        @if($featured->publishedAt)
                        <p class="text-gray-400 text-sm mt-4">{{ \Carbon\Carbon::parse($featured->publishedAt)->format('M j, Y') }}</p>
                        @endif
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>
@endif

<!-- Blog Grid Section -->
<section class="py-16 bg-gray-100" x-data="{ shown: false, category: '{{ request('category', 'all') }}' }" x-intersect:enter.once="shown = true">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-12">
            <div class="transition-all duration-500" :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-8'">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900" style="font-family: 'Instrument Sans', sans-serif;">
                    Latest Articles
                </h2>
                <p class="text-gray-600 mt-2">Expert insights and farming knowledge</p>
            </div>
            <!-- Category Filter -->
            <div class="flex flex-wrap gap-2 transition-all duration-500 delay-100" :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-8'">
                <a href="{{ route('blog.index') }}" class="px-4 py-2 {{ !request('category') || request('category') === 'all' ? 'bg-brand-green text-white' : 'bg-white text-gray-700 hover:bg-brand-green hover:text-white' }} rounded-full text-sm font-medium transition-colors">All</a>
                @foreach($categories as $categoryName => $color)
                <a href="{{ route('blog.index', ['category' => $categoryName]) }}" class="px-4 py-2 {{ request('category') === $categoryName ? 'bg-brand-green text-white' : 'bg-white text-gray-700 hover:bg-brand-green hover:text-white' }} rounded-full text-sm font-medium transition-colors">{{ $categoryName }}</a>
                @endforeach
            </div>
        </div>

        @if($posts->count() > 0)
        <!-- Blog Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
                $btcUrl = rtrim(config('app.btc_check_url'), '/');
                $placeholders = [
                    'https://images.unsplash.com/photo-1500937386664-56d1dfef3854?w=600&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=600&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=600&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1592982537447-6e2bd1b5d0f2?w=600&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=600&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1523348837708-15d4a09cfac2?w=600&h=400&fit=crop',
                ];
            @endphp
            @foreach($posts as $index => $post)
            @php
                $postImage = $post->blogFeaturedImage
                    ? $btcUrl . '/' . ltrim($post->blogFeaturedImage, '/')
                    : $placeholders[$index % count($placeholders)];
            @endphp
            <a href="{{ route('blog.show', $post->blogSlug) }}"
               class="blog-card bg-white rounded-2xl shadow-sm overflow-hidden transition-all duration-500"
               :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
               :style="shown ? 'transition-delay: {{ ($index % 6 + 1) * 100 }}ms' : ''">
                <div class="blog-image aspect-[16/10]">
                    <img src="{{ $postImage }}" alt="{{ $post->blogTitle }}" class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <div class="mb-3">
                        <span class="@if($post->blogCategoryColor === 'brand-green') bg-brand-green/10 text-brand-green @elseif($post->blogCategoryColor === 'brand-yellow') bg-brand-yellow/20 text-brand-dark @elseif($post->blogCategoryColor === 'blue') bg-blue-100 text-blue-700 @else bg-gray-100 text-gray-700 @endif px-3 py-1 rounded-full text-xs font-medium">{{ $post->blogCategory }}</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 hover:text-brand-green transition-colors">
                        {{ $post->blogTitle }}
                    </h3>
                    <p class="text-gray-600 text-sm leading-relaxed line-clamp-3 mb-4">
                        {{ $post->blogExcerpt }}
                    </p>
                    <div class="pt-4 border-t border-gray-100 flex justify-between items-center">
                        <span class="text-brand-green text-sm font-medium">Read More</span>
                        @if($post->publishedAt)
                        <span class="text-gray-400 text-xs">{{ \Carbon\Carbon::parse($post->publishedAt)->format('M j, Y') }}</span>
                        @endif
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
        <div class="flex justify-center mt-12 transition-all duration-500 delay-700"
             :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            {{ $posts->links() }}
        </div>
        @endif
        @else
        <!-- No Posts Message -->
        <div class="text-center py-16">
            <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">No blog posts yet</h3>
            <p class="text-gray-500">Check back soon for new articles and updates!</p>
        </div>
        @endif
    </div>
</section>

<!-- Join Community CTA -->
<section class="py-20 bg-brand-dark relative overflow-hidden" x-data="{ shown: false }" x-intersect:enter.once="shown = true">
    <div class="absolute top-0 right-0 w-96 h-96 bg-brand-yellow/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-brand-green/10 rounded-full blur-3xl"></div>

    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center gap-2 bg-brand-yellow/20 text-brand-yellow px-5 py-2.5 rounded-full mb-8 border border-brand-yellow/30 transition-all duration-500"
             :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            <span class="text-sm font-semibold uppercase tracking-wide">Join Our Community</span>
        </div>

        <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-6 transition-all duration-500 delay-100" style="font-family: 'Instrument Sans', sans-serif;"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            Be Part of the <span class="text-brand-yellow">AniSenso Family</span>
        </h2>

        <p class="text-xl text-white/70 mb-10 max-w-2xl mx-auto transition-all duration-500 delay-200"
           :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            Join thousands of Filipino farmers who are transforming their farms with modern techniques.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center transition-all duration-500 delay-300"
             :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <a href="{{ route('community.join') }}" class="group inline-flex items-center justify-center gap-2 bg-brand-yellow text-brand-dark px-8 py-4 rounded-full font-bold hover:bg-brand-yellow-hover transition-all shadow-lg shadow-brand-yellow/30">
                Join the Community
                <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
            <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 border-2 border-white/30 text-white px-8 py-4 rounded-full font-bold hover:bg-white/10 transition-all">
                Member Login
            </a>
        </div>
    </div>
</section>
@endsection
