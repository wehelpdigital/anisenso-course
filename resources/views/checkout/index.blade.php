@extends('layouts.landing')

@section('title', 'Checkout - AniSenso Academy')

@push('styles')
<style>
    /* Step indicator styles - Modern minimal design */
    .step-indicator {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0;
        padding: 8px 0;
    }
    .step-circle {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 18px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        flex-shrink: 0;
        position: relative;
    }
    .step-circle.active {
        background: linear-gradient(135deg, #22c55e 0%, #15803d 100%);
        color: white;
        box-shadow: 0 6px 20px rgba(34, 197, 94, 0.45), 0 0 0 4px rgba(34, 197, 94, 0.15);
        transform: scale(1.05);
    }
    .step-circle.completed {
        background: linear-gradient(135deg, #22c55e 0%, #15803d 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
    }
    .step-circle.inactive {
        background: #f3f4f6;
        color: #9ca3af;
        border: 2px solid #e5e7eb;
    }
    .step-line {
        width: 80px;
        height: 4px;
        background: #e5e7eb;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 2px;
    }
    .step-line.completed {
        background: linear-gradient(90deg, #22c55e 0%, #15803d 100%);
        box-shadow: 0 2px 8px rgba(34, 197, 94, 0.3);
    }

    /* Form styles */
    .form-input {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 16px;
        transition: all 0.2s ease;
        background: white;
    }
    .form-input:focus {
        outline: none;
        border-color: #22c55e;
        box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1);
    }
    .form-input.error {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }
    .form-input.success {
        border-color: #22c55e;
    }
    .form-label {
        display: block;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 8px;
        font-size: 14px;
    }
    .form-error {
        color: #ef4444;
        font-size: 13px;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .form-hint {
        color: #6b7280;
        font-size: 13px;
        margin-top: 6px;
    }

    /* Password strength indicator */
    .password-strength {
        display: flex;
        gap: 4px;
        margin-top: 8px;
    }
    .strength-bar {
        height: 4px;
        flex: 1;
        background: #e5e7eb;
        border-radius: 2px;
        transition: all 0.3s ease;
    }
    .strength-bar.weak { background: #ef4444; }
    .strength-bar.fair { background: #f59e0b; }
    .strength-bar.good { background: #22c55e; }
    .strength-bar.strong { background: #22c55e; }

    /* Payment method cards */
    .payment-method {
        border: 2px solid #e5e7eb;
        border-radius: 16px;
        padding: 20px;
        cursor: pointer;
        transition: all 0.2s ease;
        background: white;
    }
    .payment-method:hover {
        border-color: #d1d5db;
        transform: translateY(-2px);
    }
    .payment-method.selected {
        border-color: #22c55e;
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.05) 0%, rgba(22, 163, 74, 0.05) 100%);
        box-shadow: 0 4px 15px rgba(34, 197, 94, 0.15);
    }

    /* Social login buttons */
    .social-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        width: 100%;
        padding: 14px 20px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.2s ease;
        border: 2px solid;
    }
    .social-btn.google {
        background: white;
        border-color: #e5e7eb;
        color: #1f2937;
    }
    .social-btn.google:hover {
        background: #f9fafb;
        border-color: #d1d5db;
    }
    .social-btn.facebook {
        background: #1877f2;
        border-color: #1877f2;
        color: white;
    }
    .social-btn.facebook:hover {
        background: #166fe5;
    }

    /* Upload area */
    .upload-area {
        border: 2px dashed #d1d5db;
        border-radius: 16px;
        padding: 30px;
        text-align: center;
        transition: all 0.2s ease;
        cursor: pointer;
        background: #f9fafb;
    }
    .upload-area:hover {
        border-color: #22c55e;
        background: rgba(34, 197, 94, 0.05);
    }
    .upload-area.dragover {
        border-color: #22c55e;
        background: rgba(34, 197, 94, 0.1);
    }
    .upload-area.has-file {
        border-color: #22c55e;
        border-style: solid;
        background: rgba(34, 197, 94, 0.05);
    }

    /* Success animation */
    @keyframes successPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    .success-icon {
        animation: successPulse 2s ease-in-out infinite;
    }

    /* Loading spinner */
    .spinner {
        width: 20px;
        height: 20px;
        border: 2px solid transparent;
        border-top-color: currentColor;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50" x-data="checkoutWizard()">
    <!-- Header -->
    <header class="bg-brand-dark py-4 px-4 sticky top-0 z-50">
        <div class="max-w-4xl mx-auto flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-2">
                <img src="http://anisenso.test/wp-content/uploads/2025/12/test-logo-big-2-scaled.png" alt="AniSenso" class="h-8 w-auto">
            </a>
            <div class="flex items-center gap-2 text-white/80 text-sm">
                <svg class="w-4 h-4 text-brand-green" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                Secure Checkout
            </div>
        </div>
    </header>

    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Recovery Mode Banner -->
        @if(isset($recoveryMode) && $recoveryMode)
        <div class="bg-gradient-to-r from-brand-yellow/20 to-brand-green/20 rounded-2xl border-2 border-brand-yellow/30 p-4 mb-6">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-full bg-brand-yellow/30 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-brand-yellow-hover" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-brand-dark mb-1">Ituloy ang iyong order!</h3>
                    <p class="text-sm text-gray-600">
                        Welcome back! Malapit na ang iyong order. I-complete lang ang payment para ma-access mo na ang course.
                    </p>
                    @if(isset($recoveryOrder))
                    <p class="text-xs text-gray-500 mt-2">
                        Order #{{ $recoveryOrder->orderNumber }}
                        @if($recoveryOrder->clientEmail)
                        &bull; {{ $recoveryOrder->clientEmail }}
                        @endif
                    </p>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- Product Summary -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-gradient-to-br from-brand-green to-brand-green-dark rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <div class="flex-1">
                    <h2 class="font-bold text-brand-dark text-lg">{{ $productName }}</h2>
                    <p class="text-gray-500 text-sm">{{ $variantName }}</p>
                </div>
                <div class="text-right">
                    @if(isset($isExitIntent) && $isExitIntent)
                        <p class="text-2xl font-bold text-brand-yellow-hover">&#8369;{{ number_format($price, 0) }}</p>
                        <p class="text-gray-400 text-sm line-through">&#8369;{{ number_format($isPromoActive ? $promoPrice : $regularPrice, 0) }}</p>
                        <span class="inline-block bg-red-500 text-white text-xs px-2 py-0.5 rounded-full font-bold mt-1">LAST CHANCE!</span>
                    @elseif($isPromoActive)
                        <p class="text-2xl font-bold text-brand-green">&#8369;{{ number_format($price, 0) }}</p>
                        <p class="text-gray-400 text-sm line-through">&#8369;{{ number_format($regularPrice, 0) }}</p>
                    @else
                        <p class="text-2xl font-bold text-brand-dark">&#8369;{{ number_format($price, 0) }}</p>
                        <p class="text-red-500 text-xs font-medium">Promo Ended</p>
                    @endif
                </div>
            </div>
            @if(isset($isExitIntent) && $isExitIntent)
                <div class="mt-4 p-3 bg-gradient-to-r from-brand-yellow/10 to-red-500/10 border border-brand-yellow/30 rounded-lg">
                    <p class="text-brand-dark text-sm flex items-center gap-2 font-medium">
                        <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                        Exit Intent Last Chance Price! Ito ay isang beses lang lalabas.
                    </p>
                </div>
            @elseif(!$isPromoActive)
                <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                    <p class="text-red-600 text-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        Natapos na ang promo. Ang regular price na &#8369;{{ number_format($regularPrice, 0) }} ang i-cha-charge.
                    </p>
                </div>
            @endif
        </div>

        <!-- Step Indicator (2 Steps Only) - Clean minimal design -->
        <div class="mb-8">
            <div class="step-indicator">
                <!-- Step 1 -->
                <div class="step-circle" :class="currentStep > 1 ? 'completed' : (currentStep === 1 ? 'active' : 'inactive')">
                    <template x-if="currentStep > 1">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    </template>
                    <template x-if="currentStep <= 1">
                        <span>1</span>
                    </template>
                </div>

                <div class="step-line" :class="currentStep > 1 ? 'completed' : ''"></div>

                <!-- Step 2 -->
                <div class="step-circle" :class="currentStep >= 2 ? 'active' : 'inactive'">
                    <span>2</span>
                </div>
            </div>
        </div>

        <!-- Step Content -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Step 1: Email + Account Info -->
            <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                <div class="p-6 md:p-8">
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-brand-dark mb-2">Impormasyon ng Account</h3>
                        <p class="text-gray-500 text-sm">Ilagay ang iyong email address para simulan.</p>
                    </div>

                    <div class="space-y-5">
                        <!-- Email Input -->
                        <div>
                            <label class="form-label">Email Address <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="email" x-model="form.email" @input="validateField('email'); checkEmailExists()"
                                       class="form-input" :class="{'error': errors.email, 'success': form.email && !errors.email && !emailCheckLoading}"
                                       placeholder="juan@example.com">
                                <div x-show="emailCheckLoading" class="absolute right-4 top-1/2 -translate-y-1/2">
                                    <span class="spinner w-4 h-4"></span>
                                </div>
                            </div>
                            <p x-show="errors.email" class="form-error">
                                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                <span x-text="errors.email"></span>
                            </p>
                        </div>

                        <!-- Email Check Loading State -->
                        <div x-show="emailCheckLoading" x-transition class="flex items-center gap-2 text-gray-500 py-2">
                            <span class="spinner w-4 h-4"></span>
                            <span class="text-sm">Checking email...</span>
                        </div>

                        <!-- Existing Account Info (shown when email exists) -->
                        <div x-show="emailChecked && emailExists && !errors.email && !emailCheckLoading" x-transition class="p-5 bg-blue-50 border border-blue-200 rounded-xl">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-blue-900" x-text="existingUserFullName || 'Existing Account'"></p>
                                    <p class="text-sm text-blue-700 mt-1">
                                        May existing account na sa email na ito. Ang course na bibilhin mo ay idadagdag sa account na ito.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- New Account Registration Fields (shown dynamically when email is new) -->
                        <div x-show="showRegistrationFields" x-transition id="registration-fields" class="space-y-5 pt-4 border-t border-gray-200">
                            <div class="mb-4">
                                <p class="text-sm font-medium text-brand-green flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/></svg>
                                    Bagong Account - Kumpletuhin ang impormasyon sa ibaba
                                </p>
                            </div>

                            <!-- Name Fields -->
                            <div class="grid md:grid-cols-2 gap-5">
                                <div>
                                    <label class="form-label">First Name <span class="text-red-500">*</span></label>
                                    <input type="text" x-model="form.firstName" @input="validateField('firstName')"
                                           class="form-input" :class="{'error': errors.firstName, 'success': form.firstName && !errors.firstName}"
                                           placeholder="Juan">
                                    <p x-show="errors.firstName" class="form-error">
                                        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                        <span x-text="errors.firstName"></span>
                                    </p>
                                </div>
                                <div>
                                    <label class="form-label">Last Name <span class="text-red-500">*</span></label>
                                    <input type="text" x-model="form.lastName" @input="validateField('lastName')"
                                           class="form-input" :class="{'error': errors.lastName, 'success': form.lastName && !errors.lastName}"
                                           placeholder="Dela Cruz">
                                    <p x-show="errors.lastName" class="form-error">
                                        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                        <span x-text="errors.lastName"></span>
                                    </p>
                                </div>
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label class="form-label">Phone Number <span class="text-red-500">*</span></label>
                                <input type="tel" x-model="form.phone" @input="validateField('phone')"
                                       class="form-input" :class="{'error': errors.phone, 'success': form.phone && !errors.phone}"
                                       placeholder="09171234567">
                                <p x-show="errors.phone" class="form-error">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    <span x-text="errors.phone"></span>
                                </p>
                                <p class="form-hint">Format: 09XXXXXXXXX, 639XXXXXXXXX, o +639XXXXXXXXX</p>
                            </div>

                            <!-- Password Field -->
                            <div>
                                <label class="form-label">Password <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input :type="showPassword ? 'text' : 'password'" x-model="form.password" @input="validateField('password'); checkPasswordStrength()"
                                           class="form-input pr-12" :class="{'error': errors.password}"
                                           placeholder="Minimum 8 characters">
                                    <button type="button" @click="showPassword = !showPassword" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                        <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                    </button>
                                </div>
                                <div class="password-strength" x-show="form.password">
                                    <div class="strength-bar" :class="passwordStrength >= 1 ? passwordStrengthClass : ''"></div>
                                    <div class="strength-bar" :class="passwordStrength >= 2 ? passwordStrengthClass : ''"></div>
                                    <div class="strength-bar" :class="passwordStrength >= 3 ? passwordStrengthClass : ''"></div>
                                    <div class="strength-bar" :class="passwordStrength >= 4 ? passwordStrengthClass : ''"></div>
                                </div>
                                <p x-show="form.password" class="form-hint" :class="{'text-red-500': passwordStrength <= 1, 'text-yellow-500': passwordStrength === 2, 'text-green-500': passwordStrength >= 3}">
                                    Password Strength: <span x-text="passwordStrengthText"></span>
                                </p>
                                <p x-show="errors.password" class="form-error">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    <span x-text="errors.password"></span>
                                </p>
                                <!-- Password Requirements -->
                                <div class="mt-2 p-3 bg-gray-50 rounded-lg border border-gray-200">
                                    <p class="text-xs font-semibold text-gray-600 mb-2">Dapat ang password ay may:</p>
                                    <ul class="text-xs text-gray-500 space-y-1">
                                        <li class="flex items-center gap-2" :class="hasMinLength() ? 'text-green-600' : ''">
                                            <svg x-show="hasMinLength()" class="w-3.5 h-3.5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                            <svg x-show="!hasMinLength()" class="w-3.5 h-3.5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="3"/></svg>
                                            <span>Hindi bababa sa <strong>8 characters</strong></span>
                                        </li>
                                        <li class="flex items-center gap-2" :class="hasUppercase() ? 'text-green-600' : ''">
                                            <svg x-show="hasUppercase()" class="w-3.5 h-3.5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                            <svg x-show="!hasUppercase()" class="w-3.5 h-3.5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="3"/></svg>
                                            <span>Malaking letra (A-Z)</span>
                                        </li>
                                        <li class="flex items-center gap-2" :class="hasLowercase() ? 'text-green-600' : ''">
                                            <svg x-show="hasLowercase()" class="w-3.5 h-3.5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                            <svg x-show="!hasLowercase()" class="w-3.5 h-3.5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="3"/></svg>
                                            <span>Maliit na letra (a-z)</span>
                                        </li>
                                        <li class="flex items-center gap-2" :class="hasNumber() ? 'text-green-600' : ''">
                                            <svg x-show="hasNumber()" class="w-3.5 h-3.5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                            <svg x-show="!hasNumber()" class="w-3.5 h-3.5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="3"/></svg>
                                            <span>Numero (0-9)</span>
                                        </li>
                                        <li class="flex items-center gap-2" :class="hasSpecialChar() ? 'text-green-600' : ''">
                                            <svg x-show="hasSpecialChar()" class="w-3.5 h-3.5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                            <svg x-show="!hasSpecialChar()" class="w-3.5 h-3.5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="3"/></svg>
                                            <span>Special character (!@#$%^&* atbp.)</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label class="form-label">Confirm Password <span class="text-red-500">*</span></label>
                                <input :type="showPassword ? 'text' : 'password'" x-model="form.passwordConfirmation" @input="validateField('passwordConfirmation')"
                                       class="form-input" :class="{'error': errors.passwordConfirmation, 'success': form.passwordConfirmation && form.password === form.passwordConfirmation && !errors.passwordConfirmation}"
                                       placeholder="Ulitin ang password">
                                <p x-show="errors.passwordConfirmation" class="form-error">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    <span x-text="errors.passwordConfirmation"></span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button @click="submitStep1()" :disabled="isLoading || !canProceedStep1()"
                                class="inline-flex items-center gap-2 bg-brand-green text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-brand-green-dark transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                            <span x-show="!isLoading">Magbayad</span>
                            <span x-show="isLoading" class="flex items-center gap-2">
                                <span class="spinner"></span>
                                Nag-lo-load...
                            </span>
                            <svg x-show="!isLoading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Step 2: Payment -->
            <div x-show="currentStep === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                <div class="p-6 md:p-8">
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-brand-dark mb-2">Magbayad</h3>
                        <p class="text-gray-500 text-sm">Pumili ng payment method at sundin ang instructions para makumpleto ang order.</p>
                    </div>

                    <!-- Payment Methods -->
                    @if($paymentSettings && $paymentSettings->hasAnyMethod)
                    <div class="space-y-4 mb-6">
                        <p class="font-semibold text-brand-dark">Pumili ng Payment Method:</p>

                        <div class="grid md:grid-cols-{{ min(count($paymentSettings->methods), 3) }} gap-4">
                            @foreach($paymentSettings->methods as $methodKey => $method)
                            <!-- {{ $method['name'] }} -->
                            <div @click="form.paymentMethod = '{{ $methodKey }}'; errors.ewalletPhone = ''; errors.paymentScreenshot = '';" class="payment-method" :class="{'selected': form.paymentMethod === '{{ $methodKey }}'}">
                                <div class="flex items-center gap-3 mb-2">
                                    @if($method['icon'] === 'bank')
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    </div>
                                    @elseif($method['icon'] === 'gcash')
                                    <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                                        <span class="text-white font-bold text-sm">G</span>
                                    </div>
                                    @elseif($method['icon'] === 'maya')
                                    <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                                        <span class="text-white font-bold text-sm">M</span>
                                    </div>
                                    @elseif($method['icon'] === 'paypal')
                                    <div class="w-10 h-10 bg-blue-700 rounded-lg flex items-center justify-center">
                                        <span class="text-white font-bold text-sm">P</span>
                                    </div>
                                    @endif
                                    <div>
                                        <p class="font-bold text-brand-dark">{{ $method['name'] }}</p>
                                        <p class="text-xs text-gray-500">
                                            @if($method['type'] === 'bank') Bank Transfer
                                            @elseif($method['type'] === 'ewallet') E-Wallet
                                            @elseif($method['type'] === 'international') International
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="w-5 h-5 rounded-full border-2 ml-auto" :class="form.paymentMethod === '{{ $methodKey }}' ? 'border-brand-green bg-brand-green' : 'border-gray-300'">
                                    <svg x-show="form.paymentMethod === '{{ $methodKey }}'" class="w-full h-full text-white p-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- ==================== STEP 1: PAY ==================== -->
                    <div x-show="form.paymentMethod" class="bg-blue-50 border-2 border-blue-200 rounded-2xl p-6 mb-6">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-lg">1</div>
                            <h4 class="text-xl font-bold text-blue-800">Magbayad / Pay</h4>
                        </div>

                        @foreach($paymentSettings->methods as $methodKey => $method)
                        <!-- {{ $method['name'] }} Details -->
                        <div x-show="form.paymentMethod === '{{ $methodKey }}'" class="space-y-5">
                            <div class="flex flex-col lg:flex-row gap-6">
                                <!-- Account Details - Main Info -->
                                <div class="flex-1">
                                    <div class="bg-white rounded-xl p-5 border-2 border-blue-100 shadow-sm">
                                        <!-- Primary Payment Info - LARGE FONT -->
                                        <div class="text-center mb-4 pb-4 border-b-2 border-blue-100">
                                            @if($method['type'] === 'bank')
                                            <p class="text-gray-500 text-sm mb-1">Account Number</p>
                                            <p class="text-3xl md:text-4xl font-black text-blue-700 tracking-wider select-all">{{ $method['accountNumber'] }}</p>
                                            <p class="text-gray-600 mt-2"><span class="font-semibold">{{ $method['bankName'] }}</span> &bull; {{ $method['accountName'] }}</p>
                                            @elseif($method['type'] === 'ewallet')
                                            <p class="text-gray-500 text-sm mb-1">{{ $method['name'] }} Number</p>
                                            <p class="text-3xl md:text-4xl font-black text-blue-700 tracking-wider select-all">{{ $method['number'] }}</p>
                                            <p class="text-gray-600 mt-2">{{ $method['accountName'] }}</p>
                                            @elseif($method['type'] === 'international')
                                            <p class="text-gray-500 text-sm mb-1">PayPal Email</p>
                                            <p class="text-2xl md:text-3xl font-black text-blue-700 select-all break-all">{{ $method['email'] }}</p>
                                            @if(!empty($method['accountName']))
                                            <p class="text-gray-600 mt-2">{{ $method['accountName'] }}</p>
                                            @endif
                                            @endif
                                        </div>

                                        <!-- Amount to Pay -->
                                        <div class="text-center bg-blue-50 rounded-lg p-3">
                                            <p class="text-gray-600 text-sm">Dapat Bayaran</p>
                                            <p class="text-2xl md:text-3xl font-black {{ $isPromoActive ? 'text-green-600' : 'text-blue-800' }}">&#8369;{{ number_format($price, 2) }}</p>
                                        </div>
                                    </div>

                                    <!-- Instructions -->
                                    <div class="mt-4 bg-white rounded-xl p-4 border border-blue-100">
                                        @if($method['type'] === 'bank')
                                        <p class="font-bold text-blue-800 mb-3 flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                            Paano Magbayad:
                                        </p>
                                        <ol class="list-decimal list-inside space-y-2 text-gray-700">
                                            <li>Buksan ang iyong <strong>banking app</strong></li>
                                            <li>Pumunta sa <strong>Send Money / Transfer</strong></li>
                                            <li>Piliin ang <strong>Instapay</strong> o <strong>PESONet</strong></li>
                                            <li>Ilagay ang bank details sa itaas</li>
                                            <li>I-confirm at <strong>i-save ang reference number</strong></li>
                                        </ol>
                                        @elseif($method['icon'] === 'gcash')
                                        <p class="font-bold text-blue-800 mb-3 flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                            Paano Magbayad:
                                        </p>
                                        <ol class="list-decimal list-inside space-y-2 text-gray-700">
                                            <li>Buksan ang <strong>GCash app</strong></li>
                                            <li>I-tap ang <strong>Send Money</strong></li>
                                            <li>Ilagay ang number at amount</li>
                                            <li>I-confirm at <strong>i-screenshot ang receipt</strong></li>
                                        </ol>
                                        @elseif($method['icon'] === 'maya')
                                        <p class="font-bold text-blue-800 mb-3 flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                            Paano Magbayad:
                                        </p>
                                        <ol class="list-decimal list-inside space-y-2 text-gray-700">
                                            <li>Buksan ang <strong>Maya app</strong></li>
                                            <li>I-tap ang <strong>Send Money</strong></li>
                                            <li>Ilagay ang number at amount</li>
                                            <li>I-confirm at <strong>i-screenshot ang receipt</strong></li>
                                        </ol>
                                        @elseif($method['icon'] === 'paypal')
                                        <p class="font-bold text-blue-800 mb-3 flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                            Paano Magbayad:
                                        </p>
                                        <ol class="list-decimal list-inside space-y-2 text-gray-700">
                                            <li>Log in sa <strong>PayPal account</strong> mo</li>
                                            <li>I-click ang <strong>Send & Request</strong></li>
                                            <li>Ilagay ang email address sa itaas</li>
                                            <li>Ilagay ang amount at <strong>i-confirm</strong></li>
                                        </ol>
                                        @endif
                                    </div>
                                </div>

                                <!-- QR Code (if available) - Clickable with Lightbox -->
                                @if(!empty($method['qrCode']))
                                <div class="lg:w-56 flex-shrink-0">
                                    <div class="bg-white rounded-xl p-4 border-2 border-blue-100 shadow-sm text-center">
                                        <p class="text-sm font-semibold text-blue-800 mb-3">Scan QR Code</p>
                                        <div class="cursor-pointer hover:opacity-90 transition-opacity"
                                             @click="lightboxImage = '{{ $method['qrCode'] }}'; lightboxOpen = true">
                                            <img src="{{ $method['qrCode'] }}"
                                                 alt="{{ $method['name'] }} QR Code"
                                                 class="w-full h-auto rounded-lg border"
                                                 onerror="this.parentElement.parentElement.parentElement.style.display='none'">
                                            <p class="text-xs text-gray-500 mt-2 flex items-center justify-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                                                I-click para palakihin
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach

                        @if($paymentSettings->instructions)
                        <div class="mt-5 p-4 bg-white rounded-xl border border-blue-200">
                            <p class="text-blue-800 font-medium mb-2">Additional Instructions:</p>
                            <p class="text-gray-700">{!! nl2br(e($paymentSettings->instructions)) !!}</p>
                        </div>
                        @endif
                    </div>

                    <!-- ==================== STEP 2: UPLOAD PAYMENT PROOF ==================== -->
                    <div x-show="form.paymentMethod" class="bg-green-50 border-2 border-green-200 rounded-2xl p-6 mb-6">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center font-bold text-lg">2</div>
                            <h4 class="text-xl font-bold text-green-800">I-upload ang Payment Proof</h4>
                        </div>

                        <p class="text-green-700 mb-5 bg-white rounded-lg p-3 border border-green-200">
                            <svg class="w-5 h-5 inline-block mr-1 -mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                            Pagkatapos magbayad, i-fill up ang form sa baba at i-upload ang screenshot ng iyong payment.
                        </p>

                        <!-- Important Email Notice -->
                        <div class="mb-5 p-3 bg-yellow-50 rounded-lg border border-yellow-300">
                            <p class="text-sm text-yellow-800 flex items-start gap-2">
                                <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                <span><strong>Importante:</strong> Ang login details mo ay ipapadala sa email na inilagay mo: <strong x-text="form.email"></strong></span>
                            </p>
                        </div>

                        <!-- Payment Details Form - Inside Step 2 -->
                        <div class="space-y-5 bg-white rounded-xl p-5 border border-green-200">
                        <div class="grid md:grid-cols-2 gap-5">
                            <div>
                                <label class="form-label">Pangalan ng Nagbayad <span class="text-red-500">*</span></label>
                                <input type="text" x-model="form.senderName" @input="validateField('senderName')"
                                       class="form-input" :class="{'error': errors.senderName}"
                                       placeholder="Juan Dela Cruz">
                                <p x-show="errors.senderName" class="form-error">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    <span x-text="errors.senderName"></span>
                                </p>
                            </div>
                            <div>
                                <label class="form-label">Halaga ng Binayaran <span class="text-red-500">*</span></label>
                                <input type="number" x-model="form.amountPaid" @input="validateField('amountPaid')"
                                       class="form-input" :class="{'error': errors.amountPaid}"
                                       placeholder="{{ number_format($price, 0) }}">
                                <p x-show="errors.amountPaid" class="form-error">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    <span x-text="errors.amountPaid"></span>
                                </p>
                                <p class="form-hint">Dapat bayaran: <strong>&#8369;{{ number_format($price, 2) }}</strong></p>
                            </div>
                        </div>

                        <div>
                            <label class="form-label">Reference Number</label>
                            <input type="text" x-model="form.referenceNumber"
                                   class="form-input"
                                   placeholder="Transaction reference number">
                            <p class="form-hint">Ilagay ang reference number ng iyong transaction (kung meron)</p>
                        </div>

                        <div>
                            <label class="form-label">O kaya, i-upload ang Screenshot ng Payment</label>
                            <div class="upload-area"
                                 :class="{'has-file': uploadedFile, 'dragover': isDragging}"
                                 @click="$refs.fileInput.click()"
                                 @dragover.prevent="isDragging = true"
                                 @dragleave.prevent="isDragging = false"
                                 @drop.prevent="handleFileDrop($event)">
                                <input type="file" x-ref="fileInput" @change="handleFileSelect($event)" accept="image/*" class="hidden">
                                <template x-if="!uploadedFile">
                                    <div>
                                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <p class="text-gray-600 font-medium">I-drag ang screenshot dito o mag-click para pumili</p>
                                        <p class="text-gray-400 text-sm mt-1">PNG, JPG hanggang 5MB</p>
                                    </div>
                                </template>
                                <template x-if="uploadedFile">
                                    <div class="flex items-center gap-3">
                                        <svg class="w-10 h-10 text-brand-green" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/></svg>
                                        <div class="text-left">
                                            <p class="font-medium text-brand-dark" x-text="uploadedFile.name"></p>
                                            <p class="text-sm text-gray-500" x-text="formatFileSize(uploadedFile.size)"></p>
                                        </div>
                                        <button @click.stop="uploadedFile = null; $refs.fileInput.value = ''" class="ml-auto p-2 text-red-500 hover:bg-red-50 rounded-lg">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                            <p x-show="errors.paymentScreenshot" class="form-error">
                                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                <span x-text="errors.paymentScreenshot"></span>
                            </p>
                        </div>

                        <!-- E-Wallet Phone Number (GCash/Maya) -->
                        <div x-show="form.paymentMethod === 'gcash' || form.paymentMethod === 'maya'" x-transition class="bg-blue-50 border border-blue-200 rounded-xl p-5">
                            <h4 class="font-semibold text-blue-800 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                <span x-text="form.paymentMethod === 'gcash' ? 'GCash Details' : 'Maya Details'"></span>
                            </h4>
                            <div>
                                <label class="form-label text-sm">
                                    <span x-text="form.paymentMethod === 'gcash' ? 'GCash Number na Ginamit' : 'Maya Number na Ginamit'"></span>
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" x-model="form.ewalletPhone"
                                       @input="validateField('ewalletPhone')"
                                       class="form-input"
                                       :class="{'error': errors.ewalletPhone, 'success': form.ewalletPhone && !errors.ewalletPhone}"
                                       placeholder="e.g., 09171234567">
                                <p x-show="errors.ewalletPhone" class="form-error">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    <span x-text="errors.ewalletPhone"></span>
                                </p>
                                <p x-show="!errors.ewalletPhone" class="text-blue-600 text-sm mt-2">Kailangan ito para ma-verify ang iyong payment.</p>
                            </div>
                        </div>

                        <!-- Bank Details -->
                        <div x-show="form.paymentMethod === 'bank'" x-transition class="bg-blue-50 border border-blue-200 rounded-xl p-5">
                            <h4 class="font-semibold text-blue-800 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                Your Bank Details (Optional)
                            </h4>
                            <div class="grid md:grid-cols-3 gap-4">
                                <div>
                                    <label class="form-label text-sm">Pangalan ng Bank Mo</label>
                                    <input type="text" x-model="form.bankName"
                                           class="form-input"
                                           placeholder="e.g., BDO, BPI, Metrobank">
                                </div>
                                <div>
                                    <label class="form-label text-sm">Pangalan sa Account Mo</label>
                                    <input type="text" x-model="form.bankAccountName"
                                           class="form-input"
                                           placeholder="Pangalan sa account">
                                </div>
                                <div>
                                    <label class="form-label text-sm">Account Number (last 4 digits)</label>
                                    <input type="text" x-model="form.bankAccountNumber"
                                           class="form-input"
                                           placeholder="e.g., 1234"
                                           maxlength="4">
                                </div>
                            </div>
                            <p class="text-blue-600 text-sm mt-2">Ito ay para mas madali ma-verify ang iyong payment.</p>
                        </div>

                        <!-- Payment Notes -->
                        <div>
                            <label class="form-label">Notes (Optional)</label>
                            <textarea x-model="form.paymentNotes"
                                      class="form-input"
                                      rows="2"
                                      placeholder="Kung may gusto kang idagdag na impormasyon tungkol sa payment..."></textarea>
                        </div>
                        </div><!-- End of white form container -->
                    </div><!-- End of Step 2 green section -->
                    @else
                    <!-- No Payment Methods Configured -->
                    <div class="bg-red-50 border border-red-200 rounded-xl p-6 mb-6 text-center">
                        <svg class="w-12 h-12 text-red-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <h4 class="font-bold text-red-800 mb-2">Payment Methods Unavailable</h4>
                        <p class="text-red-600 text-sm">Sorry, there are no payment methods available at the moment. Please contact support.</p>
                    </div>
                    @endif

                    <div class="mt-8 flex justify-between">
                        <a href="{{ route('checkout.reset') }}" class="inline-flex items-center gap-2 text-gray-600 px-6 py-3 rounded-xl font-medium hover:bg-gray-100 transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            Magsimula Muli
                        </a>
                        <button @click="submitPayment()" :disabled="isLoading || !form.paymentMethod"
                                class="inline-flex items-center gap-2 bg-brand-green text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-brand-green-dark transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                            <span x-show="!isLoading">Kumpletuhin ang Order</span>
                            <span x-show="isLoading" class="flex items-center gap-2">
                                <span class="spinner"></span>
                                Nagsu-submit...
                            </span>
                            <svg x-show="!isLoading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Success State -->
            <div x-show="currentStep === 3" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                <div class="p-8 md:p-12 text-center">
                    <!-- Order Receipt Card (for screenshot) -->
                    <div id="orderReceipt" class="bg-white rounded-2xl shadow-lg p-8 max-w-lg mx-auto mb-8">
                        <!-- Header -->
                        <div class="mb-6">
                            <div class="w-20 h-20 bg-brand-green/10 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-brand-green" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            </div>
                            <h3 class="text-2xl font-bold text-brand-dark">Salamat at Congratulations!</h3>
                            <p class="text-brand-green font-semibold mt-1">Ani-Senso Academy</p>
                        </div>

                        <!-- Order Details -->
                        <div class="border-t border-b border-gray-200 py-4 mb-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-500">Order Number:</span>
                                <span class="font-bold text-brand-dark" x-text="orderNumber"></span>
                            </div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-500">Petsa:</span>
                                <span class="font-medium text-gray-700" x-text="new Date().toLocaleDateString('fil-PH', { year: 'numeric', month: 'long', day: 'numeric' })"></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Email:</span>
                                <span class="font-medium text-gray-700" x-text="confirmationEmail"></span>
                            </div>
                        </div>

                        <!-- Course Info -->
                        <div class="bg-brand-green/5 rounded-xl p-4 mb-4">
                            <p class="font-semibold text-brand-dark">{{ $course->courseTitle ?? 'Course Enrollment' }}</p>
                            <p class="text-brand-green font-bold text-lg">₱{{ number_format($price, 2) }}</p>
                        </div>

                        <!-- Status -->
                        <div class="inline-flex items-center gap-2 bg-yellow-50 text-yellow-700 px-4 py-2 rounded-full text-sm font-medium">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                            Payment Verification Pending
                        </div>
                    </div>

                    <!-- Inspirational Message -->
                    <div class="max-w-xl mx-auto mb-8">
                        <div class="bg-gradient-to-r from-brand-green/10 to-brand-yellow/10 rounded-2xl p-6 border border-brand-green/20">
                            <h4 class="text-xl font-bold text-brand-dark mb-3">Ito ang Simula ng Pagbabago!</h4>
                            <p class="text-gray-600 leading-relaxed">
                                Ginawa mo ang <strong>pinakamahalagang hakbang</strong> para baguhin ang iyong buhay sa pagsasaka.
                                Sa Ani-Senso Academy, matututunan mo ang mga modernong teknik at estratehiya na magpapataas ng iyong ani
                                at kikita. <span class="text-brand-green font-semibold">Maligayang pagdating sa komunidad ng mga matagumpay na magsasaka!</span>
                            </p>
                        </div>
                    </div>

                    <!-- Next Steps Info -->
                    <div class="bg-gray-50 rounded-xl p-5 max-w-lg mx-auto mb-8 text-left">
                        <h4 class="font-bold text-brand-dark mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-brand-green" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                            Ano ang susunod?
                        </h4>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li class="flex items-start gap-2">
                                <span class="text-brand-green font-bold">1.</span>
                                <span>I-ve-verify namin ang payment mo <strong>within 24 hours</strong>.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-brand-green font-bold">2.</span>
                                <span>Makakatanggap ka ng <strong>email confirmation</strong> kasama ang login details.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-brand-green font-bold">3.</span>
                                <span>Maa-access mo na ang <strong>membership portal</strong> at simulan ang pag-aaral!</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col gap-4 max-w-sm mx-auto">
                        <button @click="saveOrderScreenshot()" class="inline-flex items-center justify-center gap-2 bg-brand-green text-white px-6 py-4 rounded-xl font-bold text-lg hover:bg-brand-green-dark transition-all duration-300 shadow-lg hover:shadow-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            I-save ang Order Receipt
                        </button>
                        <a href="{{ url('/') }}" class="inline-flex items-center justify-center gap-2 bg-gray-100 text-gray-700 px-6 py-3 rounded-xl font-medium hover:bg-gray-200 transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Bumalik sa Home
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Badge -->
        <div class="mt-8 text-center">
            <div class="inline-flex items-center gap-2 text-gray-400 text-sm">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                Ang iyong data ay secured at encrypted
            </div>
        </div>

        <!-- QR Code Lightbox Modal -->
        <div x-show="lightboxOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="lightboxOpen = false"
             @keydown.escape.window="lightboxOpen = false"
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4"
             style="display: none;">
            <div class="relative max-w-lg w-full bg-white rounded-2xl p-4 shadow-2xl"
                 @click.stop>
                <!-- Close Button -->
                <button @click="lightboxOpen = false"
                        class="absolute -top-3 -right-3 w-10 h-10 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition-colors z-10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
                <!-- QR Code Image -->
                <div class="text-center">
                    <p class="text-gray-600 font-semibold mb-3">Scan QR Code para Magbayad</p>
                    <img :src="lightboxImage"
                         alt="QR Code"
                         class="w-full h-auto rounded-lg border-2 border-gray-200">
                    <p class="text-sm text-gray-500 mt-3">I-tap ang labas ng image para isara</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- html2canvas library for screenshot -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
function checkoutWizard() {
    return {
        // Recovery mode - for continuing abandoned checkout
        recoveryMode: {{ isset($recoveryMode) && $recoveryMode ? 'true' : 'false' }},
        recoveryOrderNumber: '{{ isset($recoveryOrder) ? $recoveryOrder->orderNumber : '' }}',

        // Server-side step persistence
        serverStep: {{ $serverStep ?? 1 }},
        currentStep: {{ isset($recoveryMode) && $recoveryMode ? '2' : ($serverStep ?? 1) }},
        isLoading: false,
        showPassword: false,
        accountType: 'manual',
        loginMethod: 'email', // 'email' or 'phone'
        isDragging: false,
        uploadedFile: null,
        orderNumber: '{{ isset($recoveryOrder) ? $recoveryOrder->orderNumber : (isset($serverOrderNumber) ? $serverOrderNumber : "") }}',
        confirmationEmail: '{{ isset($recoveryOrder) ? $recoveryOrder->clientEmail : (isset($serverPurchaser) ? ($serverPurchaser["email"] ?? "") : "") }}',
        passwordStrength: 0,
        passwordStrengthText: '',
        passwordStrengthClass: '',

        // Lightbox for QR codes
        lightboxOpen: false,
        lightboxImage: '',

        // Step 2 mode: 'create' or 'login'
        step2Mode: 'create',
        loginCredential: '',
        loginPassword: '',
        loggedInClientName: '',

        // Email existence check
        emailExists: {{ (isset($existingClient) && $existingClient) || (isset($serverEmailExists) && $serverEmailExists) ? 'true' : 'false' }},
        emailCheckLoading: false,
        emailChecked: {{ (isset($recoveryMode) && $recoveryMode) || (isset($serverStep) && $serverStep >= 2) ? 'true' : 'false' }},
        existingUserFirstName: '{{ isset($recoveryOrder) ? addslashes($recoveryOrder->clientFirstName ?? "") : (isset($serverPurchaser) ? addslashes($serverPurchaser["firstName"] ?? "") : "") }}',
        existingUserLastName: '{{ isset($recoveryOrder) ? addslashes($recoveryOrder->clientLastName ?? "") : (isset($serverPurchaser) ? addslashes($serverPurchaser["lastName"] ?? "") : "") }}',
        emailCheckTimeout: null,
        lastCheckedEmail: '{{ isset($recoveryOrder) ? $recoveryOrder->clientEmail : (isset($serverPurchaser) ? ($serverPurchaser["email"] ?? "") : "") }}',

        form: {
            firstName: '{{ isset($recoveryOrder) ? addslashes($recoveryOrder->clientFirstName ?? "") : (isset($serverPurchaser) ? addslashes($serverPurchaser["firstName"] ?? "") : "") }}',
            lastName: '{{ isset($recoveryOrder) ? addslashes($recoveryOrder->clientLastName ?? "") : (isset($serverPurchaser) ? addslashes($serverPurchaser["lastName"] ?? "") : "") }}',
            phone: '{{ isset($recoveryOrder) ? ($recoveryOrder->clientPhone ?? "") : (isset($serverPurchaser) ? ($serverPurchaser["phone"] ?? "") : "") }}',
            email: '{{ isset($recoveryOrder) ? $recoveryOrder->clientEmail : (isset($serverPurchaser) ? ($serverPurchaser["email"] ?? "") : "") }}',
            accountEmail: '',
            accountPhone: '',
            password: '',
            passwordConfirmation: '',
            paymentMethod: '',
            referenceNumber: '',
            senderName: '{{ isset($recoveryOrder) ? addslashes(trim(($recoveryOrder->clientFirstName ?? "") . " " . ($recoveryOrder->clientLastName ?? ""))) : (isset($serverPurchaser) ? addslashes(trim(($serverPurchaser["firstName"] ?? "") . " " . ($serverPurchaser["lastName"] ?? ""))) : "") }}',
            amountPaid: '',
            bankName: '',
            bankAccountName: '',
            bankAccountNumber: '',
            ewalletPhone: '',
            paymentNotes: '',
            exitPrice: '{{ $exitPrice ?? "" }}'
        },

        errors: {
            firstName: '',
            lastName: '',
            phone: '',
            email: '',
            accountEmail: '',
            accountPhone: '',
            password: '',
            passwordConfirmation: '',
            senderName: '',
            amountPaid: '',
            paymentScreenshot: '',
            ewalletPhone: '',
        },

        // Computed property: show registration fields for new emails
        // Only shows after email check completes and confirms it's a new email
        get showRegistrationFields() {
            return this.emailChecked &&
                   !this.emailExists &&
                   !this.emailCheckLoading &&
                   this.form.email &&
                   this.form.email.trim() &&
                   this.isValidEmail(this.form.email) &&
                   !this.errors.email;
        },

        // Computed property: existing user's full name
        get existingUserFullName() {
            if (this.existingUserFirstName && this.existingUserLastName) {
                return this.existingUserFirstName + ' ' + this.existingUserLastName;
            }
            return this.existingUserFirstName || '';
        },

        // Check if can proceed from Step 1
        canProceedStep1() {
            // Must have valid email
            if (!this.form.email || !this.form.email.trim() || this.errors.email) {
                return false;
            }

            // If existing account, just need email
            if (this.emailExists) {
                return true;
            }

            // For new accounts, validate all registration fields
            if (!this.form.firstName || !this.form.firstName.trim()) return false;
            if (!this.form.lastName || !this.form.lastName.trim()) return false;
            if (!this.form.phone || !this.form.phone.trim() || !this.isValidPhone(this.form.phone)) return false;
            if (!this.form.password || this.form.password.length < 8) return false;
            if (this.form.password !== this.form.passwordConfirmation) return false;

            return true;
        },

        // Scroll to registration fields on mobile
        scrollToRegistrationFields() {
            this.$nextTick(() => {
                const el = document.getElementById('registration-fields');
                if (el && window.innerWidth < 768) {
                    setTimeout(() => {
                        el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }, 100);
                }
            });
        },

        validateField(field) {
            this.errors[field] = '';

            switch(field) {
                case 'firstName':
                    if (!this.form.firstName.trim()) {
                        this.errors.firstName = 'Kailangan ang first name.';
                    }
                    break;
                case 'lastName':
                    if (!this.form.lastName.trim()) {
                        this.errors.lastName = 'Kailangan ang last name.';
                    }
                    break;
                case 'phone':
                case 'accountPhone':
                    const phone = field === 'phone' ? this.form.phone : this.form.accountPhone;
                    if (!phone.trim()) {
                        this.errors[field] = 'Kailangan ang phone number.';
                    } else if (!this.isValidPhone(phone)) {
                        this.errors[field] = 'Invalid format. Gamitin: 09XXXXXXXXX, 639XXXXXXXXX, o +639XXXXXXXXX';
                    }
                    break;
                case 'email':
                case 'accountEmail':
                    const email = field === 'email' ? this.form.email : this.form.accountEmail;
                    if (!email.trim()) {
                        this.errors[field] = 'Kailangan ang email.';
                    } else if (!this.isValidEmail(email)) {
                        this.errors[field] = 'Invalid email format.';
                    }
                    break;
                case 'password':
                    if (!this.form.password) {
                        this.errors.password = 'Kailangan ang password.';
                    } else if (this.form.password.length < 8) {
                        this.errors.password = 'Minimum 8 characters ang password.';
                    }
                    break;
                case 'passwordConfirmation':
                    if (!this.form.passwordConfirmation) {
                        this.errors.passwordConfirmation = 'I-confirm ang password.';
                    } else if (this.form.password !== this.form.passwordConfirmation) {
                        this.errors.passwordConfirmation = 'Hindi tugma ang password.';
                    }
                    break;
                case 'senderName':
                    if (!this.form.senderName.trim()) {
                        this.errors.senderName = 'Kailangan ang pangalan ng nagbayad.';
                    }
                    break;
                case 'amountPaid':
                    if (!this.form.amountPaid) {
                        this.errors.amountPaid = 'Kailangan ang halaga.';
                    } else if (parseFloat(this.form.amountPaid) <= 0) {
                        this.errors.amountPaid = 'Invalid amount.';
                    }
                    break;
                case 'ewalletPhone':
                    // Only validate if payment method is gcash or maya
                    if (this.form.paymentMethod === 'gcash' || this.form.paymentMethod === 'maya') {
                        if (!this.form.ewalletPhone.trim()) {
                            this.errors.ewalletPhone = this.form.paymentMethod === 'gcash'
                                ? 'Kailangan ang GCash number.'
                                : 'Kailangan ang Maya number.';
                        } else if (!this.isValidPhone(this.form.ewalletPhone)) {
                            this.errors.ewalletPhone = 'Invalid phone format. Use 09XXXXXXXXX.';
                        }
                    }
                    break;
                case 'referenceOrScreenshot':
                    // Either reference number or screenshot is required
                    if (!this.form.referenceNumber.trim() && !this.uploadedFile) {
                        this.errors.paymentScreenshot = 'Kailangan ang reference number o screenshot.';
                    } else {
                        this.errors.paymentScreenshot = '';
                    }
                    break;
            }
        },

        isValidPhone(phone) {
            return /^(\+?63|0)?9\d{9}$/.test(phone.replace(/[\s-]/g, ''));
        },

        isValidEmail(email) {
            // Basic structure check - must have @ and domain with TLD (letters only, 2+ chars)
            const basicPattern = /^[^\s@]+@[^\s@]+\.[a-zA-Z]{2,}$/;
            if (!basicPattern.test(email)) {
                return false;
            }

            // Extract TLD (everything after the last dot)
            const tld = email.split('.').pop().toLowerCase();

            // Reject TLDs that are too long (most valid TLDs are under 15 chars)
            if (tld.length > 15) {
                return false;
            }

            // Detect common typo patterns: valid TLD + accidental extra chars
            // This catches things like "comse", "netorg", "orgph", "ioph", etc.
            const typoPattern = /^(com|net|org|edu|gov|io|co)[a-z]{2,3}$/;
            if (typoPattern.test(tld)) {
                return false;
            }

            return true;
        },

        // Check if email already exists as a user
        async checkEmailExists() {
            const email = this.form.email.trim().toLowerCase();

            // Clear any pending check
            if (this.emailCheckTimeout) {
                clearTimeout(this.emailCheckTimeout);
                this.emailCheckTimeout = null;
            }

            // For invalid/empty email, reset everything immediately
            if (!email || !this.isValidEmail(this.form.email)) {
                this.emailExists = false;
                this.emailChecked = false;
                this.existingUserFirstName = '';
                this.existingUserLastName = '';
                this.lastCheckedEmail = '';
                return;
            }

            // If we already checked this exact email, no need to check again
            if (email === this.lastCheckedEmail && this.emailChecked) {
                return;
            }

            // Show loading indicator immediately when email changes
            this.emailCheckLoading = true;

            // Debounce the actual API call
            this.emailCheckTimeout = setTimeout(async () => {
                try {
                    const response = await fetch('{{ route("checkout.check-email") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ email: email })
                    });

                    const data = await response.json();

                    // Only update state if the email hasn't changed while we were waiting
                    const currentEmail = this.form.email.trim().toLowerCase();
                    if (currentEmail === email) {
                        this.emailExists = data.exists;
                        this.existingUserFirstName = data.firstName || '';
                        this.existingUserLastName = data.lastName || '';
                        this.emailChecked = true;
                        this.lastCheckedEmail = email;
                        this.emailCheckLoading = false;

                        // If new email (not existing), scroll to registration fields on mobile
                        if (!data.exists) {
                            this.scrollToRegistrationFields();
                        }
                    }
                } catch (error) {
                    console.error('Email check error:', error);
                    // On error, allow retry
                    this.emailCheckLoading = false;
                    this.emailChecked = false;
                }
            }, 400);
        },

        checkPasswordStrength() {
            const password = this.form.password;
            let strength = 0;

            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            if (/\d/.test(password)) strength++;
            if (/[^a-zA-Z0-9]/.test(password)) strength++;

            this.passwordStrength = strength;

            const labels = ['', 'Mahina', 'Katamtaman', 'Malakas', 'Napakalakas'];
            const classes = ['', 'weak', 'fair', 'good', 'strong'];

            this.passwordStrengthText = labels[strength] || '';
            this.passwordStrengthClass = classes[strength] || '';
        },

        // Password validation helpers
        hasMinLength() {
            return this.form.password.length >= 8;
        },
        hasUppercase() {
            return /[A-Z]/.test(this.form.password);
        },
        hasLowercase() {
            return /[a-z]/.test(this.form.password);
        },
        hasNumber() {
            return /[0-9]/.test(this.form.password);
        },
        hasSpecialChar() {
            return /[^a-zA-Z0-9]/.test(this.form.password);
        },

        // Login with existing account
        async loginExisting() {
            // Clear previous errors
            this.errors.loginCredential = '';
            this.errors.loginPassword = '';

            if (!this.loginCredential) {
                this.errors.loginCredential = 'Kailangan ang email o phone number.';
                return;
            }

            // Auto-detect if credential is email or phone
            const isEmail = this.loginCredential.includes('@');
            const isPhone = /^[0-9+\s-]+$/.test(this.loginCredential.trim());

            // Validate format based on detected type
            if (isEmail && !this.isValidEmail(this.loginCredential)) {
                this.errors.loginCredential = 'Hindi valid ang email address.';
                return;
            }
            if (!isEmail && isPhone && !this.isValidPhone(this.loginCredential)) {
                this.errors.loginCredential = 'Hindi valid ang phone number.';
                return;
            }
            if (!isEmail && !isPhone) {
                this.errors.loginCredential = 'Maglagay ng valid na email o phone number.';
                return;
            }

            if (!this.loginPassword) {
                this.errors.loginPassword = 'Kailangan ang password.';
                return;
            }

            this.isLoading = true;

            try {
                const response = await fetch('{{ route("checkout.login") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        credential: this.loginCredential,
                        password: this.loginPassword
                    })
                });

                const data = await response.json();

                if (data.success) {
                    this.loggedInClientName = data.clientName;
                    this.currentStep = 3;
                } else {
                    this.errors.loginPassword = data.message || 'Login failed.';
                }
            } catch (error) {
                console.error('Error:', error);
                this.errors.loginPassword = 'May error sa connection. Subukan ulit.';
            } finally {
                this.isLoading = false;
            }
        },

        async submitStep1() {
            // Validate email first
            this.validateField('email');
            if (this.errors.email) {
                return;
            }

            // For new accounts, validate all registration fields
            if (!this.emailExists) {
                const fieldsToValidate = ['firstName', 'lastName', 'phone', 'password', 'passwordConfirmation'];
                fieldsToValidate.forEach(f => this.validateField(f));

                if (Object.values(this.errors).some(e => e)) {
                    return;
                }
            }

            this.isLoading = true;

            try {
                // Build request data
                const requestData = {
                    email: this.form.email,
                    emailExists: this.emailExists,
                    exitPrice: this.form.exitPrice
                };

                // Add registration data for new accounts
                if (!this.emailExists) {
                    requestData.firstName = this.form.firstName;
                    requestData.lastName = this.form.lastName;
                    requestData.phone = this.form.phone;
                    requestData.password = this.form.password;
                    requestData.password_confirmation = this.form.passwordConfirmation;
                }

                const response = await fetch('{{ route("checkout.step1") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(requestData)
                });

                const data = await response.json();

                if (data.success) {
                    this.orderNumber = data.orderNumber;
                    // Redirect to step 2 page (preserves state on refresh)
                    if (data.redirectUrl) {
                        window.location.href = data.redirectUrl;
                        return;
                    }
                    // Fallback: just update current step
                    this.currentStep = 2;
                } else {
                    if (data.errors) {
                        this.errors = {...this.errors, ...this.flattenErrors(data.errors)};
                    } else {
                        alert(data.message || 'May error. Subukan ulit.');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                alert('May error sa connection. Subukan ulit.');
            } finally {
                this.isLoading = false;
            }
        },

        async submitPayment() {
            // Validate required fields
            ['senderName', 'amountPaid'].forEach(f => this.validateField(f));

            // Validate reference number or screenshot (one is required)
            this.validateField('referenceOrScreenshot');

            // Validate e-wallet phone for GCash/Maya
            if (this.form.paymentMethod === 'gcash' || this.form.paymentMethod === 'maya') {
                this.validateField('ewalletPhone');
            }

            if (Object.values(this.errors).some(e => e)) {
                return;
            }

            this.isLoading = true;

            try {
                const formData = new FormData();
                formData.append('paymentMethod', this.form.paymentMethod);
                formData.append('referenceNumber', this.form.referenceNumber);
                formData.append('senderName', this.form.senderName);
                formData.append('amountPaid', this.form.amountPaid);
                formData.append('paymentNotes', this.form.paymentNotes);

                // E-wallet phone for GCash/Maya
                if (this.form.paymentMethod === 'gcash' || this.form.paymentMethod === 'maya') {
                    formData.append('ewalletPhone', this.form.ewalletPhone);
                }

                // Bank details for Bank Transfer
                if (this.form.paymentMethod === 'bank') {
                    formData.append('bankName', this.form.bankName);
                    formData.append('bankAccountName', this.form.bankAccountName);
                    formData.append('bankAccountNumber', this.form.bankAccountNumber);
                }

                if (this.uploadedFile) {
                    formData.append('paymentScreenshot', this.uploadedFile);
                }

                const response = await fetch('{{ route("checkout.step3") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    // Redirect to unique confirmation page
                    if (data.redirectUrl) {
                        window.location.href = data.redirectUrl;
                    } else {
                        // Fallback to inline step 3 if no redirect URL
                        this.orderNumber = data.orderNumber;
                        this.confirmationEmail = data.email;
                        this.currentStep = 3;
                    }
                } else {
                    if (data.errors) {
                        this.errors = {...this.errors, ...this.flattenErrors(data.errors)};
                    } else {
                        alert(data.message || 'May error. Subukan ulit.');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                alert('May error sa connection. Subukan ulit.');
            } finally {
                this.isLoading = false;
            }
        },

        flattenErrors(errors) {
            const flat = {};
            for (const key in errors) {
                flat[key] = Array.isArray(errors[key]) ? errors[key][0] : errors[key];
            }
            return flat;
        },

        handleFileSelect(event) {
            const file = event.target.files[0];
            if (file && file.type.startsWith('image/')) {
                this.uploadedFile = file;
                this.errors.paymentScreenshot = '';
            }
        },

        handleFileDrop(event) {
            this.isDragging = false;
            const file = event.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                this.uploadedFile = file;
                this.errors.paymentScreenshot = '';
            }
        },

        formatFileSize(bytes) {
            if (bytes < 1024) return bytes + ' B';
            if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
            return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
        },

        async saveOrderScreenshot() {
            const receiptElement = document.getElementById('orderReceipt');
            if (!receiptElement) return;

            try {
                // Use html2canvas to capture the receipt
                const canvas = await html2canvas(receiptElement, {
                    backgroundColor: '#ffffff',
                    scale: 2, // Higher quality
                    useCORS: true,
                    logging: false
                });

                // Convert to image and download
                const link = document.createElement('a');
                link.download = `Ani-Senso-Order-${this.orderNumber}.png`;
                link.href = canvas.toDataURL('image/png');
                link.click();
            } catch (error) {
                console.error('Error saving screenshot:', error);
                alert('Hindi ma-save ang screenshot. Subukan ulit.');
            }
        }
    };
}
</script>
@endpush
