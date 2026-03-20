@extends('layouts.app')

@section('title', $post->blogTitle . ' - AniSenso Blog')

@push('styles')
<style>
    /* Animation Keyframes */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes scaleIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
    @keyframes slideIn {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .anim-fade-in-up { animation: fadeInUp 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards; }
    .anim-fade-in-down { animation: fadeInDown 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards; }
    .anim-fade-in { animation: fadeIn 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards; }
    .anim-scale-in { animation: scaleIn 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards; }
    .anim-slide-in { animation: slideIn 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards; }
    .anim-delay-100 { animation-delay: 0.1s; }
    .anim-delay-200 { animation-delay: 0.2s; }
    .anim-delay-300 { animation-delay: 0.3s; }
    .anim-delay-400 { animation-delay: 0.4s; }

    [class*="anim-"]:not(.anim-active) { opacity: 0; }

    .blog-content {
        font-size: 1.125rem;
        line-height: 1.8;
        color: #374151;
    }
    .blog-content p {
        margin-bottom: 1.5rem;
    }
    .blog-content p.lead {
        font-size: 1.25rem;
        color: #1f2937;
        font-weight: 500;
        line-height: 1.7;
    }
    .blog-content h2 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #111827;
        margin-top: 2.5rem;
        margin-bottom: 1rem;
        font-family: 'Instrument Sans', sans-serif;
    }
    .blog-content h3 {
        font-size: 1.375rem;
        font-weight: 600;
        color: #1f2937;
        margin-top: 2rem;
        margin-bottom: 0.75rem;
        font-family: 'Instrument Sans', sans-serif;
    }
    .blog-content ul, .blog-content ol {
        margin-bottom: 1.5rem;
        padding-left: 1.5rem;
    }
    .blog-content ul {
        list-style-type: disc;
    }
    .blog-content ol {
        list-style-type: decimal;
    }
    .blog-content li {
        margin-bottom: 0.5rem;
    }
    .blog-content strong {
        color: #111827;
        font-weight: 600;
    }
    /* Image Styles */
    .blog-content figure {
        margin: 2.5rem 0;
    }
    .blog-content figure img {
        width: 100%;
        border-radius: 1rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }
    .blog-content figure figcaption {
        text-align: center;
        font-size: 0.875rem;
        color: #6b7280;
        margin-top: 0.75rem;
        font-style: italic;
    }
    .blog-content .image-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin: 2.5rem 0;
    }
    .blog-content .image-grid img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-radius: 0.75rem;
    }
    .blog-content .image-full {
        margin: 2.5rem -2rem;
    }
    @media (max-width: 768px) {
        .blog-content .image-grid {
            grid-template-columns: 1fr;
        }
        .blog-content .image-full {
            margin: 2.5rem -1rem;
        }
    }
    /* Blockquote Styles */
    .blog-content blockquote {
        border-left: 4px solid #4a7c2a;
        padding: 1.5rem 2rem;
        margin: 2rem 0;
        background: #f9fafb;
        border-radius: 0 1rem 1rem 0;
        font-style: italic;
        color: #374151;
    }
    .blog-content blockquote p {
        margin-bottom: 0;
    }
    .blog-card {
        transition: all 0.3s ease;
    }
    .blog-card:hover {
        transform: translateY(-8px);
    }
    .blog-card:hover .blog-image img {
        transform: scale(1.05);
    }
    .blog-image {
        overflow: hidden;
    }
    .blog-image img {
        transition: transform 0.5s ease;
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush

@section('content')
@php
    $btcCheckUrl = rtrim(config('app.btc_check_url'), '/');
    $placeholderImages = [
        'https://images.unsplash.com/photo-1500937386664-56d1dfef3854?w=1200&h=800&fit=crop',
        'https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=1200&h=800&fit=crop',
        'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=1200&h=800&fit=crop',
    ];
    $heroImage = $post->blogFeaturedImage
        ? $btcCheckUrl . '/' . ltrim($post->blogFeaturedImage, '/')
        : $placeholderImages[crc32($post->blogSlug ?? '') % count($placeholderImages)];
@endphp

<!-- Hero Section -->
<section class="relative min-h-[50vh] flex items-center overflow-hidden">
    <!-- Background -->
    <div class="absolute inset-0">
        <img src="{{ $heroImage }}" alt="{{ $post->blogTitle }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-brand-dark via-brand-dark/90 to-brand-dark/70"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-brand-dark via-brand-dark/50 to-transparent"></div>
    </div>

    <!-- Decorative Elements -->
    <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-brand-yellow/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-1/4 left-1/4 w-64 h-64 bg-brand-green/10 rounded-full blur-3xl"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-16 w-full">
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
                    <a href="{{ route('blog.index') }}" class="text-white/70 hover:text-white transition-colors">Blog</a>
                </li>
                <li class="text-white/30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </li>
                <li>
                    <span class="text-brand-yellow font-medium">Article</span>
                </li>
            </ol>
        </nav>

        <div class="max-w-4xl">
            <!-- Category Badge -->
            @php
                $categoryColor = $post->blogCategoryColor ?? 'brand-green';
                $categoryBg = match($categoryColor) {
                    'brand-yellow' => 'bg-brand-yellow/20 text-brand-yellow border-brand-yellow/30',
                    'brand-green' => 'bg-brand-green/20 text-white border-brand-green/30',
                    'blue' => 'bg-blue-500/20 text-blue-300 border-blue-400/30',
                    'purple' => 'bg-purple-500/20 text-purple-300 border-purple-400/30',
                    'orange' => 'bg-orange-500/20 text-orange-300 border-orange-400/30',
                    'teal' => 'bg-teal-500/20 text-teal-300 border-teal-400/30',
                    'red' => 'bg-red-500/20 text-red-300 border-red-400/30',
                    default => 'bg-brand-green/20 text-white border-brand-green/30'
                };
            @endphp
            <div class="inline-flex items-center gap-2 {{ $categoryBg }} backdrop-blur-sm px-4 py-2 rounded-full mb-6 border anim-fade-in-up anim-delay-100">
                <span class="text-sm font-semibold uppercase tracking-wide">{{ $post->blogCategory }}</span>
            </div>

            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-6 leading-tight anim-fade-in-up anim-delay-200" style="font-family: 'Instrument Sans', sans-serif;">
                {{ $post->blogTitle }}
            </h1>

            <p class="text-xl text-white/80 max-w-3xl leading-relaxed anim-fade-in-up anim-delay-300">
                {{ $post->blogExcerpt }}
            </p>

            <!-- Author & Date Info -->
            <div class="flex items-center gap-4 mt-8 anim-fade-in-up anim-delay-400">
                @if($post->authorImage)
                    <img src="{{ $post->authorImage }}" alt="{{ $post->authorName }}" class="w-12 h-12 rounded-full object-cover border-2 border-white/20">
                @else
                    <div class="w-12 h-12 rounded-full bg-brand-green/30 flex items-center justify-center border-2 border-white/20">
                        <span class="text-white font-bold">{{ substr($post->authorName ?? 'AS', 0, 2) }}</span>
                    </div>
                @endif
                <div>
                    <p class="text-white font-medium">{{ $post->authorName ?? 'AniSenso Team' }}</p>
                    <p class="text-white/60 text-sm">
                        {{ $post->publishedAt ? \Carbon\Carbon::parse($post->publishedAt)->format('F j, Y') : 'Recently' }}
                        @if($post->viewCount > 0)
                            <span class="mx-2">•</span>
                            <span>{{ number_format($post->viewCount) }} views</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Article Content -->
<section class="py-16 bg-white" x-data="{ shown: false }" x-intersect:enter.once="shown = true">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <article class="blog-content transition-all duration-700" :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            {!! $post->blogContent !!}
        </article>

        <!-- Share Section -->
        <div class="mt-12 pt-8 border-t border-gray-200 transition-all duration-500 delay-200" :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <p class="text-gray-600 font-medium">Share this article:</p>
                <div class="flex items-center gap-3">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="w-10 h-10 flex items-center justify-center bg-[#1877F2] text-white rounded-full hover:opacity-90 transition-opacity">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->blogTitle) }}" target="_blank" class="w-10 h-10 flex items-center justify-center bg-black text-white rounded-full hover:opacity-90 transition-opacity">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($post->blogTitle . ' - ' . request()->url()) }}" target="_blank" class="w-10 h-10 flex items-center justify-center bg-[#25D366] text-white rounded-full hover:opacity-90 transition-opacity">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </a>
                    <button onclick="navigator.clipboard.writeText(window.location.href); this.innerHTML = '<svg class=\'w-5 h-5\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M5 13l4 4L19 7\'/></svg>'; setTimeout(() => this.innerHTML = '<svg class=\'w-5 h-5\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3\'/></svg>', 2000)" class="w-10 h-10 flex items-center justify-center bg-gray-200 text-gray-700 rounded-full hover:bg-gray-300 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Back to Blog -->
        <div class="mt-12">
            <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-brand-green font-semibold hover:text-brand-green-dark transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to All Articles
            </a>
        </div>
    </div>
