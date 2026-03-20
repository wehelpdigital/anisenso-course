@extends('layouts.app')

@section('title', 'Courses - Ani-Senso Academy')

@section('content')
<!-- Hero Banner -->
<section class="relative py-20 bg-brand-dark">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="flex items-center justify-center gap-2 text-brand-yellow mb-4">
            <span class="text-2xl">📚</span>
            <span class="text-sm font-semibold uppercase tracking-wide">Our Courses</span>
        </div>
        <h1 class="text-4xl md:text-5xl font-black text-white mb-4">Explore Our Courses</h1>
        <p class="text-xl text-gray-400 max-w-2xl mx-auto">Discover our collection of expert-led courses designed to help you achieve your learning goals.</p>
    </div>
</section>

<!-- Courses Grid Placeholder -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center py-16 bg-white rounded-2xl shadow-lg">
            <div class="w-24 h-24 mx-auto bg-brand-yellow/20 rounded-full flex items-center justify-center mb-6">
                <span class="text-5xl">📖</span>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Courses Coming Soon</h2>
            <p class="text-gray-600 max-w-md mx-auto mb-8">We're working hard to bring you amazing courses. Check back soon!</p>
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 bg-brand-yellow text-brand-dark px-6 py-3 rounded-full font-semibold hover:bg-brand-yellow-hover transition-colors">
                <span>Back to Home</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>
@endsection
