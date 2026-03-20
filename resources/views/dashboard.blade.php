@extends('layouts.app')

@section('title', 'Dashboard - Ani-Senso Academy')

@section('content')
<!-- Dashboard Hero -->
<section class="bg-brand-dark pt-28 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-brand-yellow flex items-center justify-center text-2xl font-bold text-brand-dark">
                {{ auth()->guard('client')->user()->initials }}
            </div>
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-white">
                    Welcome back, {{ auth()->guard('client')->user()->clientFirstName }}!
                </h1>
                <p class="text-gray-400">Continue your learning journey</p>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 bg-gray-50 min-h-[60vh]">
    <!-- Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-brand-yellow/20 flex items-center justify-center">
                    <span class="text-2xl">📚</span>
                </div>
                <div>
                    <p class="text-3xl font-bold text-brand-dark">0</p>
                    <p class="text-sm text-gray-500">Enrolled Courses</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-brand-green/20 flex items-center justify-center">
                    <span class="text-2xl">✅</span>
                </div>
                <div>
                    <p class="text-3xl font-bold text-brand-dark">0</p>
                    <p class="text-sm text-gray-500">Completed</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-brand-yellow/20 flex items-center justify-center">
                    <span class="text-2xl">⏱️</span>
                </div>
                <div>
                    <p class="text-3xl font-bold text-brand-dark">0h</p>
                    <p class="text-sm text-gray-500">Learning Time</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-brand-green/20 flex items-center justify-center">
                    <span class="text-2xl">🏆</span>
                </div>
                <div>
                    <p class="text-3xl font-bold text-brand-dark">0</p>
                    <p class="text-sm text-gray-500">Certificates</p>
                </div>
            </div>
        </div>
    </div>

    <!-- My Courses Section -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-900 mb-4">My Courses</h2>
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 text-center">
            <div class="w-20 h-20 mx-auto bg-brand-yellow/20 rounded-full flex items-center justify-center mb-4">
                <span class="text-4xl">📖</span>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No courses yet</h3>
            <p class="text-gray-500 mb-6">You haven't enrolled in any courses. Start exploring!</p>
            <a href="{{ url('/courses') }}" class="inline-flex items-center gap-2 bg-brand-yellow text-brand-dark px-6 py-3 rounded-full font-semibold shadow-lg hover:bg-brand-yellow-hover hover:-translate-y-0.5 hover:shadow-xl transition-all">
                <span>Browse Courses</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div>
        <h2 class="text-xl font-bold text-gray-900 mb-4">Recent Activity</h2>
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 text-center">
            <div class="w-20 h-20 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <span class="text-4xl">📊</span>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No activity yet</h3>
            <p class="text-gray-500">Your learning activity will appear here.</p>
        </div>
    </div>
</main>
@endsection
