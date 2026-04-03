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

            {{-- Pre-Chat Form --}}
                <div x-show="!conversationId" class="flex-1 overflow-y-auto">
                    <div class="px-5 py-5">
                        <div class="mb-4">
                            <h4 class="text-gray-900 font-heading font-semibold text-base mb-1">Kumusta! Paano ka namin matutulungan?</h4>
                            <p class="text-gray-500 text-xs">Punan ang iyong impormasyon at sasagutin ka namin sa lalong madaling panahon.</p>
                        </div>

                        <form @submit.prevent="validateAndStart()" class="space-y-3">
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-1">Pangalan</label>
                                <input
                                    type="text"
                                    x-model="visitorName"
                                    @input="errors.visitorName = ''"
                                    placeholder="Iyong pangalan"
                                    class="w-full px-3 py-2 border-2 rounded-xl text-gray-900 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand-yellow/50 focus:border-brand-yellow transition-colors"
                                    :class="errors.visitorName ? 'border-red-400' : 'border-gray-200'"
                                >
                                <p x-show="errors.visitorName" x-text="errors.visitorName" class="text-red-500 text-xs mt-1"></p>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-1">Email</label>
                                <input
                                    type="text"
                                    x-model="visitorEmail"
                                    @input="errors.visitorEmail = ''"
                                    placeholder="Iyong email address"
                                    class="w-full px-3 py-2 border-2 rounded-xl text-gray-900 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand-yellow/50 focus:border-brand-yellow transition-colors"
                                    :class="errors.visitorEmail ? 'border-red-400' : 'border-gray-200'"
                                >
                                <p x-show="errors.visitorEmail" x-text="errors.visitorEmail" class="text-red-500 text-xs mt-1"></p>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-1">Lokasyon ng Farm <span class="text-gray-400 font-normal">(Probinsya)</span></label>
                                <select
                                    x-model="farmLocation"
                                    @change="errors.farmLocation = ''"
                                    class="w-full px-3 py-2 border-2 rounded-xl text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-brand-yellow/50 focus:border-brand-yellow transition-colors"
                                    :class="errors.farmLocation ? 'border-red-400' : 'border-gray-200'"
                                >
                                    <option value="">— Pumili ng Probinsya —</option>
                                    <option value="Abra">Abra</option>
                                    <option value="Agusan del Norte">Agusan del Norte</option>
                                    <option value="Agusan del Sur">Agusan del Sur</option>
                                    <option value="Aklan">Aklan</option>
                                    <option value="Albay">Albay</option>
                                    <option value="Antique">Antique</option>
                                    <option value="Apayao">Apayao</option>
                                    <option value="Aurora">Aurora</option>
                                    <option value="Basilan">Basilan</option>
                                    <option value="Bataan">Bataan</option>
                                    <option value="Batanes">Batanes</option>
                                    <option value="Batangas">Batangas</option>
                                    <option value="Benguet">Benguet</option>
                                    <option value="Biliran">Biliran</option>
                                    <option value="Bohol">Bohol</option>
                                    <option value="Bukidnon">Bukidnon</option>
                                    <option value="Bulacan">Bulacan</option>
                                    <option value="Cagayan">Cagayan</option>
                                    <option value="Camarines Norte">Camarines Norte</option>
                                    <option value="Camarines Sur">Camarines Sur</option>
                                    <option value="Camiguin">Camiguin</option>
                                    <option value="Capiz">Capiz</option>
                                    <option value="Catanduanes">Catanduanes</option>
                                    <option value="Cavite">Cavite</option>
                                    <option value="Cebu">Cebu</option>
                                    <option value="Cotabato">Cotabato</option>
                                    <option value="Davao de Oro">Davao de Oro</option>
                                    <option value="Davao del Norte">Davao del Norte</option>
                                    <option value="Davao del Sur">Davao del Sur</option>
                                    <option value="Davao Occidental">Davao Occidental</option>
                                    <option value="Davao Oriental">Davao Oriental</option>
                                    <option value="Dinagat Islands">Dinagat Islands</option>
                                    <option value="Eastern Samar">Eastern Samar</option>
                                    <option value="Guimaras">Guimaras</option>
                                    <option value="Ifugao">Ifugao</option>
                                    <option value="Ilocos Norte">Ilocos Norte</option>
                                    <option value="Ilocos Sur">Ilocos Sur</option>
                                    <option value="Iloilo">Iloilo</option>
                                    <option value="Isabela">Isabela</option>
                                    <option value="Kalinga">Kalinga</option>
                                    <option value="Laguna">Laguna</option>
                                    <option value="Lanao del Norte">Lanao del Norte</option>
                                    <option value="Lanao del Sur">Lanao del Sur</option>
                                    <option value="La Union">La Union</option>
                                    <option value="Leyte">Leyte</option>
                                    <option value="Maguindanao">Maguindanao</option>
                                    <option value="Marinduque">Marinduque</option>
                                    <option value="Masbate">Masbate</option>
                                    <option value="Metro Manila">Metro Manila</option>
                                    <option value="Misamis Occidental">Misamis Occidental</option>
                                    <option value="Misamis Oriental">Misamis Oriental</option>
                                    <option value="Mountain Province">Mountain Province</option>
                                    <option value="Negros Occidental">Negros Occidental</option>
                                    <option value="Negros Oriental">Negros Oriental</option>
                                    <option value="Northern Samar">Northern Samar</option>
                                    <option value="Nueva Ecija">Nueva Ecija</option>
                                    <option value="Nueva Vizcaya">Nueva Vizcaya</option>
                                    <option value="Occidental Mindoro">Occidental Mindoro</option>
                                    <option value="Oriental Mindoro">Oriental Mindoro</option>
                                    <option value="Palawan">Palawan</option>
                                    <option value="Pampanga">Pampanga</option>
                                    <option value="Pangasinan">Pangasinan</option>
                                    <option value="Quezon">Quezon</option>
                                    <option value="Quirino">Quirino</option>
                                    <option value="Rizal">Rizal</option>
                                    <option value="Romblon">Romblon</option>
                                    <option value="Samar">Samar</option>
                                    <option value="Sarangani">Sarangani</option>
                                    <option value="Siquijor">Siquijor</option>
                                    <option value="Sorsogon">Sorsogon</option>
                                    <option value="South Cotabato">South Cotabato</option>
                                    <option value="Southern Leyte">Southern Leyte</option>
                                    <option value="Sultan Kudarat">Sultan Kudarat</option>
                                    <option value="Sulu">Sulu</option>
                                    <option value="Surigao del Norte">Surigao del Norte</option>
                                    <option value="Surigao del Sur">Surigao del Sur</option>
                                    <option value="Tarlac">Tarlac</option>
                                    <option value="Tawi-Tawi">Tawi-Tawi</option>
                                    <option value="Zambales">Zambales</option>
                                    <option value="Zamboanga del Norte">Zamboanga del Norte</option>
                                    <option value="Zamboanga del Sur">Zamboanga del Sur</option>
                                    <option value="Zamboanga Sibugay">Zamboanga Sibugay</option>
                                </select>
                                <p x-show="errors.farmLocation" x-text="errors.farmLocation" class="text-red-500 text-xs mt-1"></p>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-1">Ikaw Ay</label>
                                <select
                                    x-model="visitorType"
                                    @change="errors.visitorType = ''"
                                    class="w-full px-3 py-2 border-2 rounded-xl text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-brand-yellow/50 focus:border-brand-yellow transition-colors"
                                    :class="errors.visitorType ? 'border-red-400' : 'border-gray-200'"
                                >
                                    <option value="">— Pumili —</option>
                                    <option value="farm_owner">Farm Owner</option>
                                    <option value="farm_worker">Farm Worker</option>
                                    <option value="other">Iba Pa</option>
                                </select>
                                <p x-show="errors.visitorType" x-text="errors.visitorType" class="text-red-500 text-xs mt-1"></p>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-medium mb-1">Mensahe</label>
                                <textarea
                                    x-model="initialMessage"
                                    @input="errors.initialMessage = ''"
                                    placeholder="Ano ang maitutulong namin sa iyo?"
                                    rows="3"
                                    class="w-full px-3 py-2 border-2 rounded-xl text-gray-900 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand-yellow/50 focus:border-brand-yellow transition-colors resize-none"
                                    :class="errors.initialMessage ? 'border-red-400' : 'border-gray-200'"
                                ></textarea>
                                <p x-show="errors.initialMessage" x-text="errors.initialMessage" class="text-red-500 text-xs mt-1"></p>
                            </div>
                            <p x-show="chatError" x-text="chatError" class="text-red-500 text-xs text-center mb-1"></p>
                            <button
                                type="submit"
                                :disabled="isLoading"
                                class="w-full py-2.5 bg-brand-yellow hover:bg-brand-yellow-hover text-brand-dark font-semibold rounded-xl transition-colors text-sm disabled:opacity-50"
                            >
                                <span x-show="!isLoading">Simulan ang Chat</span>
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
                            <div :class="msg.senderType === 'visitor' ? 'flex justify-end' : 'flex justify-start'">
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
        visitorName: '',
        visitorEmail: '',
        farmLocation: '',
        visitorType: '',
        initialMessage: '',
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
            // Restore session from localStorage
            const saved = localStorage.getItem('anisenso_chat_session');
            if (saved) {
                try {
                    const session = JSON.parse(saved);
                    this.conversationId = session.conversationId;
                    this.sessionId = session.sessionId;
                    this.visitorName = session.visitorName || '';
                    this.visitorEmail = session.visitorEmail || '';
                    this.farmLocation = session.farmLocation || '';
                    this.visitorType = session.visitorType || '';
                    if (this.conversationId) {
                        this.fetchMessages();
                        this.startPolling();
                    }
                } catch (e) {
                    localStorage.removeItem('anisenso_chat_session');
                }
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

            if (!this.visitorName.trim()) {
                this.errors.visitorName = 'Mangyaring ilagay ang iyong pangalan.';
                valid = false;
            }
            if (!this.visitorEmail.trim()) {
                this.errors.visitorEmail = 'Mangyaring ilagay ang iyong email.';
                valid = false;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.visitorEmail.trim())) {
                this.errors.visitorEmail = 'Mangyaring maglagay ng wastong email address.';
                valid = false;
            }
            if (!this.farmLocation) {
                this.errors.farmLocation = 'Mangyaring pumili ng probinsya.';
                valid = false;
            }
            if (!this.visitorType) {
                this.errors.visitorType = 'Mangyaring pumili ng uri.';
                valid = false;
            }
            if (!this.initialMessage.trim()) {
                this.errors.initialMessage = 'Mangyaring ilagay ang iyong mensahe.';
                valid = false;
            }

            if (valid) this.startChat();
        },

        async startChat() {
            this.isLoading = true;
            this.chatError = '';

            const payload = {
                name: this.visitorName,
                email: this.visitorEmail,
                farm_location: this.farmLocation,
                visitor_type: this.visitorType,
                message: this.initialMessage,
                session_id: this.sessionId,
            };

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
                        this.initialMessage = '';

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

            // Reset textarea height
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
                    if (res.status === 404) {
                        this.chatStatus = 'closed';
                    }
                    // Restore the message so the visitor can retry
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
                    headers: {
                        'Accept': 'application/json',
                    },
                });

                const data = await res.json();

                if (data.success) {
                    const prevCount = this.messages.length;
                    const prevStatus = this.chatStatus;
                    this.messages = data.messages;

                    // Count new admin messages as unread if chat is minimized
                    if (!this.isOpen && data.messages.length > prevCount) {
                        const newMsgs = data.messages.slice(prevCount);
                        const newAdminMsgs = newMsgs.filter(m => m.senderType === 'admin').length;
                        this.unreadCount += newAdminMsgs;
                    }

                    if (this.isOpen) {
                        this.$nextTick(() => this.scrollToBottom());
                    }

                    // If admin reopened a closed conversation, resume normal polling
                    if (data.status === 'active' && prevStatus === 'closed') {
                        this.chatStatus = 'active';
                        this.startPolling();
                    }

                    // Slow-poll when closed so visitor can detect a reopen
                    if (data.status === 'closed' && prevStatus !== 'closed') {
                        this.chatStatus = 'closed';
                        this.stopPolling();
                        this.pollInterval = setInterval(() => this.fetchMessages(), 3000);
                    }

                    // Default status sync for other cases
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
                visitorName: this.visitorName,
                visitorEmail: this.visitorEmail,
                farmLocation: this.farmLocation,
                visitorType: this.visitorType,
            }));
        },

        resetChat() {
            this.stopPolling();
            this.conversationId = null;
            this.sessionId = null;
            this.visitorName = '';
            this.visitorEmail = '';
            this.farmLocation = '';
            this.visitorType = '';
            this.initialMessage = '';
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
            text += 'Pangalan: ' + this.visitorName + '\n';
            text += 'Petsa: ' + new Date().toLocaleDateString('fil-PH', { year: 'numeric', month: 'long', day: 'numeric' }) + '\n';
            text += '==========================================\n\n';

            this.messages.forEach(function(msg) {
                const sender = msg.senderType === 'visitor' ? 'Ikaw' : 'Admin';
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
