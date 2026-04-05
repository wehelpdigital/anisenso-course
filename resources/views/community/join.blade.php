@extends('layouts.landing')

@section('title', 'Sumali sa AniSenso Community - Libre Lang! | AniSenso Academy')

@php $btcUrl = rtrim(config('app.btc_check_url'), '/'); @endphp

@push('styles')
<style>
    html {
        scroll-behavior: smooth;
    }
    .form-input {
        width: 100%;
        padding: 14px 18px;
        border-radius: 12px;
        border: 2px solid #e5e7eb;
        outline: none;
        transition: all 0.3s ease;
        font-size: 16px;
    }
    .form-input:focus {
        border-color: #4a7c2a;
        box-shadow: 0 0 0 4px rgba(74, 124, 42, 0.1);
    }
    .form-input::placeholder {
        color: #9ca3af;
    }
    .form-input.input-error {
        border-color: #ef4444;
    }
    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }
    .form-select {
        width: 100%;
        padding: 14px 40px 14px 18px;
        border-radius: 12px;
        border: 2px solid #e5e7eb;
        outline: none;
        transition: all 0.3s ease;
        font-size: 16px;
        background-color: white;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        background-size: 20px;
    }
    .form-select:focus {
        border-color: #4a7c2a;
        box-shadow: 0 0 0 4px rgba(74, 124, 42, 0.1);
    }
    .form-select.input-error {
        border-color: #ef4444;
    }
    .checkbox-card {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px;
        border-radius: 12px;
        border: 2px solid #e5e7eb;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
    }
    .checkbox-card:hover {
        border-color: rgba(74, 124, 42, 0.4);
        background: rgba(74, 124, 42, 0.02);
    }
    .checkbox-card:has(input:checked) {
        border-color: #4a7c2a;
        background: rgba(74, 124, 42, 0.08);
    }
    .checkbox-card input[type="checkbox"],
    .checkbox-card input[type="radio"] {
        width: 18px;
        height: 18px;
        accent-color: #4a7c2a;
        cursor: pointer;
    }
    .radio-card {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px;
        border-radius: 12px;
        border: 2px solid #e5e7eb;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
    }
    .radio-card:hover {
        border-color: rgba(74, 124, 42, 0.4);
        background: rgba(74, 124, 42, 0.02);
    }
    .radio-card:has(input:checked) {
        border-color: #4a7c2a;
        background: rgba(74, 124, 42, 0.08);
    }
    .radio-card input[type="radio"] {
        width: 18px;
        height: 18px;
        accent-color: #4a7c2a;
        cursor: pointer;
    }
    .section-divider {
        height: 1px;
        background: linear-gradient(to right, transparent, #e5e7eb, transparent);
        margin: 24px 0;
    }
    .content-heading-h1 { font-size: 2.25rem; font-weight: 800; color: #1a1a1a; margin-bottom: 1rem; line-height: 1.2; }
    .content-heading-h2 { font-size: 1.75rem; font-weight: 700; color: #1a1a1a; margin-bottom: 0.75rem; line-height: 1.3; }
    .content-heading-h3 { font-size: 1.25rem; font-weight: 600; color: #1a1a1a; margin-bottom: 0.5rem; line-height: 1.4; }
    .content-paragraph { color: #4b5563; font-size: 1.05rem; line-height: 1.75; margin-bottom: 1rem; }
    .content-list { list-style: none; padding: 0; margin-bottom: 1.25rem; }
    .content-list li {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 8px 0;
        color: #374151;
        font-size: 1rem;
    }
    .content-list li::before {
        content: '';
        flex-shrink: 0;
        width: 22px;
        height: 22px;
        margin-top: 2px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%234a7c2a'%3E%3Cpath fill-rule='evenodd' d='M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z' clip-rule='evenodd'/%3E%3C/svg%3E");
        background-size: contain;
        background-repeat: no-repeat;
    }
    .content-image { margin-bottom: 1.25rem; }
    .content-image img { max-width: 100%; border-radius: 16px; }
    .content-divider { border: none; height: 1px; background: linear-gradient(to right, transparent, #d1d5db, transparent); margin: 1.5rem 0; }
</style>
@endpush

@section('content')
<!-- Minimal Header -->
<header class="bg-brand-dark">
    <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
        <a href="{{ url('/') }}" class="flex items-center gap-2">
            <img src="{{ asset('images/logo.png') }}" alt="AniSenso" class="h-8 w-auto">
        </a>
        <a href="{{ url('/') }}" class="text-gray-400 hover:text-white transition-colors text-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Bumalik sa Home
        </a>
    </div>
</header>

<!-- Main Content - Two Column Layout -->
<section class="bg-gradient-to-br from-gray-50 via-white to-gray-50 min-h-screen" x-data="joinForm()">
    <div class="max-w-6xl mx-auto px-4 py-12 md:py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-start">

            <!-- Left Column: Dynamic Page Content -->
            <div class="lg:sticky lg:top-8">
                @if(!empty($pageContent))
                    @foreach($pageContent as $block)
                        @switch($block['type'] ?? '')
                            @case('heading')
                                @php
                                    $tag = $block['tag'] ?? 'h2';
                                    $tagClass = 'content-heading-' . $tag;
                                @endphp
                                <{{ $tag }} class="{{ $tagClass }}" style="font-family: 'Instrument Sans', sans-serif;">
                                    {!! $block['content'] ?? '' !!}
                                </{{ $tag }}>
                                @break

                            @case('paragraph')
                                <p class="content-paragraph">{!! $block['content'] ?? '' !!}</p>
                                @break

                            @case('list')
                                <ul class="content-list">
                                    @foreach(($block['items'] ?? []) as $item)
                                        <li>{{ $item }}</li>
                                    @endforeach
                                </ul>
                                @break

                            @case('image')
                                <div class="content-image">
                                    @php
                                        $imgSrc = $block['src'] ?? '';
                                        if ($imgSrc && !str_starts_with($imgSrc, 'http')) {
                                            $imgSrc = $btcUrl . '/' . ltrim($imgSrc, '/');
                                        }
                                    @endphp
                                    <img src="{{ $imgSrc }}" alt="{{ $block['alt'] ?? '' }}">
                                    @if(!empty($block['alt']))
                                        <p class="text-gray-500 text-sm mt-2 text-center">{{ $block['alt'] }}</p>
                                    @endif
                                </div>
                                @break

                            @case('divider')
                                <hr class="content-divider">
                                @break
                        @endswitch
                    @endforeach
                @else
                    {{-- Fallback if no page content is configured --}}
                    <div class="inline-flex items-center gap-2 bg-brand-green text-white px-4 py-2 rounded-full text-sm font-bold mb-6 shadow-lg shadow-brand-green/25">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        100% LIBRE - Walang Bayad!
                    </div>
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-brand-dark mb-4 leading-tight" style="font-family: 'Instrument Sans', sans-serif;">
                        Sumali sa AniSenso <span class="text-brand-green">Community</span>
                    </h1>
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                        Ito ang <strong class="text-brand-dark">unang hakbang</strong> para ma-access ang buong AniSenso ecosystem - courses, community, at exclusive benefits.
                    </p>
                @endif

                <!-- Mobile Arrow Indicator -->
                <a href="#join-form" class="lg:hidden flex flex-col items-center mt-8 animate-bounce cursor-pointer">
                    <span class="bg-brand-green text-white px-4 py-2 rounded-full font-bold text-sm mb-2 shadow-lg">
                        Magsimula Dito!
                    </span>
                    <svg class="w-10 h-10 text-brand-green drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                    </svg>
                </a>
            </div>

            <!-- Right Column: Dynamic Form -->
            <div>
                <div class="bg-gradient-to-br from-brand-green/5 via-white to-brand-yellow/5 rounded-3xl shadow-xl shadow-brand-green/10 border-2 border-brand-green/20 overflow-hidden"
                     id="join-form">

                    {{-- Loading state --}}
                    <div x-show="isLoadingFields" class="p-8 text-center">
                        <svg class="animate-spin w-8 h-8 mx-auto text-brand-green mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <p class="text-gray-400">Naglo-load ng form...</p>
                    </div>

                    <form x-show="!isLoadingFields" @submit.prevent="submitForm" x-cloak>
                        <div class="p-6 md:p-8">
                            <div class="space-y-4">
                                <template x-for="field in formFields" :key="field.id">
                                    <div>
                                        {{-- Heading element --}}
                                        <template x-if="field.type === 'heading'">
                                            <div class="pt-2 pb-1">
                                                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider" x-text="field.text || field.label"></h3>
                                            </div>
                                        </template>

                                        {{-- Paragraph element --}}
                                        <template x-if="field.type === 'paragraph'">
                                            <p class="text-gray-500 text-sm" x-text="field.text || field.content"></p>
                                        </template>

                                        {{-- Divider element --}}
                                        <template x-if="field.type === 'divider'">
                                            <div class="section-divider"></div>
                                        </template>

                                        {{-- Text input --}}
                                        <template x-if="field.type === 'text'">
                                            <div>
                                                <label class="form-label">
                                                    <span x-text="field.label"></span>
                                                    <span x-show="field.required" class="text-red-500">*</span>
                                                </label>
                                                <input type="text"
                                                    :placeholder="field.placeholder || ''"
                                                    x-model="formData[field.id]"
                                                    @input="errors[field.id] = ''"
                                                    class="form-input"
                                                    :class="errors[field.id] ? 'input-error' : ''">
                                                <p x-show="errors[field.id]" x-text="errors[field.id]" class="text-red-500 text-xs mt-1"></p>
                                            </div>
                                        </template>

                                        {{-- Email input --}}
                                        <template x-if="field.type === 'email'">
                                            <div>
                                                <label class="form-label">
                                                    <span x-text="field.label"></span>
                                                    <span x-show="field.required" class="text-red-500">*</span>
                                                </label>
                                                <input type="email"
                                                    :placeholder="field.placeholder || ''"
                                                    x-model="formData[field.id]"
                                                    @input="errors[field.id] = ''"
                                                    class="form-input"
                                                    :class="errors[field.id] ? 'input-error' : ''">
                                                <p x-show="errors[field.id]" x-text="errors[field.id]" class="text-red-500 text-xs mt-1"></p>
                                            </div>
                                        </template>

                                        {{-- Phone input --}}
                                        <template x-if="field.type === 'phone'">
                                            <div>
                                                <label class="form-label">
                                                    <span x-text="field.label"></span>
                                                    <span x-show="field.required" class="text-red-500">*</span>
                                                </label>
                                                <input type="tel"
                                                    :placeholder="field.placeholder || ''"
                                                    x-model="formData[field.id]"
                                                    @input="errors[field.id] = ''"
                                                    class="form-input"
                                                    :class="errors[field.id] ? 'input-error' : ''">
                                                <p x-show="errors[field.id]" x-text="errors[field.id]" class="text-red-500 text-xs mt-1"></p>
                                            </div>
                                        </template>

                                        {{-- Number input --}}
                                        <template x-if="field.type === 'number'">
                                            <div>
                                                <label class="form-label">
                                                    <span x-text="field.label"></span>
                                                    <span x-show="field.required" class="text-red-500">*</span>
                                                </label>
                                                <input type="number"
                                                    :placeholder="field.placeholder || ''"
                                                    :min="field.min"
                                                    :max="field.max"
                                                    x-model="formData[field.id]"
                                                    @input="errors[field.id] = ''"
                                                    class="form-input"
                                                    :class="errors[field.id] ? 'input-error' : ''">
                                                <p x-show="errors[field.id]" x-text="errors[field.id]" class="text-red-500 text-xs mt-1"></p>
                                            </div>
                                        </template>

                                        {{-- Select dropdown --}}
                                        <template x-if="field.type === 'select'">
                                            <div>
                                                <label class="form-label">
                                                    <span x-text="field.label"></span>
                                                    <span x-show="field.required" class="text-red-500">*</span>
                                                </label>
                                                <select
                                                    x-model="formData[field.id]"
                                                    @change="errors[field.id] = ''"
                                                    class="form-select"
                                                    :class="errors[field.id] ? 'input-error' : ''">
                                                    <option value="" x-text="field.placeholder || '— Pumili —'"></option>
                                                    <template x-for="opt in (field.options || [])" :key="opt">
                                                        <option :value="opt" x-text="opt"></option>
                                                    </template>
                                                </select>
                                                <p x-show="errors[field.id]" x-text="errors[field.id]" class="text-red-500 text-xs mt-1"></p>
                                            </div>
                                        </template>

                                        {{-- Textarea --}}
                                        <template x-if="field.type === 'textarea'">
                                            <div>
                                                <label class="form-label">
                                                    <span x-text="field.label"></span>
                                                    <span x-show="field.required" class="text-red-500">*</span>
                                                </label>
                                                <textarea
                                                    :placeholder="field.placeholder || ''"
                                                    :rows="field.rows || 4"
                                                    x-model="formData[field.id]"
                                                    @input="errors[field.id] = ''"
                                                    class="form-input resize-none"
                                                    :class="errors[field.id] ? 'input-error' : ''"
                                                ></textarea>
                                                <p x-show="errors[field.id]" x-text="errors[field.id]" class="text-red-500 text-xs mt-1"></p>
                                            </div>
                                        </template>

                                        {{-- Radio buttons --}}
                                        <template x-if="field.type === 'radio'">
                                            <div>
                                                <label class="form-label">
                                                    <span x-text="field.label"></span>
                                                    <span x-show="field.required" class="text-red-500">*</span>
                                                </label>
                                                <div :class="field.inline ? 'flex flex-wrap gap-2' : 'grid grid-cols-2 gap-2'">
                                                    <template x-for="opt in (field.options || [])" :key="opt">
                                                        <label class="radio-card">
                                                            <input type="radio"
                                                                :name="field.id"
                                                                :value="opt"
                                                                x-model="formData[field.id]"
                                                                @change="errors[field.id] = ''">
                                                            <span class="text-gray-700 font-medium text-sm" x-text="opt"></span>
                                                        </label>
                                                    </template>
                                                </div>
                                                <p x-show="errors[field.id]" x-text="errors[field.id]" class="text-red-500 text-xs mt-1"></p>
                                            </div>
                                        </template>

                                        {{-- Checkboxes (multiple) --}}
                                        <template x-if="field.type === 'checkbox'">
                                            <div>
                                                <label class="form-label">
                                                    <span x-text="field.label"></span>
                                                    <span x-show="field.required" class="text-red-500">*</span>
                                                </label>
                                                <div :class="field.inline ? 'flex flex-wrap gap-2' : 'grid grid-cols-2 gap-2'">
                                                    <template x-for="opt in (field.options || [])" :key="opt">
                                                        <label class="checkbox-card">
                                                            <input type="checkbox"
                                                                :value="opt"
                                                                @change="
                                                                    let arr = Array.isArray(formData[field.id]) ? [...formData[field.id]] : [];
                                                                    if ($event.target.checked) { arr.push(opt); } else { arr = arr.filter(v => v !== opt); }
                                                                    formData[field.id] = arr;
                                                                    errors[field.id] = '';
                                                                "
                                                                :checked="Array.isArray(formData[field.id]) && formData[field.id].includes(opt)">
                                                            <span class="text-gray-700 font-medium text-sm" x-text="opt"></span>
                                                        </label>
                                                    </template>
                                                </div>
                                                <p x-show="errors[field.id]" x-text="errors[field.id]" class="text-red-500 text-xs mt-1"></p>
                                            </div>
                                        </template>

                                        {{-- Single checkbox --}}
                                        <template x-if="field.type === 'single_checkbox'">
                                            <div>
                                                <label class="checkbox-card">
                                                    <input type="checkbox"
                                                        x-model="formData[field.id]"
                                                        @change="errors[field.id] = ''">
                                                    <span class="text-gray-700 font-medium text-sm" x-text="field.label"></span>
                                                </label>
                                                <p x-show="errors[field.id]" x-text="errors[field.id]" class="text-red-500 text-xs mt-1"></p>
                                            </div>
                                        </template>

                                        {{-- Date input --}}
                                        <template x-if="field.type === 'date'">
                                            <div>
                                                <label class="form-label">
                                                    <span x-text="field.label"></span>
                                                    <span x-show="field.required" class="text-red-500">*</span>
                                                </label>
                                                <input type="date"
                                                    x-model="formData[field.id]"
                                                    @input="errors[field.id] = ''"
                                                    class="form-input"
                                                    :class="errors[field.id] ? 'input-error' : ''">
                                                <p x-show="errors[field.id]" x-text="errors[field.id]" class="text-red-500 text-xs mt-1"></p>
                                            </div>
                                        </template>

                                        {{-- Time input --}}
                                        <template x-if="field.type === 'time'">
                                            <div>
                                                <label class="form-label">
                                                    <span x-text="field.label"></span>
                                                    <span x-show="field.required" class="text-red-500">*</span>
                                                </label>
                                                <input type="time"
                                                    x-model="formData[field.id]"
                                                    @input="errors[field.id] = ''"
                                                    class="form-input"
                                                    :class="errors[field.id] ? 'input-error' : ''">
                                                <p x-show="errors[field.id]" x-text="errors[field.id]" class="text-red-500 text-xs mt-1"></p>
                                            </div>
                                        </template>

                                        {{-- Hidden field --}}
                                        <template x-if="field.type === 'hidden'">
                                            <input type="hidden" x-model="formData[field.id]">
                                        </template>

                                        {{-- Submit button element from form builder --}}
                                        <template x-if="field.type === 'submit_button'">
                                            <div class="pt-4">
                                                <button type="submit"
                                                    class="w-full py-4 rounded-xl font-bold text-lg transition-all duration-300 flex items-center justify-center gap-2 shadow-lg"
                                                    :disabled="isSubmitting"
                                                    :class="isSubmitting ? 'opacity-70 cursor-not-allowed' : ''"
                                                    :style="'background-color: ' + (field.buttonColor || '#f5c518') + '; color: ' + (field.buttonColor === '#f5c518' || !field.buttonColor ? '#1a1a1a' : '#fff')">
                                                    <span x-show="!isSubmitting" x-text="field.buttonText || 'Submit'"></span>
                                                    <span x-show="isSubmitting" class="flex items-center gap-2">
                                                        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                        </svg>
                                                        Processing...
                                                    </span>
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                </template>

                                {{-- Fallback submit button if no submit_button element exists --}}
                                <div x-show="!hasSubmitButton" class="pt-4">
                                    <button type="submit"
                                        class="w-full bg-brand-yellow text-brand-dark py-4 rounded-xl font-bold text-lg hover:bg-brand-yellow-hover transition-all duration-300 flex items-center justify-center gap-2 shadow-lg shadow-brand-yellow/20"
                                        :disabled="isSubmitting"
                                        :class="isSubmitting ? 'opacity-70 cursor-not-allowed' : ''">
                                        <span x-show="!isSubmitting">Sumali Na - Libre Lang!</span>
                                        <span x-show="isSubmitting" class="flex items-center gap-2">
                                            <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            Processing...
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Terms and Email Consent -->
                        <div class="bg-gray-50 px-6 md:px-8 py-5">
                            <p class="text-gray-500 text-sm leading-relaxed text-center">
                                Sa pag-submit ng form na ito, sumasang-ayon ka na makatanggap ng mga email mula sa AniSenso tungkol sa updates, tips, at offers. Pwede kang mag-unsubscribe anumang oras.
                            </p>
                        </div>
                    </form>
                </div>

                <!-- Terms Link -->
                <div class="text-center mt-6">
                    <p class="text-gray-400 text-sm">
                        Sa pag-join, sumasang-ayon ka sa aming
                        <a href="#" class="text-brand-green hover:underline font-medium">Terms and Conditions</a>
                        at
                        <a href="#" class="text-brand-green hover:underline font-medium">Privacy Policy</a>.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Success Modal -->
<div x-show="showSuccess" x-cloak
     class="fixed inset-0 z-50 flex items-center justify-center p-4"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="showSuccess = false"></div>
    <div class="relative bg-white rounded-3xl p-10 max-w-md w-full text-center shadow-2xl"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-90"
         x-transition:enter-end="opacity-100 scale-100">
        <div class="w-20 h-20 bg-brand-green/10 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-brand-green" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        </div>
        <h3 class="text-2xl font-bold text-brand-dark mb-3">Salamat sa Pag-Join!</h3>
        <p class="text-gray-500 mb-8 leading-relaxed" x-text="successMessage"></p>
        <a href="{{ url('/') }}" class="inline-flex items-center justify-center gap-2 bg-brand-yellow text-brand-dark px-8 py-4 rounded-xl font-bold hover:bg-brand-yellow-hover transition-all duration-300">
            Bumalik sa Home
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
        </a>
    </div>
</div>

<!-- Minimal Footer -->
<footer class="bg-brand-dark py-6">
    <div class="max-w-5xl mx-auto px-4 flex flex-col md:flex-row items-center justify-between gap-4">
        <p class="text-gray-500 text-sm">&copy; {{ date('Y') }} AniSenso Academy. All rights reserved.</p>
        <div class="flex items-center gap-6 text-sm">
            <a href="#" class="text-gray-500 hover:text-gray-400 transition-colors">Terms and Conditions</a>
            <a href="#" class="text-gray-500 hover:text-gray-400 transition-colors">Privacy Policy</a>
        </div>
    </div>
</footer>

@endsection

@push('scripts')
<script>
function joinForm() {
    return {
        formFields: [],
        formData: {},
        errors: {},
        isLoadingFields: true,
        isSubmitting: false,
        showSuccess: false,
        hasSubmitButton: false,
        successMessage: 'Makakatanggap ka ng email confirmation at instructions kung paano ma-access ang community at courses.',

        init() {
            this.loadFormFields();
        },

        async loadFormFields() {
            try {
                const res = await fetch('{{ route("community.form-fields") }}', {
                    headers: { 'Accept': 'application/json' },
                });
                const data = await res.json();
                if (data.success) {
                    this.formFields = data.fields;
                    this.hasSubmitButton = data.fields.some(f => f.type === 'submit_button');

                    // Initialize formData for each input field
                    const skipTypes = ['heading', 'paragraph', 'divider', 'submit_button', 'image', 'video'];
                    data.fields.forEach(f => {
                        if (skipTypes.includes(f.type)) return;
                        if (f.type === 'hidden') {
                            this.formData[f.id] = f.value || f.defaultValue || '';
                        } else if (f.type === 'checkbox') {
                            this.formData[f.id] = [];
                        } else if (f.type === 'single_checkbox') {
                            this.formData[f.id] = false;
                        } else {
                            this.formData[f.id] = '';
                        }
                    });
                }
            } catch (e) {
                console.error('Failed to load form fields:', e);
            } finally {
                this.isLoadingFields = false;
            }
        },

        submitForm() {
            this.errors = {};
            let valid = true;
            const skipTypes = ['heading', 'paragraph', 'divider', 'submit_button', 'image', 'video'];

            this.formFields.forEach(field => {
                if (skipTypes.includes(field.type)) return;

                const val = this.formData[field.id];
                const isEmpty = Array.isArray(val)
                    ? val.length === 0
                    : (typeof val === 'boolean' ? !val : (!val || (typeof val === 'string' && !val.trim())));

                if (field.required && isEmpty) {
                    this.errors[field.id] = 'Kinakailangan ang field na ito.';
                    valid = false;
                }
                if (field.type === 'email' && val && val.trim()) {
                    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val.trim())) {
                        this.errors[field.id] = 'Mangyaring maglagay ng wastong email address.';
                        valid = false;
                    }
                }
                if (field.type === 'phone' && val && val.trim()) {
                    if (!/^(09\d{9}|63\d{10})$/.test(val.trim())) {
                        this.errors[field.id] = 'Format: 09XXXXXXXXX o 63XXXXXXXXXX';
                        valid = false;
                    }
                }
            });

            if (!valid) {
                // Scroll to first error
                this.$nextTick(() => {
                    const firstError = document.querySelector('.input-error, .text-red-500');
                    if (firstError) firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                });
                return;
            }

            this.isSubmitting = true;

            fetch('{{ route("community.submit") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify(this.formData),
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (data.message) this.successMessage = data.message;
                    this.showSuccess = true;

                    // Reset form
                    const skipTypes = ['heading', 'paragraph', 'divider', 'submit_button', 'image', 'video'];
                    this.formFields.forEach(f => {
                        if (skipTypes.includes(f.type)) return;
                        if (f.type === 'checkbox') this.formData[f.id] = [];
                        else if (f.type === 'single_checkbox') this.formData[f.id] = false;
                        else if (f.type !== 'hidden') this.formData[f.id] = '';
                    });
                } else if (data.errors) {
                    this.errors = {};
                    Object.keys(data.errors).forEach(key => {
                        this.errors[key] = Array.isArray(data.errors[key]) ? data.errors[key][0] : data.errors[key];
                    });
                }
            })
            .catch(err => {
                console.error('Submission failed:', err);
                alert('May error sa pag-submit. Pakisubukan muli.');
            })
            .finally(() => {
                this.isSubmitting = false;
            });
        }
    }
}
</script>
@endpush
