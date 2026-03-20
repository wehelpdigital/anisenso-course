@extends('layouts.landing')

@section('title', 'Salamat! - Ani-Senso Academy')

@push('styles')
<style>
    .confetti {
        position: fixed;
        width: 10px;
        height: 10px;
        top: -10px;
        animation: confetti-fall 3s linear forwards;
        z-index: 50;
    }
    @keyframes confetti-fall {
        to {
            transform: translateY(100vh) rotate(720deg);
            opacity: 0;
        }
    }
    .pulse-slow {
        animation: pulse-slow 3s ease-in-out infinite;
    }
    @keyframes pulse-slow {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.05); opacity: 0.9; }
    }
    .float {
        animation: float 6s ease-in-out infinite;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-brand-green/5 via-white to-brand-yellow/5" x-data="confirmationPage()">
    <!-- Confetti Effect (on load) -->
    <template x-for="i in 30" :key="i">
        <div class="confetti"
             :style="`left: ${Math.random() * 100}vw; background: ${['#4a7c2a', '#f5c518', '#6b9f3d', '#e6b800'][Math.floor(Math.random() * 4)]}; animation-delay: ${Math.random() * 2}s; border-radius: ${Math.random() > 0.5 ? '50%' : '0'};`">
        </div>
    </template>

    <div class="container mx-auto px-4 py-8 md:py-16">
        <!-- Main Card -->
        <div class="max-w-lg mx-auto">
            <!-- Success Header -->
            <div class="text-center mb-8">
                <!-- Success Icon -->
                <div class="inline-flex items-center justify-center w-24 h-24 bg-brand-green/10 rounded-full mb-6 float">
                    <div class="w-16 h-16 bg-brand-green rounded-full flex items-center justify-center pulse-slow">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>

                <!-- Main Message -->
                <h1 class="text-3xl md:text-4xl font-bold text-brand-dark font-heading mb-2">
                    Salamat!
                </h1>
                <p class="text-xl text-brand-green font-semibold">
                    Congratulations, Magsasaka!
                </p>
            </div>

            <!-- Order Receipt Card -->
            <div id="orderReceipt" class="bg-white rounded-2xl shadow-xl overflow-hidden mb-6">
                <!-- Green Header -->
                <div class="bg-brand-green px-6 py-4 text-center">
                    <p class="text-white/80 text-sm">Order Number</p>
                    <p class="text-white text-2xl font-bold tracking-wide">{{ $order->orderNumber }}</p>
                </div>

                <!-- Order Details -->
                <div class="p-6">
                    <!-- Product -->
                    <div class="flex items-center gap-4 pb-4 border-b border-gray-100">
                        <div class="w-12 h-12 bg-brand-green/10 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-brand-dark">{{ $productName }}</p>
                            <p class="text-sm text-gray-500">{{ $variantName }}</p>
                        </div>
                        <p class="text-lg font-bold text-brand-green">₱{{ number_format($price, 2) }}</p>
                    </div>

                    <!-- Info Grid -->
                    <div class="grid grid-cols-2 gap-4 py-4 text-sm">
                        <div>
                            <p class="text-gray-500">Petsa</p>
                            <p class="font-medium text-brand-dark">{{ \Carbon\Carbon::parse($order->created_at)->format('M j, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Email</p>
                            <p class="font-medium text-brand-dark truncate">{{ $order->clientEmail }}</p>
                        </div>
                    </div>

                    <!-- Status Badge -->
                    <div class="pt-4 border-t border-gray-100">
                        @if($statusInfo['status'] === 'verified')
                        <div class="inline-flex items-center gap-2 bg-green-50 text-green-700 px-4 py-2 rounded-full text-sm font-medium w-full justify-center">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            {{ $statusInfo['title'] }}
                        </div>
                        @else
                        <div class="inline-flex items-center gap-2 bg-yellow-50 text-yellow-700 px-4 py-2 rounded-full text-sm font-medium w-full justify-center">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            {{ $statusInfo['title'] }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- What's Next Section -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                <h3 class="font-bold text-brand-dark mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-green" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/>
                    </svg>
                    Ano ang susunod?
                </h3>
                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 bg-brand-green rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-white text-xs font-bold">1</span>
                        </div>
                        <p class="text-gray-600">I-ve-verify namin ang payment mo <strong>within 24 hours</strong>.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 bg-brand-green rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-white text-xs font-bold">2</span>
                        </div>
                        <p class="text-gray-600">Makakatanggap ka ng <strong>email confirmation</strong> with login details.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 bg-brand-green rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-white text-xs font-bold">3</span>
                        </div>
                        <p class="text-gray-600">Simulan mo na ang <strong>pag-aaral</strong> at magsimulang kumita!</p>
                    </div>
                </div>
            </div>

            <!-- Inspirational Message -->
            <div class="bg-gradient-to-r from-brand-green/10 to-brand-yellow/10 rounded-2xl p-6 mb-6 border border-brand-green/20">
                <div class="text-center">
                    <p class="text-lg text-gray-700 leading-relaxed">
                        <span class="text-2xl">🌾</span><br>
                        <span class="font-semibold text-brand-dark">Ito ang simula ng pagbabago!</span><br>
                        <span class="text-sm mt-2 block text-gray-600">
                            Ginawa mo ang pinakamahalagang hakbang para baguhin ang iyong buhay sa pagsasaka.
                            Maligayang pagdating sa komunidad ng mga matagumpay na magsasaka!
                        </span>
                    </p>
                </div>
            </div>

            <!-- Bookmark Reminder -->
            <div class="bg-blue-50 rounded-xl p-4 mb-6 border border-blue-100">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-blue-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/>
                    </svg>
                    <div>
                        <p class="font-medium text-blue-800 text-sm">I-save ang page na ito!</p>
                        <p class="text-blue-600 text-xs mt-1">
                            Puwede mong balikan ang page na ito anytime para ma-check ang status ng order mo.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3">
                <button @click="copyLink()"
                        class="w-full inline-flex items-center justify-center gap-2 bg-brand-green text-white px-6 py-4 rounded-xl font-bold hover:bg-brand-green-dark transition-all duration-300 shadow-lg hover:shadow-xl">
                    <svg x-show="!linkCopied" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                    </svg>
                    <svg x-show="linkCopied" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span x-text="linkCopied ? 'Link Copied!' : 'Copy Order Link'"></span>
                </button>

                <button @click="saveScreenshot()"
                        :disabled="isSaving"
                        class="w-full inline-flex items-center justify-center gap-2 bg-brand-yellow text-brand-dark px-6 py-4 rounded-xl font-bold hover:bg-brand-yellow-hover transition-all duration-300 shadow-lg hover:shadow-xl disabled:opacity-50">
                    <svg x-show="!isSaving" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <svg x-show="isSaving" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span x-text="isSaving ? 'Saving...' : 'I-save bilang Photo'"></span>
                </button>

                <a href="{{ url('/') }}"
                   class="w-full inline-flex items-center justify-center gap-2 bg-gray-100 text-gray-700 px-6 py-3 rounded-xl font-medium hover:bg-gray-200 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Bumalik sa Home
                </a>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center">
                <p class="text-gray-400 text-sm">
                    <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Secured by Ani-Senso Academy
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- html2canvas library for screenshot -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
function confirmationPage() {
    return {
        linkCopied: false,
        isSaving: false,

        copyLink() {
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(() => {
                this.linkCopied = true;
                setTimeout(() => {
                    this.linkCopied = false;
                }, 3000);
            }).catch(() => {
                // Fallback for older browsers
                const textarea = document.createElement('textarea');
                textarea.value = url;
                document.body.appendChild(textarea);
                textarea.select();
                document.execCommand('copy');
                document.body.removeChild(textarea);
                this.linkCopied = true;
                setTimeout(() => {
                    this.linkCopied = false;
                }, 3000);
            });
        },

        async saveScreenshot() {
            this.isSaving = true;

            try {
                const element = document.getElementById('orderReceipt');
                if (!element) {
                    alert('Could not find order receipt element.');
                    return;
                }

                const canvas = await html2canvas(element, {
                    scale: 2,
                    backgroundColor: '#ffffff',
                    logging: false,
                    useCORS: true,
                });

                // Convert to image and download
                const link = document.createElement('a');
                link.download = `Ani-Senso-Order-{{ $order->orderNumber }}.png`;
                link.href = canvas.toDataURL('image/png');
                link.click();
            } catch (error) {
                console.error('Screenshot error:', error);
                alert('May error sa pag-save ng photo. Subukan ulit.');
            } finally {
                this.isSaving = false;
            }
        }
    }
}
</script>
@endpush
