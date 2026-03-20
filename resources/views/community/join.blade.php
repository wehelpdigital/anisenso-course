@extends('layouts.landing')

@section('title', 'Sumali sa AniSenso Community - Libre Lang! | AniSenso Academy')

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
    .form-select:disabled {
        background-color: #f9fafb;
        cursor: not-allowed;
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
    .checkbox-card input[type="checkbox"] {
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
    .benefit-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }
    .benefit-icon {
        width: 24px;
        height: 24px;
        flex-shrink: 0;
        color: #4a7c2a;
    }
    .step-badge {
        background: linear-gradient(135deg, #4a7c2a 0%, #3d6823 100%);
    }
</style>
@endpush

@section('content')
<!-- Minimal Header -->
<header class="bg-brand-dark">
    <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
        <a href="{{ url('/') }}" class="flex items-center gap-2">
            <img src="http://anisenso.test/wp-content/uploads/2025/12/test-logo-big-2-scaled.png" alt="AniSenso" class="h-8 w-auto">
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

            <!-- Left Column: Benefits & Info -->
            <div class="lg:sticky lg:top-8">
                <!-- Free Badge -->
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

                <!-- Step Indicator -->
                <div class="bg-brand-dark text-white rounded-2xl p-6 mb-8">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="step-badge w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-lg">1</div>
                        <div>
                            <p class="text-brand-yellow font-bold">STEP 1 OF 2</p>
                            <p class="text-white/70 text-sm">Sagutan ang form na ito</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 opacity-50">
                        <div class="w-10 h-10 rounded-full border-2 border-white/30 flex items-center justify-center text-white/50 font-bold text-lg">2</div>
                        <div>
                            <p class="text-white/50 font-bold">STEP 2</p>
                            <p class="text-white/40 text-sm">Kumpletuhin ang profile at access ang courses</p>
                        </div>
                    </div>
                </div>

                <!-- Benefits List -->
                <div class="space-y-5 mb-8">
                    <h3 class="text-lg font-bold text-brand-dark">Ano ang makukuha mo (LIBRE):</h3>

                    <div class="benefit-item">
                        <svg class="benefit-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        <div>
                            <p class="font-semibold text-gray-800">Access sa Free Video Lessons</p>
                            <p class="text-gray-500 text-sm">Matuto ng modern farming techniques sa sarili mong oras</p>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <svg class="benefit-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        <div>
                            <p class="font-semibold text-gray-800">Private Facebook Community</p>
                            <p class="text-gray-500 text-sm">Makipag-connect sa 10,000+ farmers sa buong Pilipinas</p>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <svg class="benefit-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div>
                            <p class="font-semibold text-gray-800">Expert Support</p>
                            <p class="text-gray-500 text-sm">Magtanong at makakuha ng sagot mula sa mga expert agriculturist</p>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <svg class="benefit-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/></svg>
                        <div>
                            <p class="font-semibold text-gray-800">Exclusive Discounts</p>
                            <p class="text-gray-500 text-sm">Special prices sa Rhizocote at iba pang AniSenso products</p>
                        </div>
                    </div>
                </div>

                <!-- Trust Indicators -->
                <div class="flex flex-wrap items-center gap-6 text-gray-500 text-sm border-t border-gray-200 pt-6">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand-green" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        100% Secure
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand-green" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        10,000+ Members
                    </div>
                </div>

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

            <!-- Right Column: Form -->
            <div>
                <div class="bg-gradient-to-br from-brand-green/5 via-white to-brand-yellow/5 rounded-3xl shadow-xl shadow-brand-green/10 border-2 border-brand-green/20 overflow-hidden"
                     id="join-form">

                    <form @submit.prevent="submitForm">

                        <!-- Section 1: Personal Info -->
                        <div class="p-6 md:p-8">
                            <h2 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-5">Personal Information</h2>

                            <div class="space-y-4">
                                <!-- Name -->
                                <div>
                                    <label for="name" class="form-label">Pangalan <span class="text-red-500">*</span></label>
                                    <input type="text" id="name" x-model="formData.name" required
                                           class="form-input" placeholder="Juan Dela Cruz">
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="form-label">Phone Number <span class="text-red-500">*</span></label>
                                    <input type="tel" id="phone" x-model="formData.phone" required
                                           class="form-input" placeholder="09171234567">
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="form-label">Email Address <span class="text-red-500">*</span></label>
                                    <input type="email" id="email" x-model="formData.email" required
                                           class="form-input" placeholder="juan@email.com">
                                </div>
                            </div>
                        </div>

                        <div class="section-divider mx-6 md:mx-8"></div>

                        <!-- Section 2: Location -->
                        <div class="p-6 md:p-8 pt-0">
                            <h2 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-5">Location</h2>

                            <div class="space-y-4">
                                <!-- Province -->
                                <div>
                                    <label for="province" class="form-label">Province <span class="text-red-500">*</span></label>
                                    <select id="province" x-model="formData.province" @change="updateCities()" required class="form-select">
                                        <option value="">Pumili ng Province</option>
                                        <template x-for="province in provinces" :key="province.name">
                                            <option :value="province.name" x-text="province.name"></option>
                                        </template>
                                    </select>
                                </div>

                                <!-- Town/City -->
                                <div>
                                    <label for="city" class="form-label">Town/City <span class="text-red-500">*</span></label>
                                    <select id="city" x-model="formData.city" required class="form-select" :disabled="!formData.province">
                                        <option value="">Pumili ng Town/City</option>
                                        <template x-for="city in cities" :key="city">
                                            <option :value="city" x-text="city"></option>
                                        </template>
                                    </select>
                                    <p x-show="!formData.province" class="text-gray-400 text-sm mt-2">Pumili muna ng province</p>
                                </div>
                            </div>
                        </div>

                        <div class="section-divider mx-6 md:mx-8"></div>

                        <!-- Section 3: Farm Info -->
                        <div class="p-6 md:p-8 pt-0">
                            <h2 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-5">Farm Information</h2>

                            <div class="space-y-5">
                                <!-- Hectares -->
                                <div>
                                    <label for="hectares" class="form-label">Ilang Hectares ang Iyong Farm? <span class="text-red-500">*</span></label>
                                    <select id="hectares" x-model="formData.hectares" required class="form-select">
                                        <option value="">Pumili ng laki</option>
                                        <option value="below-1">Mas mababa sa 1 hectare</option>
                                        <option value="1-2">1 - 2 hectares</option>
                                        <option value="3-5">3 - 5 hectares</option>
                                        <option value="6-10">6 - 10 hectares</option>
                                        <option value="11-20">11 - 20 hectares</option>
                                        <option value="above-20">Higit sa 20 hectares</option>
                                    </select>
                                </div>

                                <!-- Crops -->
                                <div>
                                    <label class="form-label">Anong Crops ang Tinataniman Mo? <span class="text-red-500">*</span></label>
                                    <p class="text-gray-400 text-sm mb-3">Pwedeng marami ang piliin</p>

                                    <div class="grid grid-cols-2 gap-2">
                                        <label class="checkbox-card">
                                            <input type="checkbox" value="Palay/Rice" x-model="formData.crops">
                                            <span class="text-gray-700 font-medium text-sm">Palay / Rice</span>
                                        </label>
                                        <label class="checkbox-card">
                                            <input type="checkbox" value="Mais/Corn" x-model="formData.crops">
                                            <span class="text-gray-700 font-medium text-sm">Mais / Corn</span>
                                        </label>
                                        <label class="checkbox-card">
                                            <input type="checkbox" value="Gulay/Vegetables" x-model="formData.crops">
                                            <span class="text-gray-700 font-medium text-sm">Gulay</span>
                                        </label>
                                        <label class="checkbox-card">
                                            <input type="checkbox" value="Prutas/Fruits" x-model="formData.crops">
                                            <span class="text-gray-700 font-medium text-sm">Prutas</span>
                                        </label>
                                        <label class="checkbox-card">
                                            <input type="checkbox" value="Niyog/Coconut" x-model="formData.crops">
                                            <span class="text-gray-700 font-medium text-sm">Niyog</span>
                                        </label>
                                        <label class="checkbox-card">
                                            <input type="checkbox" value="Iba pa" x-model="formData.crops">
                                            <span class="text-gray-700 font-medium text-sm">Iba pa</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Section -->
                        <div class="bg-gray-50 p-6 md:p-8">
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

                            <!-- Terms and Email Consent -->
                            <div class="mt-5 text-center">
                                <p class="text-gray-500 text-sm leading-relaxed">
                                    Sa pag-submit ng form na ito, sumasang-ayon ka na makatanggap ng mga email mula sa AniSenso tungkol sa updates, tips, at offers. Pwede kang mag-unsubscribe anumang oras.
                                </p>
                            </div>
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
        <p class="text-gray-500 mb-8 leading-relaxed">Makakatanggap ka ng email confirmation at instructions kung paano ma-access ang community at courses.</p>
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
        formData: {
            name: '',
            phone: '',
            email: '',
            province: '',
            city: '',
            hectares: '',
            crops: []
        },
        cities: [],
        isSubmitting: false,
        showSuccess: false,

        provinces: [
            { name: 'Abra', cities: ['Bangued', 'Boliney', 'Bucay', 'Bucloc', 'Daguioman', 'Danglas', 'Dolores', 'La Paz', 'Lacub', 'Lagangilang', 'Lagayan', 'Langiden', 'Licuan-Baay', 'Luba', 'Malibcong', 'Manabo', 'Penarrubia', 'Pidigan', 'Pilar', 'Sallapadan', 'San Isidro', 'San Juan', 'San Quintin', 'Tayum', 'Tineg', 'Tubo', 'Villaviciosa'] },
            { name: 'Agusan del Norte', cities: ['Butuan City', 'Cabadbaran City', 'Buenavista', 'Carmen', 'Jabonga', 'Kitcharao', 'Las Nieves', 'Magallanes', 'Nasipit', 'Remedios T. Romualdez', 'Santiago', 'Tubay'] },
            { name: 'Agusan del Sur', cities: ['Bayugan City', 'Bunawan', 'Esperanza', 'La Paz', 'Loreto', 'Prosperidad', 'Rosario', 'San Francisco', 'San Luis', 'Santa Josefa', 'Sibagat', 'Talacogon', 'Trento', 'Veruela'] },
            { name: 'Aklan', cities: ['Kalibo', 'Altavas', 'Balete', 'Banga', 'Batan', 'Buruanga', 'Ibajay', 'Lezo', 'Libacao', 'Madalag', 'Makato', 'Malay', 'Malinao', 'Nabas', 'New Washington', 'Numancia', 'Tangalan'] },
            { name: 'Albay', cities: ['Legazpi City', 'Ligao City', 'Tabaco City', 'Bacacay', 'Camalig', 'Daraga', 'Guinobatan', 'Jovellar', 'Libon', 'Malilipot', 'Malinao', 'Manito', 'Oas', 'Pio Duran', 'Polangui', 'Rapu-Rapu', 'Santo Domingo', 'Tiwi'] },
            { name: 'Antique', cities: ['San Jose de Buenavista', 'Anini-y', 'Barbaza', 'Belison', 'Bugasong', 'Caluya', 'Culasi', 'Hamtic', 'Laua-an', 'Libertad', 'Pandan', 'Patnongon', 'San Remigio', 'Sebaste', 'Sibalom', 'Tibiao', 'Tobias Fornier', 'Valderrama'] },
            { name: 'Apayao', cities: ['Calanasan', 'Conner', 'Flora', 'Kabugao', 'Luna', 'Pudtol', 'Santa Marcela'] },
            { name: 'Aurora', cities: ['Baler', 'Casiguran', 'Dilasag', 'Dinalungan', 'Dingalan', 'Dipaculao', 'Maria Aurora', 'San Luis'] },
            { name: 'Bataan', cities: ['Balanga City', 'Abucay', 'Bagac', 'Dinalupihan', 'Hermosa', 'Limay', 'Mariveles', 'Morong', 'Orani', 'Orion', 'Pilar', 'Samal'] },
            { name: 'Batangas', cities: ['Batangas City', 'Lipa City', 'Tanauan City', 'Santo Tomas City', 'Agoncillo', 'Alitagtag', 'Balayan', 'Balete', 'Bauan', 'Calaca', 'Calatagan', 'Cuenca', 'Ibaan', 'Laurel', 'Lemery', 'Lian', 'Lobo', 'Mabini', 'Malvar', 'Mataasnakahoy', 'Nasugbu', 'Padre Garcia', 'Rosario', 'San Jose', 'San Juan', 'San Luis', 'San Nicolas', 'San Pascual', 'Santa Teresita', 'Taal', 'Talisay', 'Taysan', 'Tingloy', 'Tuy'] },
            { name: 'Benguet', cities: ['Baguio City', 'La Trinidad', 'Atok', 'Bakun', 'Bokod', 'Buguias', 'Itogon', 'Kabayan', 'Kapangan', 'Kibungan', 'Mankayan', 'Sablan', 'Tuba', 'Tublay'] },
            { name: 'Bulacan', cities: ['Malolos City', 'Meycauayan City', 'San Jose del Monte City', 'Angat', 'Balagtas', 'Baliuag', 'Bocaue', 'Bulakan', 'Bustos', 'Calumpit', 'Dona Remedios Trinidad', 'Guiguinto', 'Hagonoy', 'Marilao', 'Norzagaray', 'Obando', 'Pandi', 'Paombong', 'Plaridel', 'Pulilan', 'San Ildefonso', 'San Miguel', 'San Rafael', 'Santa Maria'] },
            { name: 'Cagayan', cities: ['Tuguegarao City', 'Abulug', 'Alcala', 'Allacapan', 'Amulung', 'Aparri', 'Baggao', 'Ballesteros', 'Buguey', 'Calayan', 'Camalaniugan', 'Claveria', 'Enrile', 'Gattaran', 'Gonzaga', 'Iguig', 'Lal-lo', 'Lasam', 'Pamplona', 'Penablanca', 'Piat', 'Rizal', 'Sanchez-Mira', 'Santa Ana', 'Santa Praxedes', 'Santa Teresita', 'Santo Nino', 'Solana', 'Tuao'] },
            { name: 'Camarines Sur', cities: ['Naga City', 'Iriga City', 'Baao', 'Balatan', 'Bato', 'Bombon', 'Buhi', 'Bula', 'Cabusao', 'Calabanga', 'Camaligan', 'Canaman', 'Caramoan', 'Del Gallego', 'Gainza', 'Garchitorena', 'Goa', 'Lagonoy', 'Libmanan', 'Lupi', 'Magarao', 'Milaor', 'Minalabac', 'Nabua', 'Ocampo', 'Pamplona', 'Pasacao', 'Pili', 'Presentacion', 'Ragay', 'Sagnay', 'San Fernando', 'San Jose', 'Sipocot', 'Siruma', 'Tigaon', 'Tinambac'] },
            { name: 'Cavite', cities: ['Bacoor City', 'Cavite City', 'Dasmarinas City', 'General Trias City', 'Imus City', 'Tagaytay City', 'Trece Martires City', 'Alfonso', 'Amadeo', 'Carmona', 'General Emilio Aguinaldo', 'General Mariano Alvarez', 'Indang', 'Kawit', 'Magallanes', 'Maragondon', 'Mendez', 'Naic', 'Noveleta', 'Rosario', 'Silang', 'Tanza', 'Ternate'] },
            { name: 'Cebu', cities: ['Cebu City', 'Lapu-Lapu City', 'Mandaue City', 'Bogo City', 'Carcar City', 'Danao City', 'Naga City', 'Talisay City', 'Toledo City', 'Alcantara', 'Alcoy', 'Alegria', 'Aloguinsan', 'Argao', 'Asturias', 'Badian', 'Balamban', 'Bantayan', 'Barili', 'Boljoon', 'Borbon', 'Carmen', 'Catmon', 'Compostela', 'Consolacion', 'Cordova', 'Daanbantayan', 'Dalaguete', 'Dumanjug', 'Ginatilan', 'Liloan', 'Madridejos', 'Malabuyoc', 'Medellin', 'Minglanilla', 'Moalboal', 'Oslob', 'Pilar', 'Pinamungajan', 'Poro', 'Ronda', 'Samboan', 'San Fernando', 'San Francisco', 'San Remigio', 'Santa Fe', 'Santander', 'Sibonga', 'Sogod', 'Tabogon', 'Tabuelan', 'Tuburan', 'Tudela'] },
            { name: 'Davao del Norte', cities: ['Tagum City', 'Panabo City', 'Samal City', 'Asuncion', 'Braulio E. Dujali', 'Carmen', 'Kapalong', 'New Corella', 'San Isidro', 'Santo Tomas', 'Talaingod'] },
            { name: 'Davao del Sur', cities: ['Digos City', 'Bansalan', 'Don Marcelino', 'Hagonoy', 'Jose Abad Santos', 'Kiblawan', 'Magsaysay', 'Malalag', 'Matanao', 'Padada', 'Santa Cruz', 'Sulop'] },
            { name: 'Ilocos Norte', cities: ['Laoag City', 'Batac City', 'Adams', 'Bacarra', 'Badoc', 'Bangui', 'Banna', 'Burgos', 'Carasi', 'Currimao', 'Dingras', 'Dumalneg', 'Marcos', 'Nueva Era', 'Pagudpud', 'Paoay', 'Pasuquin', 'Piddig', 'Pinili', 'San Nicolas', 'Sarrat', 'Solsona', 'Vintar'] },
            { name: 'Ilocos Sur', cities: ['Vigan City', 'Candon City', 'Alilem', 'Banayoyo', 'Bantay', 'Burgos', 'Cabugao', 'Caoayan', 'Cervantes', 'Galimuyod', 'Gregorio del Pilar', 'Lidlidda', 'Magsingal', 'Nagbukel', 'Narvacan', 'Quirino', 'Salcedo', 'San Emilio', 'San Esteban', 'San Ildefonso', 'San Juan', 'San Vicente', 'Santa', 'Santa Catalina', 'Santa Cruz', 'Santa Lucia', 'Santa Maria', 'Santiago', 'Santo Domingo', 'Sigay', 'Sinait', 'Sugpon', 'Suyo', 'Tagudin'] },
            { name: 'Iloilo', cities: ['Iloilo City', 'Passi City', 'Ajuy', 'Alimodian', 'Anilao', 'Badiangan', 'Balasan', 'Banate', 'Barotac Nuevo', 'Barotac Viejo', 'Batad', 'Bingawan', 'Cabatuan', 'Calinog', 'Carles', 'Concepcion', 'Dingle', 'Duenas', 'Dumangas', 'Estancia', 'Guimbal', 'Igbaras', 'Janiuay', 'Lambunao', 'Leganes', 'Lemery', 'Leon', 'Maasin', 'Miagao', 'Mina', 'New Lucena', 'Oton', 'Pavia', 'Pototan', 'San Dionisio', 'San Enrique', 'San Joaquin', 'San Miguel', 'San Rafael', 'Santa Barbara', 'Sara', 'Tigbauan', 'Tubungan', 'Zarraga'] },
            { name: 'Isabela', cities: ['Ilagan City', 'Cauayan City', 'Santiago City', 'Alicia', 'Angadanan', 'Aurora', 'Benito Soliven', 'Burgos', 'Cabagan', 'Cabatuan', 'Cordon', 'Delfin Albano', 'Dinapigue', 'Divilacan', 'Echague', 'Gamu', 'Jones', 'Luna', 'Maconacon', 'Mallig', 'Naguilian', 'Palanan', 'Quezon', 'Quirino', 'Ramon', 'Reina Mercedes', 'Roxas', 'San Agustin', 'San Guillermo', 'San Isidro', 'San Manuel', 'San Mariano', 'San Mateo', 'San Pablo', 'Santa Maria', 'Santo Tomas', 'Tumauini'] },
            { name: 'La Union', cities: ['San Fernando City', 'Agoo', 'Aringay', 'Bacnotan', 'Bagulin', 'Balaoan', 'Bangar', 'Bauang', 'Burgos', 'Caba', 'Luna', 'Naguilian', 'Pugo', 'Rosario', 'San Gabriel', 'San Juan', 'Santo Tomas', 'Santol', 'Sudipen', 'Tubao'] },
            { name: 'Laguna', cities: ['Santa Cruz', 'Calamba City', 'San Pablo City', 'Binan City', 'Cabuyao City', 'San Pedro City', 'Santa Rosa City', 'Alaminos', 'Bay', 'Calauan', 'Cavinti', 'Famy', 'Kalayaan', 'Liliw', 'Los Banos', 'Luisiana', 'Lumban', 'Mabitac', 'Magdalena', 'Majayjay', 'Nagcarlan', 'Paete', 'Pagsanjan', 'Pakil', 'Pangil', 'Pila', 'Rizal', 'Santa Maria', 'Siniloan', 'Victoria'] },
            { name: 'Leyte', cities: ['Tacloban City', 'Ormoc City', 'Abuyog', 'Alangalang', 'Albuera', 'Babatngon', 'Barugo', 'Bato', 'Baybay City', 'Burauen', 'Calubian', 'Capoocan', 'Carigara', 'Dagami', 'Dulag', 'Hilongos', 'Hindang', 'Inopacan', 'Isabel', 'Jaro', 'Javier', 'Julita', 'Kananga', 'La Paz', 'Leyte', 'MacArthur', 'Mahaplag', 'Matag-ob', 'Matalom', 'Mayorga', 'Merida', 'Palo', 'Palompon', 'Pastrana', 'San Isidro', 'San Miguel', 'Santa Fe', 'Tabango', 'Tabontabon', 'Tanauan', 'Tolosa', 'Tunga', 'Villaba'] },
            { name: 'Negros Occidental', cities: ['Bacolod City', 'Bago City', 'Cadiz City', 'Escalante City', 'Himamaylan City', 'Kabankalan City', 'La Carlota City', 'Sagay City', 'San Carlos City', 'Silay City', 'Sipalay City', 'Talisay City', 'Victorias City', 'Binalbagan', 'Calatrava', 'Candoni', 'Cauayan', 'Enrique B. Magalona', 'Hinigaran', 'Hinoba-an', 'Ilog', 'Isabela', 'La Castellana', 'Manapla', 'Moises Padilla', 'Murcia', 'Pontevedra', 'Pulupandan', 'Salvador Benedicto', 'San Enrique', 'Toboso', 'Valladolid'] },
            { name: 'Negros Oriental', cities: ['Dumaguete City', 'Bais City', 'Bayawan City', 'Canlaon City', 'Guihulngan City', 'Tanjay City', 'Amlan', 'Ayungon', 'Bacong', 'Basay', 'Bindoy', 'Dauin', 'Jimalalud', 'La Libertad', 'Mabinay', 'Manjuyod', 'Pamplona', 'San Jose', 'Santa Catalina', 'Siaton', 'Sibulan', 'Tayasan', 'Valencia', 'Vallehermoso', 'Zamboanguita'] },
            { name: 'Nueva Ecija', cities: ['Cabanatuan City', 'Gapan City', 'San Jose City', 'Palayan City', 'Aliaga', 'Bongabon', 'Cabiao', 'Carranglan', 'Cuyapo', 'Gabaldon', 'General Mamerto Natividad', 'General Tinio', 'Guimba', 'Jaen', 'Laur', 'Licab', 'Llanera', 'Lupao', 'Nampicuan', 'Pantabangan', 'Penaranda', 'Quezon', 'Rizal', 'San Antonio', 'San Isidro', 'San Leonardo', 'Santa Rosa', 'Santo Domingo', 'Talavera', 'Talugtug', 'Zaragoza'] },
            { name: 'Nueva Vizcaya', cities: ['Bayombong', 'Solano', 'Ambaguio', 'Aritao', 'Bagabag', 'Bambang', 'Diadi', 'Dupax del Norte', 'Dupax del Sur', 'Kasibu', 'Kayapa', 'Quezon', 'Santa Fe', 'Villaverde'] },
            { name: 'Pampanga', cities: ['San Fernando City', 'Angeles City', 'Mabalacat City', 'Apalit', 'Arayat', 'Bacolor', 'Candaba', 'Floridablanca', 'Guagua', 'Lubao', 'Macabebe', 'Magalang', 'Masantol', 'Mexico', 'Minalin', 'Porac', 'San Luis', 'San Simon', 'Santa Ana', 'Santa Rita', 'Santo Tomas', 'Sasmuan'] },
            { name: 'Pangasinan', cities: ['Dagupan City', 'San Carlos City', 'Urdaneta City', 'Alaminos City', 'Agno', 'Aguilar', 'Alcala', 'Anda', 'Asingan', 'Balungao', 'Bani', 'Basista', 'Bautista', 'Bayambang', 'Binalonan', 'Binmaley', 'Bolinao', 'Bugallon', 'Burgos', 'Calasiao', 'Dasol', 'Infanta', 'Labrador', 'Laoac', 'Lingayen', 'Mabini', 'Malasiqui', 'Manaoag', 'Mangaldan', 'Mangatarem', 'Mapandan', 'Natividad', 'Pozorrubio', 'Rosales', 'San Fabian', 'San Jacinto', 'San Manuel', 'San Nicolas', 'San Quintin', 'Santa Barbara', 'Santa Maria', 'Santo Tomas', 'Sison', 'Sual', 'Tayug', 'Umingan', 'Urbiztondo', 'Villasis'] },
            { name: 'Quezon', cities: ['Lucena City', 'Tayabas City', 'Agdangan', 'Alabat', 'Atimonan', 'Buenavista', 'Burdeos', 'Calauag', 'Candelaria', 'Catanauan', 'Dolores', 'General Luna', 'General Nakar', 'Guinayangan', 'Gumaca', 'Infanta', 'Jomalig', 'Lopez', 'Lucban', 'Macalelon', 'Mauban', 'Mulanay', 'Padre Burgos', 'Pagbilao', 'Panukulan', 'Patnanungan', 'Perez', 'Pitogo', 'Plaridel', 'Polillo', 'Quezon', 'Real', 'Sampaloc', 'San Andres', 'San Antonio', 'San Francisco', 'San Narciso', 'Sariaya', 'Tagkawayan', 'Tiaong', 'Unisan'] },
            { name: 'Rizal', cities: ['Antipolo City', 'Angono', 'Baras', 'Binangonan', 'Cainta', 'Cardona', 'Jalajala', 'Morong', 'Pililla', 'Rodriguez', 'San Mateo', 'Tanay', 'Taytay', 'Teresa'] },
            { name: 'Tarlac', cities: ['Tarlac City', 'Anao', 'Bamban', 'Camiling', 'Capas', 'Concepcion', 'Gerona', 'La Paz', 'Mayantoc', 'Moncada', 'Paniqui', 'Pura', 'Ramos', 'San Clemente', 'San Jose', 'San Manuel', 'Santa Ignacia', 'Victoria'] },
            { name: 'Zambales', cities: ['Olongapo City', 'Botolan', 'Cabangan', 'Candelaria', 'Castillejos', 'Iba', 'Masinloc', 'Palauig', 'San Antonio', 'San Felipe', 'San Marcelino', 'San Narciso', 'Santa Cruz', 'Subic'] },
            { name: 'Zamboanga del Norte', cities: ['Dipolog City', 'Dapitan City', 'Bacungan', 'Baliguian', 'Godod', 'Gutalac', 'Jose Dalman', 'Kalawit', 'Katipunan', 'La Libertad', 'Labason', 'Leon B. Postigo', 'Liloy', 'Manukan', 'Mutia', 'Pinan', 'Polanco', 'President Manuel A. Roxas', 'Rizal', 'Salug', 'Sergio Osmena Sr.', 'Siayan', 'Sibuco', 'Sibutad', 'Sindangan', 'Siocon', 'Sirawai', 'Tampilisan'] },
            { name: 'Zamboanga del Sur', cities: ['Pagadian City', 'Zamboanga City', 'Aurora', 'Bayog', 'Dimataling', 'Dinas', 'Dumalinao', 'Dumingag', 'Guipos', 'Josefina', 'Kumalarang', 'Labangan', 'Lakewood', 'Lapuyan', 'Mahayag', 'Margosatubig', 'Midsalip', 'Molave', 'Pitogo', 'Ramon Magsaysay', 'San Miguel', 'San Pablo', 'Sominot', 'Tabina', 'Tambulig', 'Tigbao', 'Tukuran', 'Vincenzo A. Sagun'] }
        ],

        updateCities() {
            const selectedProvince = this.provinces.find(p => p.name === this.formData.province);
            this.cities = selectedProvince ? selectedProvince.cities : [];
            this.formData.city = '';
        },

        submitForm() {
            if (this.formData.crops.length === 0) {
                alert('Pumili ng kahit isang crop.');
                return;
            }

            this.isSubmitting = true;

            setTimeout(() => {
                this.isSubmitting = false;
                this.showSuccess = true;

                this.formData = {
                    name: '',
                    phone: '',
                    email: '',
                    province: '',
                    city: '',
                    hectares: '',
                    crops: []
                };
                this.cities = [];
            }, 1500);
        }
    }
}
</script>
@endpush