</section>

<!-- Related Articles -->
@if($relatedPosts->count() > 0)
<section class="py-16 bg-gray-100" x-data="{ shown: false }" x-intersect:enter.once="shown = true">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 transition-all duration-500" :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900" style="font-family: 'Instrument Sans', sans-serif;">
                Related Articles
            </h2>
            <p class="text-gray-600 mt-2">Continue reading more from our blog</p>
        </div>

        @php
            $btcUrl = rtrim(config('app.btc_check_url'), '/');
            $relatedPlaceholders = [
                'https://images.unsplash.com/photo-1592982537447-6e2bd1b5d0f2?w=600&h=400&fit=crop',
                'https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=600&h=400&fit=crop',
                'https://images.unsplash.com/photo-1523348837708-15d4a09cfac2?w=600&h=400&fit=crop',
            ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($relatedPosts as $related)
            @php
                $relatedColor = $related->blogCategoryColor ?? 'brand-green';
                $relatedCategoryBg = match($relatedColor) {
                    'brand-yellow' => 'bg-brand-yellow/20 text-brand-dark',
                    'brand-green' => 'bg-brand-green/10 text-brand-green',
                    'blue' => 'bg-blue-100 text-blue-700',
                    'purple' => 'bg-purple-100 text-purple-700',
                    'orange' => 'bg-orange-100 text-orange-700',
                    'teal' => 'bg-teal-100 text-teal-700',
                    'red' => 'bg-red-100 text-red-700',
                    default => 'bg-brand-green/10 text-brand-green'
                };
                $delay = ($loop->index * 150) + 100;
                $relatedImage = $related->blogFeaturedImage
                    ? $btcUrl . '/' . ltrim($related->blogFeaturedImage, '/')
                    : $relatedPlaceholders[$loop->index % count($relatedPlaceholders)];
            @endphp
            <a href="{{ route('blog.show', $related->blogSlug) }}"
               class="blog-card bg-white rounded-2xl shadow-sm overflow-hidden transition-all duration-500"
               :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
               :style="shown ? 'transition-delay: {{ $delay }}ms' : ''">
                <div class="blog-image aspect-[16/10]">
                    <img src="{{ $relatedImage }}" alt="{{ $related->blogTitle }}" class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <div class="mb-3">
                        <span class="{{ $relatedCategoryBg }} px-3 py-1 rounded-full text-xs font-medium">{{ $related->blogCategory }}</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 hover:text-brand-green transition-colors">
                        {{ $related->blogTitle }}
                    </h3>
                    <div class="pt-4 border-t border-gray-100">
                        <span class="text-brand-green text-sm font-medium">Read More</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-20 bg-brand-dark relative overflow-hidden" x-data="{ shown: false }" x-intersect:enter.once="shown = true">
    <!-- Decorative Elements -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-brand-yellow/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-brand-green/10 rounded-full blur-3xl"></div>

    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-6 transition-all duration-500" style="font-family: 'Instrument Sans', sans-serif;"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            Ready to Transform Your Farm?
        </h2>
        <p class="text-xl text-white/70 mb-10 max-w-2xl mx-auto transition-all duration-500 delay-100"
           :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            Join thousands of Filipino farmers who are already benefiting from AniSenso's proven farming techniques and technologies.
        </p>
        <a href="{{ route('community.join') }}" class="group inline-flex items-center gap-2 bg-brand-yellow text-brand-dark px-8 py-4 rounded-full font-bold text-lg hover:bg-brand-yellow-hover transition-all shadow-lg shadow-brand-yellow/30 duration-500 delay-200"
           :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
            Join the Community
            <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
        </a>
    </div>
</section>
@endsection
