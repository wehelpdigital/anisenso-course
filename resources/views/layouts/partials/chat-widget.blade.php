{{-- Chat Support Widget --}}
<style>
    .chat-green { background-color: #2EAD4B; }
    .chat-green-dark { background-color: #259140; }
    .chat-green-bubble { background-color: #27a044; }
</style>

<div x-data="chatWidget()" x-cloak>

    {{-- Floating Chat Bubble --}}
    <button
        @click="toggleChat()"
        class="fixed bottom-6 right-6 z-50 w-[72px] h-[72px] rounded-full chat-green shadow-lg flex items-center justify-center transition-all duration-300 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-brand-yellow/50"
        :class="isOpen ? 'scale-0 opacity-0 pointer-events-none' : 'scale-100 opacity-100'"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>

        {{-- Unread indicator --}}
        <span
            x-show="unreadCount > 0"
            x-text="unreadCount"
            x-transition
            class="absolute -top-1 -right-1 w-6 h-6 bg-red-500 text-white text-sm font-bold rounded-full flex items-center justify-center"
        ></span>
    </button>

    {{-- Chat Window --}}
    <div
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        class="fixed bottom-6 right-6 z-50 w-[380px] max-w-[calc(100vw-2rem)] rounded-2xl shadow-2xl overflow-hidden flex flex-col"
        style="height: 490px; max-height: calc(100vh - 3rem);"
    >

        {{-- Header --}}
        <div class="chat-green-dark px-5 py-4 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full chat-green flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-white font-semibold text-sm leading-tight">Ani-Senso Suporta</h3>
                    <p class="text-xs" style="color: rgba(255,255,255,0.7);">Karaniwang sumasagot kami sa loob ng ilang minuto</p>
                </div>
            </div>
            <button @click="toggleChat()" class="p-1 transition-colors" style="color: rgba(255,255,255,0.7);" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="flex-1 flex flex-col bg-gray-50 overflow-hidden">

            {{-- Pre-Chat Form (Dynamic from CRM Form) --}}
                <div x-show="!conversationId" class="flex-1 overflow-y-auto">
                    <div class="px-5 py-5">
                        <div class="mb-4">
                            <h4 class="text-gray-900 font-heading font-semibold text-base mb-1">Kumusta! Paano ka namin matutulungan?</h4>
                            <p class="text-gray-500 text-xs">Punan ang iyong impormasyon at sasagutin ka namin sa lalong madaling panahon.</p>
                        </div>

                        {{-- Loading state --}}
                        <div x-show="formFieldsLoading" class="text-center py-6">
                            <svg class="animate-spin w-6 h-6 mx-auto text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            <p class="text-gray-400 text-xs mt-2">Naglo-load...</p>
                        </div>

                        {{-- Dynamic form --}}
                        <form x-show="!formFieldsLoading && formFields.length > 0" @submit.prevent="validateAndStart()" class="space-y-3">
                            <template x-for="field in formFields" :key="field.id">
                                <div>
                                    <label x-show="field.type !== 'hidden' && field.type !== 'single_checkbox'" class="block text-gray-700 text-sm font-medium mb-1" x-text="field.label"></label>

                                    {{-- Text input --}}
                                    <template x-if="field.type === 'text'">
                                        <div>
                                            <input
                                                type="text"
                                                :placeholder="field.placeholder || ''"
                                                x-model="formData[field.id]"
                                                @input="errors[field.id] = ''"
                                                class="w-full px-3 py-2 border-2 rounded-xl text-gray-900 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand-yellow/50 focus:border-brand-yellow transition-colors"
                                                :class="errors[field.id] ? 'border-red-400' : 'border-gray-200'"
                                            >
                                            <p x-show="errors[field.id]" x-text="errors[field.id]" class="text-red-500 text-xs mt-1"></p>
                                        </div>
                                    </template>

                                    {{-- Email input --}}
                                    <template x-if="field.type === 'email'">
                                        <div>
                                            <input
                                                type="text"
                                                :placeholder="field.placeholder || ''"
                                                x-model="formData[field.id]"
                                                @input="errors[field.id] = ''"
                                                class="w-full px-3 py-2 border-2 rounded-xl text-gray-900 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand-yellow/50 focus:border-brand-yellow transition-colors"
                                                :class="errors[field.id] ? 'border-red-400' : 'border-gray-200'"
                                            >
                                            <p x-show="errors[field.id]" x-text="errors[field.id]" class="text-red-500 text-xs mt-1"></p>
                                        </div>
                                    </template>

                                    {{-- Select dropdown --}}
                                    <template x-if="field.type === 'select'">
                                        <div>
                                            <select
                                                x-model="formData[field.id]"
                                                @change="errors[field.id] = ''"
                                                class="w-full px-3 py-2 border-2 rounded-xl text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-brand-yellow/50 focus:border-brand-yellow transition-colors"
                                                :class="errors[field.id] ? 'border-red-400' : 'border-gray-200'"
                                            >
                                                <option value="" x-text="field.placeholder || '— Pumili —'"></option>
                                                <template x-for="opt in (field.options || [])" :key="opt">
                                                    <option :value="opt" x-text="opt"></option>
                                                </template>
                                            </select>
                                            <p x-show="errors[field.id]" x-text="errors[field.id]" class="text-red-500 text-xs mt-1"></p>
                                        </div>
                                    </template>

                                    {{-- Phone input --}}
                                    <template x-if="field.type === 'phone'">
                                        <div>
                                            <input
                                                type="tel"
                                                :placeholder="field.placeholder || ''"
                                                x-model="formData[field.id]"
                                                @input="errors[field.id] = ''"
                                                class="w-full px-3 py-2 border-2 rounded-xl text-gray-900 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand-yellow/50 focus:border-brand-yellow transition-colors"
                                                :class="errors[field.id] ? 'border-red-400' : 'border-gray-200'"
                                            >
                                            <p x-show="errors[field.id]" x-text="errors[field.id]" class="text-red-500 text-xs mt-1"></p>
                                        </div>
                                    </template>

                                    {{-- Number input --}}
                                    <template x-if="field.type === 'number'">
                                        <div>
                                            <input
                                                type="number"
                                                :placeholder="field.placeholder || ''"
                                                :min="field.min"
                                                :max="field.max"
                                                x-model="formData[field.id]"
                                                @input="errors[field.id] = ''"
                                                class="w-full px-3 py-2 border-2 rounded-xl text-gray-900 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand-yellow/50 focus:border-brand-yellow transition-colors"
                                                :class="errors[field.id] ? 'border-red-400' : 'border-gray-200'"
                                            >
                                            <p x-show="errors[field.id]" x-text="errors[field.id]" class="text-red-500 text-xs mt-1"></p>
                                        </div>
                                    </template>

                                    {{-- Textarea --}}
                                    <template x-if="field.type === 'textarea'">
                                        <div>
                                            <textarea
                                                :placeholder="field.placeholder || ''"
                                                x-model="formData[field.id]"
                                                @input="errors[field.id] = ''"
                                                rows="3"
                                                class="w-full px-3 py-2 border-2 rounded-xl text-gray-900 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand-yellow/50 focus:border-brand-yellow transition-colors resize-none"
                                                :class="errors[field.id] ? 'border-red-400' : 'border-gray-200'"
                                            ></textarea>
                                            <p x-show="errors[field.id]" x-text="errors[field.id]" class="text-red-500 text-xs mt-1"></p>
                                        </div>
                                    </template>

                                    {{-- Radio buttons --}}
                                    <template x-if="field.type === 'radio'">
                                        <div>
                                            <div :class="field.inline ? 'flex flex-wrap gap-3' : 'space-y-2'">
                                                <template x-for="opt in (field.options || [])" :key="opt">
                                                    <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-700">
                                                        <input
                                                            type="radio"
                                                            :name="field.id"
                                                            :value="opt"
                                                            x-model="formData[field.id]"
                                                            @change="errors[field.id] = ''"
                                                            class="w-4 h-4 text-brand-yellow focus:ring-brand-yellow/50"
                                                        >
                                                        <span x-text="opt"></span>
                                                    </label>
                                                </template>
                                            </div>
                                            <p x-show="errors[field.id]" x-text="errors[field.id]" class="text-red-500 text-xs mt-1"></p>
                                        </div>
                                    </template>

                                    {{-- Checkboxes (multiple) --}}
                                    <template x-if="field.type === 'checkbox'">
                                        <div>
                                            <div :class="field.inline ? 'flex flex-wrap gap-3' : 'space-y-2'">
                                                <template x-for="opt in (field.options || [])" :key="opt">
                                                    <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-700">
                                                        <input
                                                            type="checkbox"
                                                            :value="opt"
                                                            @change="
                                                                let arr = Array.isArray(formData[field.id]) ? formData[field.id] : [];
                                                                if ($event.target.checked) { arr.push(opt); } else { arr = arr.filter(v => v !== opt); }
                                                                formData[field.id] = arr;
                                                                errors[field.id] = '';
                                                            "
                                                            :checked="Array.isArray(formData[field.id]) && formData[field.id].includes(opt)"
                                                            class="w-4 h-4 rounded text-brand-yellow focus:ring-brand-yellow/50"
                                                        >
                                                        <span x-text="opt"></span>
                                                    </label>
                                                </template>
                                            </div>
                                            <p x-show="errors[field.id]" x-text="errors[field.id]" class="text-red-500 text-xs mt-1"></p>
                                        </div>
                                    </template>

                                    {{-- Single checkbox --}}
                                    <template x-if="field.type === 'single_checkbox'">
                                        <div>
                                            <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-700">
                                                <input
                                                    type="checkbox"
                                                    x-model="formData[field.id]"
                                                    @change="errors[field.id] = ''"
                                                    class="w-4 h-4 rounded text-brand-yellow focus:ring-brand-yellow/50"
                                                >
                                                <span x-text="field.label"></span>
                                            </label>
                                            <p x-show="errors[field.id]" x-text="errors[field.id]" class="text-red-500 text-xs mt-1"></p>
                                        </div>
                                    </template>

                                    {{-- Date picker --}}
                                    <template x-if="field.type === 'date'">
                                        <div>
                                            <input
                                                type="date"
                                                x-model="formData[field.id]"
                                                @input="errors[field.id] = ''"
                                                class="w-full px-3 py-2 border-2 rounded-xl text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-brand-yellow/50 focus:border-brand-yellow transition-colors"
                                                :class="errors[field.id] ? 'border-red-400' : 'border-gray-200'"
                                            >
                                            <p x-show="errors[field.id]" x-text="errors[field.id]" class="text-red-500 text-xs mt-1"></p>
                                        </div>
                                    </template>

                                    {{-- Time picker --}}
                                    <template x-if="field.type === 'time'">
                                        <div>
                                            <input
                                                type="time"
                                                x-model="formData[field.id]"
                                                @input="errors[field.id] = ''"
                                                class="w-full px-3 py-2 border-2 rounded-xl text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-brand-yellow/50 focus:border-brand-yellow transition-colors"
                                                :class="errors[field.id] ? 'border-red-400' : 'border-gray-200'"
                                            >
                                            <p x-show="errors[field.id]" x-text="errors[field.id]" class="text-red-500 text-xs mt-1"></p>
                                        </div>
                                    </template>
                                </div>
                            </template>

                            <p x-show="chatError" x-text="chatError" class="text-red-500 text-xs text-center mb-1"></p>
                            <button
                                type="submit"
                                :disabled="isLoading"
                                class="w-full py-2.5 bg-brand-yellow hover:bg-brand-yellow-hover text-brand-dark font-semibold rounded-xl transition-colors text-sm disabled:opacity-50"
                            >
                                <span x-show="!isLoading" class="inline-flex items-center gap-2">Simulan ang Chat <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg></span>
                                <span x-show="isLoading" class="flex items-center justify-center gap-2">
                                    <svg class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Naglo-load...
                                </span>
                            </button>
                        </form>
                    </div>
                </div>

            {{-- Chat Messages Area --}}
                <div x-show="conversationId" class="flex-1 flex flex-col overflow-hidden">
                    {{-- Messages --}}
                    <div
                        x-ref="messagesContainer"
                        class="flex-1 overflow-y-auto px-5 py-4 space-y-3"
                    >
                        <template x-for="msg in messages" :key="msg.id">
                            <div>
                                {{-- System message --}}
                                <div x-show="msg.senderType === 'system'" class="flex justify-center my-1">
                                    <div class="max-w-[85%] text-center">
                                        <div class="bg-gray-100 border border-gray-200 rounded-xl px-4 py-2.5 text-xs text-gray-500 leading-relaxed">
                                            <span x-text="msg.message"></span>
                                        </div>
                                        <div class="text-[10px] text-gray-400 mt-1" x-text="msg.createdAt"></div>
                                    </div>
                                </div>

                                {{-- Visitor / Admin message --}}
                                <div x-show="msg.senderType !== 'system'" :class="msg.senderType === 'visitor' ? 'flex justify-end' : 'flex justify-start'">
                                    {{-- Admin avatar --}}
                                    <div x-show="msg.senderType === 'admin'" class="w-7 h-7 rounded-full bg-brand-yellow flex items-center justify-center flex-shrink-0 mr-2 mt-1">
                                        <span class="text-brand-dark text-xs font-bold">A</span>
                                    </div>

                                    <div class="max-w-[75%]">
                                        {{-- Sender name --}}
                                        <div
                                            :class="msg.senderType === 'visitor' ? 'text-right' : 'text-left'"
                                            class="text-[11px] text-gray-500 font-medium mb-0.5 px-1"
                                            x-text="msg.senderType === 'visitor' ? 'Ikaw' : 'Admin'"
                                        ></div>
                                        <div
                                            :class="msg.senderType === 'visitor'
                                                ? 'chat-green-bubble text-white rounded-2xl rounded-br-md'
                                                : 'bg-white text-gray-900 border border-gray-200 rounded-2xl rounded-bl-md'"
                                            class="px-4 py-2.5 text-sm leading-relaxed"
                                        >
                                            <span x-text="msg.message"></span>
                                        </div>
                                        <div
                                            :class="msg.senderType === 'visitor' ? 'text-right' : 'text-left'"
                                            class="text-[11px] text-gray-400 mt-1 px-1"
                                            x-text="msg.createdAt"
                                        ></div>
                                    </div>
                                </div>
                            </div>
                        </template>

                        {{-- Conversation closed notice --}}
                        <div x-show="chatStatus === 'closed'" class="text-center py-3">
                            <span class="inline-block px-4 py-2 bg-gray-200 text-gray-600 text-xs rounded-full">
                                Natapos na ang pag-uusap na ito
                            </span>
                        </div>
                    </div>

                    {{-- Input Area --}}
                    <div x-show="chatStatus !== 'closed'" class="px-4 py-3 bg-white border-t border-gray-100 flex-shrink-0">
                        <div class="flex items-end gap-2">
                            <textarea
                                x-ref="chatInput"
                                x-model="newMessage"
                                @keydown.enter.prevent="if(!$event.shiftKey) sendMessage()"
                                @input="autoResize($event)"
                                placeholder="Mag-type ng mensahe..."
                                rows="1"
                                maxlength="5000"
                                class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl text-gray-900 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand-yellow/50 focus:border-brand-yellow transition-colors resize-none"
                                style="max-height: 100px;"
                            ></textarea>
                            <button
                                @click="sendMessage()"
                                :disabled="!newMessage.trim() || isSending"
                                class="w-10 h-10 rounded-full bg-brand-yellow hover:bg-brand-yellow-hover text-brand-dark flex items-center justify-center flex-shrink-0 transition-colors disabled:opacity-40 disabled:cursor-not-allowed"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Closed state input replacement --}}
                    <div x-show="chatStatus === 'closed'" class="px-4 py-3 bg-amber-50 border-t border-amber-200 flex-shrink-0 text-center">
                        <p class="text-amber-700 text-xs mb-2">Natapos na ang pag-uusap na ito.</p>
                        <div class="flex items-center justify-center gap-3">
                            <button
                                @click="downloadChatLog()"
                                class="text-xs font-medium underline transition-colors text-gray-500 hover:text-gray-700"
                            >
                                I-download ang usapan
                            </button>
                            <span class="text-gray-300">|</span>
                            <button
                                @click="resetChat()"
                                class="text-xs font-medium underline transition-colors" style="color: #2EAD4B;"
                            >
                                Bagong usapan
                            </button>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>

<script>
function chatWidget() {
    return {
        isOpen: false,
        conversationId: null,
        sessionId: null,
        formFields: [],
        formFieldsLoading: true,
        formData: {},
        newMessage: '',
        messages: [],
        unreadCount: 0,
        isLoading: false,
        isSending: false,
        chatStatus: 'active',
        chatError: '',
        errors: {},
        pollInterval: null,

        init() {
            // Load form fields from CRM
            this.loadFormFields();

            // Restore session from localStorage
            const saved = localStorage.getItem('anisenso_chat_session');
            if (saved) {
                try {
                    const session = JSON.parse(saved);
                    this.conversationId = session.conversationId;
                    this.sessionId = session.sessionId;
                    if (this.conversationId) {
                        this.fetchMessages();
                        this.startPolling();
                    }
                } catch (e) {
                    localStorage.removeItem('anisenso_chat_session');
                }
            }
        },

        async loadFormFields() {
            try {
                const res = await fetch('{{ route("chat.form-fields") }}', {
                    headers: { 'Accept': 'application/json' },
                });
                const data = await res.json();
                if (data.success) {
                    this.formFields = data.fields;
                    // Initialize formData for each field
                    data.fields.forEach(f => {
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
                this.formFieldsLoading = false;
            }
        },

        toggleChat() {
            this.isOpen = !this.isOpen;
            if (this.isOpen) {
                this.unreadCount = 0;
                if (this.conversationId) {
                    this.$nextTick(() => this.scrollToBottom());
                }
            }
        },

        validateAndStart() {
            this.errors = {};
            let valid = true;

            this.formFields.forEach(field => {
                const val = this.formData[field.id];
                const isEmpty = Array.isArray(val) ? val.length === 0 : (typeof val === 'boolean' ? !val : (!val || (typeof val === 'string' && !val.trim())));
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

            if (valid) this.startChat();
        },

        async startChat() {
            this.isLoading = true;
            this.chatError = '';

            const payload = { ...this.formData, session_id: this.sessionId };

            for (let attempt = 1; attempt <= 2; attempt++) {
                try {
                    const res = await fetch('{{ route("chat.start") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify(payload),
                    });

                    if (!res.ok && attempt < 2) continue;

                    const data = await res.json();

                    if (data.success) {
                        this.conversationId = data.conversation.id;
                        this.sessionId = data.conversation.sessionId;

                        if (data.message) {
                            this.messages.push(data.message);
                            this.$nextTick(() => this.scrollToBottom());
                        }

                        this.saveSession();
                        this.startPolling();
                        this.isLoading = false;
                        return;
                    }
                } catch (err) {
                    if (attempt >= 2) console.error('Failed to start chat:', err);
                }
            }

            this.chatError = 'Hindi makakonekta. Pakisubukan muli.';
            this.isLoading = false;
        },

        async sendMessage() {
            const text = this.newMessage.trim();
            if (!text || this.isSending || !this.conversationId) return;

            this.isSending = true;
            const savedText = text;
            this.newMessage = '';

            if (this.$refs.chatInput) {
                this.$refs.chatInput.style.height = 'auto';
            }

            try {
                const res = await fetch('{{ route("chat.send") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        conversation_id: this.conversationId,
                        message: savedText,
                    }),
                });

                if (!res.ok) {
                    if (res.status === 404) this.chatStatus = 'closed';
                    this.newMessage = savedText;
                    return;
                }

                const data = await res.json();
                if (data.success) {
                    this.messages.push(data.message);
                    this.$nextTick(() => this.scrollToBottom());
                }
            } catch (err) {
                console.error('Failed to send message:', err);
                this.newMessage = savedText;
            } finally {
                this.isSending = false;
                this.$nextTick(() => {
                    if (this.$refs.chatInput) this.$refs.chatInput.focus();
                });
            }
        },

        async fetchMessages() {
            if (!this.conversationId) return;

            try {
                const res = await fetch(`{{ route("chat.messages") }}?conversation_id=${this.conversationId}`, {
                    headers: { 'Accept': 'application/json' },
                });

                const data = await res.json();

                if (data.success) {
                    const prevCount = this.messages.length;
                    const prevStatus = this.chatStatus;
                    this.messages = data.messages;

                    if (!this.isOpen && data.messages.length > prevCount) {
                        const newMsgs = data.messages.slice(prevCount);
                        const newAdminMsgs = newMsgs.filter(m => m.senderType === 'admin').length;
                        this.unreadCount += newAdminMsgs;
                    }

                    if (this.isOpen) {
                        this.$nextTick(() => this.scrollToBottom());
                    }

                    if (data.status === 'active' && prevStatus === 'closed') {
                        this.chatStatus = 'active';
                        this.startPolling();
                    }

                    if (data.status === 'closed' && prevStatus !== 'closed') {
                        this.chatStatus = 'closed';
                        this.stopPolling();
                        this.pollInterval = setInterval(() => this.fetchMessages(), 3000);
                    }

                    this.chatStatus = data.status;
                } else if (!res.ok) {
                    if (res.status === 404) this.resetChat();
                }
            } catch (err) {
                console.error('Failed to fetch messages:', err);
            }
        },

        startPolling() {
            this.stopPolling();
            this.pollInterval = setInterval(() => this.fetchMessages(), 3000);
        },

        stopPolling() {
            if (this.pollInterval) {
                clearInterval(this.pollInterval);
                this.pollInterval = null;
            }
        },

        saveSession() {
            localStorage.setItem('anisenso_chat_session', JSON.stringify({
                conversationId: this.conversationId,
                sessionId: this.sessionId,
            }));
        },

        resetChat() {
            this.stopPolling();
            this.conversationId = null;
            this.sessionId = null;
            this.formFields.forEach(f => {
                if (f.type === 'checkbox') this.formData[f.id] = [];
                else if (f.type === 'single_checkbox') this.formData[f.id] = false;
                else this.formData[f.id] = '';
            });
            this.messages = [];
            this.chatStatus = 'active';
            this.chatError = '';
            this.errors = {};
            this.newMessage = '';
            this.unreadCount = 0;
            localStorage.removeItem('anisenso_chat_session');
        },

        scrollToBottom() {
            const container = this.$refs.messagesContainer;
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        },

        downloadChatLog() {
            let text = 'Ani-Senso Chat Support - Talaan ng Usapan\n';
            text += '==========================================\n';
            text += 'Petsa: ' + new Date().toLocaleDateString('fil-PH', { year: 'numeric', month: 'long', day: 'numeric' }) + '\n';
            text += '==========================================\n\n';

            this.messages.forEach(function(msg) {
                const sender = msg.senderType === 'visitor' ? 'Ikaw' : (msg.senderType === 'system' ? 'System' : 'Admin');
                text += '[' + msg.createdAt + '] ' + sender + ':\n';
                text += msg.message + '\n\n';
            });

            text += '==========================================\n';
            text += 'Natapos na ang usapan.\n';

            const blob = new Blob([text], { type: 'text/plain;charset=utf-8' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'anisenso-chat-' + new Date().toISOString().slice(0, 10) + '.txt';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        },

        autoResize(event) {
            const el = event.target;
            el.style.height = 'auto';
            el.style.height = Math.min(el.scrollHeight, 100) + 'px';
        },
    };
}
</script>
