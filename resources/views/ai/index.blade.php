{{-- resources/views/ai/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('AI Assistant') }}
        </h2>
    </x-slot>

    <div class="flex-1 overflow-hidden flex flex-col min-w-0">

        <!-- Header with Stats -->
        <div class="bg-white border-b border-gray-200 px-4 sm:px-6 py-4">
            <div class="flex items-center justify-between flex-wrap gap-4 min-w-0">
                <div class="flex items-center gap-4 min-w-0">
                    {{-- <div class="w-12 h-12 rounded-xl bg-red-600 flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div> --}}
                    <div class="min-w-0">
                        <h1 class="text-xl sm:text-2xl font-bold bg-gray-600 bg-clip-text text-transparent break-words">
                            FreelanceApp AI Assistant
                        </h1>
                        {{-- <p class="text-sm text-gray-600">
                            Powered by <span class="font-semibold text-purple-600">Groq</span>
                            <span
                                class="px-2 py-0.5 bg-green-100 text-green-700 text-xs font-semibold rounded-full ml-2">100%
                                GRATIS</span>
                            <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full ml-1">
                                Super Cepat</span>
                        </p> --}}
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 w-full md:w-auto">
                    <!-- Model Selector -->
                    <select id="modelSelector" onchange="changeModel(this.value)"
                        class="w-full sm:w-auto px-4 sm:px-10 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-400 focus:border-transparent cursor-pointer">
                        @foreach ($availableModels as $key => $name)
                            <option value="{{ $key }}" {{ $currentModel == $key ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Clear Chat Button -->
                    <button onclick="clearChat()"
                        class="w-full sm:w-auto px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Clear
                    </button>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-blue-100 rounded-lg p-3 shadow-xl">
                    <p class="text-xs text-blue-600 font-semibold mb-1">Response Time</p>
                    <p class="text-xl font-bold text-blue-700" id="avgResponseTime">N/A</p>
                </div>
                <div class="bg-green-100 rounded-lg p-3 shadow-xl">
                    <p class="text-xs text-green-600 font-semibold mb-1">Chats Today</p>
                    <p class="text-xl font-bold text-green-700" id="chatsToday">0</p>
                </div>
                <div class="bg-purple-100 rounded-lg p-3 shadow-xl">
                    <p class="text-xs text-purple-600 font-semibold mb-1">Total Chats</p>
                    <p class="text-xl font-bold text-purple-700" id="totalChats">0</p>
                </div>
                <div class="bg--orange-100 rounded-lg p-3 shadow-xl">
                    <p class="text-xs text-orange-600 font-semibold mb-1">Tokens Used</p>
                    <p class="text-xl font-bold text-orange-700" id="totalTokens">0</p>
                </div>
            </div>
        </div>

        <!-- Chat Container -->
        <div class="flex-1 overflow-y-auto chat-scroll px-4 sm:px-6 py-6 bg-gradient-to-br from-gray-50 to-blue-50">
            <div id="chatMessages" class="max-w-4xl mx-auto space-y-6">

                <!-- Welcome Message -->
                <div id="welcomeMessage" class="text-center py-8 sm:py-12">

                    <h2 class="text-2xl sm:text-3xl font-bold bg-blue-500 bg-clip-text text-transparent mb-3 break-words">
                        Hello, {{ Auth::user()->name }}! 👋
                    </h2>
                    <p class="text-gray-600 mb-2 max-w-2xl mx-auto">
                        I am your AI Assistant
                    </p>
                    <p class="text-sm text-gray-500 mb-8">
                        💬 Ask anything in natural language
                    </p>

                    <!-- Quick Questions -->
                    <div class="grid md:grid-cols-2 gap-4 max-w-3xl mx-auto">
                        <button onclick="askQuestion('How many projects were completed this month?')"
                            class="group p-4 bg-white rounded-xl border-2 border-gray-200 hover:border-purple-300 hover:shadow-lg transition-all text-left transform hover:scale-105">
                            <div class="flex items-start gap-3">
                                <div
                                    class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0 group-hover:bg-blue-200 transition-colors">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800 mb-1">Completed Projects</h3>
                                    <p class="text-sm text-gray-600">View this month's performance</p>
                                </div>
                            </div>
                        </button>

                        <button onclick="askQuestion('Which project has the closest deadline?')"
                            class="group p-4 bg-white rounded-xl border-2 border-gray-200 hover:border-purple-300 hover:shadow-lg transition-all text-left transform hover:scale-105">
                            <div class="flex items-start gap-3">
                                <div
                                    class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center flex-shrink-0 group-hover:bg-orange-200 transition-colors">
                                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800 mb-1">Closest Deadline</h3>
                                    <p class="text-sm text-gray-600">Check urgent projects</p>
                                </div>
                            </div>
                        </button>

                        <button onclick="askQuestion('What is the total revenue this month?')"
                            class="group p-4 bg-white rounded-xl border-2 border-gray-200 hover:border-purple-300 hover:shadow-lg transition-all text-left transform hover:scale-105">
                            <div class="flex items-start gap-3">
                                <div
                                    class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center flex-shrink-0 group-hover:bg-green-200 transition-colors">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800 mb-1">Revenue</h3>
                                    <p class="text-sm text-gray-600">Check your finances</p>
                                </div>
                            </div>
                        </button>

                        <button onclick="askQuestion('How was my productivity this week?')"
                            class="group p-4 bg-white rounded-xl border-2 border-gray-200 hover:border-purple-300 hover:shadow-lg transition-all text-left transform hover:scale-105">
                            <div class="flex items-start gap-3">
                                <div
                                    class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center flex-shrink-0 group-hover:bg-purple-200 transition-colors">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800 mb-1">Productivity</h3>
                                    <p class="text-sm text-gray-600">Analyze your performance</p>
                                </div>
                            </div>
                        </button>
                    </div>

                    {{-- <div class="mt-8 p-4 bg-blue-50 border border-blue-200 rounded-lg max-w-2xl mx-auto">
                        <p class="text-sm text-blue-800">
                            <svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <strong>Tips:</strong> You can ask in natural language! No need to use
                            kata kunci tertentu.
                        </p>
                    </div> --}}
                </div>

            </div>
        </div>

        <!-- Input Area -->
        <div class="bg-white border-t border-gray-200 px-4 py-4 md:px-6 md:py-4 shadow-lg">
            <div class="max-w-4xl mx-auto">
                <form id="chatForm" onsubmit="sendMessage(event)" class="relative">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <div class="flex-1 relative">
                            <textarea id="messageInput" rows="1" placeholder="Enter to send, Shift+Enter for a new line"
                                class="w-full px-4 py-3 pr-12 border-2 border-gray-300 rounded-xl focus:border-purple-400 focus:ring-4 focus:ring-purple-100 resize-none transition-all"
                                onkeydown="handleKeyPress(event)"></textarea>
                            <button type="button" onclick="clearInput()"
                                class="absolute right-3 top-3 text-gray-400 hover:text-gray-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <button type="submit" id="sendButton"
                            class="px-4 sm:px-6 py-3 bg-blue-500 text-white rounded-xl font-semibold hover:bg-blue-600 transition-all shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                            <span class="hidden sm:inline">Send</span>
                        </button>
                    </div>
                    <div class="flex items-center justify-between mt-2">
                        <p class="text-xs text-green-600 font-semibold">
                            ⚡ Last response: <span id="currentResponseTime">N/A</span>
                        </p>
                    </div>
                </form>
            </div>
        </div>

    </div>

    @push('styles')
        <style>
            @keyframes slideUp {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-slide-up {
                animation: slideUp 0.3s ease-out;
            }

            @keyframes typing {

                0%,
                100% {
                    opacity: 0.2;
                }

                50% {
                    opacity: 1;
                }
            }

            .typing-dot {
                animation: typing 1.4s infinite;
            }

            .typing-dot:nth-child(2) {
                animation-delay: 0.2s;
            }

            .typing-dot:nth-child(3) {
                animation-delay: 0.4s;
            }

            .chat-scroll::-webkit-scrollbar {
                width: 6px;
            }

            .chat-scroll::-webkit-scrollbar-track {
                background: #f1f1f1;
            }

            .chat-scroll::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 3px;
            }

            .chat-scroll::-webkit-scrollbar-thumb:hover {
                background: #94a3b8;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').content;
            const API_URL = '{{ route('ai.chat') }}';
            const STATS_URL = '{{ route('ai.stats') }}';
            const CHANGE_MODEL_URL = '{{ route('ai.changeModel') }}';
            const CLEAR_HISTORY_URL = '{{ route('ai.clearHistory') }}';

            let conversationId = null;
            let conversationHistory = [];

            // Load stats on page load
            document.addEventListener('DOMContentLoaded', function() {
                loadStats();
            });

            async function loadStats() {
                try {
                    const response = await fetch(STATS_URL, {
                        headers: {
                            'X-CSRF-TOKEN': CSRF_TOKEN,
                            'Accept': 'application/json',
                        }
                    });
                    const data = await response.json();

                    if (data.success) {
                        document.getElementById('totalChats').textContent = data.stats.total_chats;
                        document.getElementById('chatsToday').textContent = data.stats.chats_today;
                        document.getElementById('totalTokens').textContent = data.stats.total_tokens.toLocaleString();
                        document.getElementById('avgResponseTime').textContent = data.stats.avg_response_time_ms ?
                            `~${data.stats.avg_response_time_ms}ms` :
                            'N/A';
                    }
                } catch (error) {
                    console.error('Failed to load stats:', error);
                }
            }

            async function changeModel(model) {
                try {
                    const response = await fetch(CHANGE_MODEL_URL, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': CSRF_TOKEN,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            model
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        // Show toast notification
                        showToast(`Model changed to: ${data.model_name}`, 'success');

                        // Reset conversation
                        conversationId = null;
                        conversationHistory = [];
                    }
                } catch (error) {
                    console.error('Failed to change model:', error);
                    showToast('Failed to change model', 'error');
                }
            }

            function askQuestion(question) {
                document.getElementById('messageInput').value = question;
                sendMessage(new Event('submit'));
            }

            function handleKeyPress(event) {
                if (event.key === 'Enter' && !event.shiftKey) {
                    event.preventDefault();
                    sendMessage(event);
                }
            }

            function clearInput() {
                document.getElementById('messageInput').value = '';
                document.getElementById('messageInput').style.height = 'auto';
            }

            async function sendMessage(event) {
                event.preventDefault();

                const input = document.getElementById('messageInput');
                const message = input.value.trim();
                const sendButton = document.getElementById('sendButton');

                if (!message) return;

                // Disable input
                input.disabled = true;
                sendButton.disabled = true;

                const chatMessages = document.getElementById('chatMessages');
                const welcomeMessage = document.getElementById('welcomeMessage');
                if (welcomeMessage) {
                    welcomeMessage.remove();
                }

                // Add user message
                addUserMessage(message);
                clearInput();

                // Show typing indicator
                showTypingIndicator();

                const startTime = Date.now();

                try {
                    // Call Laravel API with conversation context
                    const response = await fetch(API_URL, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': CSRF_TOKEN,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            message,
                            conversation_id: conversationId
                        })
                    });

                    const data = await response.json();
                    const responseTime = Date.now() - startTime;

                    removeTypingIndicator();

                    if (data.success) {
                        addAIMessage(data.response, responseTime);

                        // Update conversation context
                        conversationId = data.conversation_id;
                        conversationHistory = data.conversation_history || [];

                        // Update stats
                        document.getElementById('currentResponseTime').textContent = `~${responseTime}ms`;
                        loadStats();

                        // Log usage for debugging
                        if (data.usage) {
                            console.log('✅ AI Usage:', data.usage);
                            console.log('⚡ Response time:', responseTime, 'ms');
                            console.log('🤖 Model:', data.model);
                        }
                    } else {
                        addErrorMessage(data.message || 'An error occurred while processing the request');
                    }

                } catch (error) {
                    console.error('Error:', error);
                    removeTypingIndicator();
                    addErrorMessage('Unable to connect to the server. Please try again.');
                } finally {
                    // Re-enable input
                    input.disabled = false;
                    sendButton.disabled = false;
                    input.focus();
                }
            }

            function addUserMessage(message) {
                const chatMessages = document.getElementById('chatMessages');
                const messageDiv = document.createElement('div');
                messageDiv.className = 'flex justify-end animate-slide-up';
                messageDiv.innerHTML = `
            <div class="max-w-[88%] sm:max-w-[80%] min-w-0">
                <div class="bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-2xl rounded-tr-none px-4 sm:px-5 py-3 shadow-md">
                    <p class="text-sm leading-relaxed whitespace-pre-wrap">${escapeHtml(message)}</p>
                </div>
                <p class="text-xs text-gray-500 mt-1 text-right">Just now</p>
            </div>
        `;
                chatMessages.appendChild(messageDiv);
                scrollToBottom();
            }

            function showTypingIndicator() {
                const chatMessages = document.getElementById('chatMessages');
                const typingDiv = document.createElement('div');
                typingDiv.id = 'typingIndicator';
                typingDiv.className = 'flex items-start gap-3 animate-slide-up';
                typingDiv.innerHTML = `
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center flex-shrink-0 shadow-md">
                <svg class="w-5 h-5 text-white animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <div class="bg-white border-2 border-gray-200 rounded-2xl rounded-tl-none px-4 sm:px-5 py-4 shadow-sm">
                <div class="flex gap-1.5">
                    <div class="w-2 h-2 bg-purple-500 rounded-full typing-dot"></div>
                    <div class="w-2 h-2 bg-purple-500 rounded-full typing-dot"></div>
                    <div class="w-2 h-2 bg-purple-500 rounded-full typing-dot"></div>
                </div>
            </div>
        `;
                chatMessages.appendChild(typingDiv);
                scrollToBottom();
            }

            function removeTypingIndicator() {
                const indicator = document.getElementById('typingIndicator');
                if (indicator) indicator.remove();
            }

            function addAIMessage(message, responseTime) {
                const chatMessages = document.getElementById('chatMessages');
                const messageDiv = document.createElement('div');
                messageDiv.className = 'flex items-start gap-3 animate-slide-up';
                messageDiv.innerHTML = `
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center flex-shrink-0 shadow-md">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <div class="flex-1 max-w-[88%] sm:max-w-[80%] min-w-0">
                <div class="bg-white border-2 border-gray-200 rounded-2xl rounded-tl-none px-4 sm:px-5 py-4 shadow-sm">
                    <div class="text-sm text-gray-800 leading-relaxed prose prose-sm max-w-none">
                        ${message}
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-1">
                    AI Assistant • Just now • ⚡ ${responseTime}ms
                </p>
            </div>
        `;
                chatMessages.appendChild(messageDiv);
                scrollToBottom();
            }

            function addErrorMessage(message) {
                const chatMessages = document.getElementById('chatMessages');
                const messageDiv = document.createElement('div');
                messageDiv.className = 'flex items-start gap-3 animate-slide-up';
                messageDiv.innerHTML = `
            <div class="w-10 h-10 rounded-xl bg-red-500 flex items-center justify-center flex-shrink-0 shadow-md">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="flex-1 max-w-[88%] sm:max-w-[80%] min-w-0">
                <div class="bg-red-50 border-2 border-red-200 rounded-2xl rounded-tl-none px-4 sm:px-5 py-4 shadow-sm">
                    <p class="text-sm text-red-800">${escapeHtml(message)}</p>
                </div>
                <p class="text-xs text-gray-500 mt-1">Error</p>
            </div>
        `;
                chatMessages.appendChild(messageDiv);
                scrollToBottom();
            }

            async function clearChat() {
                if (confirm('Are you sure you want to clear all conversations?')) {
                    try {
                        const response = await fetch(CLEAR_HISTORY_URL, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': CSRF_TOKEN,
                                'Accept': 'application/json',
                            }
                        });

                        const data = await response.json();
                        if (!data.success) {
                            showToast(data.message || 'Failed to clear conversations', 'error');
                            return;
                        }
                    } catch (error) {
                        console.error('Failed to clear chat history:', error);
                        showToast('Failed to clear conversations', 'error');
                        return;
                    }

                    conversationId = null;
                    conversationHistory = [];
                    location.reload();
                }
            }

            function scrollToBottom() {
                const chatContainer = document.querySelector('.chat-scroll');
                setTimeout(() => {
                    chatContainer.scrollTo({
                        top: chatContainer.scrollHeight,
                        behavior: 'smooth'
                    });
                }, 100);
            }

            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            function showToast(message, type = 'info') {
                const toast = document.createElement('div');
                toast.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white z-50 animate-slide-up ${
            type === 'success' ? 'bg-green-500' :
            type === 'error' ? 'bg-red-500' : 'bg-blue-500'
        }`;
                toast.textContent = message;
                document.body.appendChild(toast);

                setTimeout(() => {
                    toast.remove();
                }, 3000);
            }

            // Auto-resize textarea
            document.getElementById('messageInput').addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = Math.min(this.scrollHeight, 150) + 'px';
            });
        </script>
    @endpush
</x-app-layout>
