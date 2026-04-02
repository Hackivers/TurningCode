@extends('layouts.spa')

@section('content')
    <div class="flex min-h-screen">
        <aside class="w-56 shrink-0 border-r border-zinc-200 bg-zinc-900 p-4 text-white">
            <p class="mb-4 text-xs font-semibold uppercase tracking-wide text-zinc-400">Admin</p>
            <nav class="flex flex-col gap-1 text-sm">
                <a href="#" data-spa-page="dashboard"
                    class="rounded-md px-3 py-2 text-zinc-200 hover:bg-zinc-800">Dashboard</a>
                <a href="#" data-spa-page="main-materi"
                    class="rounded-md px-3 py-2 text-zinc-200 hover:bg-zinc-800">Main materi</a>
                <a href="#" data-spa-page="materi"
                    class="rounded-md px-3 py-2 text-zinc-200 hover:bg-zinc-800">Materi</a>
                <a href="#" data-spa-page="addsubmateri"
                    class="rounded-md px-3 py-2 text-zinc-200 hover:bg-zinc-800">Tambah sub materi</a>
            </nav>
            <form method="post" action="{{ route('logout') }}" class="mt-6">
                @csrf
                <button type="submit" class="w-full rounded-md border border-zinc-600 px-3 py-2 text-sm hover:bg-zinc-800">
                    Keluar
                </button>
            </form>
        </aside>
        <main class="flex-1 p-6">
            @if (session('success'))
                <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900">
                    {{ session('success') }}
                </div>
            @endif
            <div id="spa-content" class="min-h-[200px] rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
                <p class="text-sm text-zinc-500">Memuat…</p>
            </div>
        </main>
    </div>

    {{-- ═══════════════════════════════════════════════════════
         ADMIN GLOBAL CHAT WIDGET
    ═══════════════════════════════════════════════════════ --}}

    {{-- Floating toggle button --}}
    <button id="chat-toggle" type="button" aria-label="Toggle admin chat">
        <span id="chat-toggle-icon">💬</span>
        <span id="chat-badge" style="display:none;">0</span>
    </button>

    {{-- Chat overlay --}}
    <div id="chat-overlay" class="chat-hidden">
        <div id="chat-container">
            <div id="chat-header">
                <div id="chat-header-info">
                    <span id="chat-header-icon">💬</span>
                    <div>
                        <h3>Admin Chat</h3>
                        <p id="chat-online-status">Global • Semua admin</p>
                    </div>
                </div>
                <button id="chat-close" type="button" aria-label="Close chat">✕</button>
            </div>
            <div id="chat-messages">
                <div id="chat-loading">
                    <div class="chat-spinner"></div>
                    <p>Memuat pesan...</p>
                </div>
            </div>
            {{-- Reply preview bar --}}
            <div id="chat-reply-bar" style="display:none;">
                <div id="chat-reply-info">
                    <span id="chat-reply-icon">↩️</span>
                    <div id="chat-reply-content">
                        <span id="chat-reply-name"></span>
                        <span id="chat-reply-text"></span>
                    </div>
                </div>
                <button type="button" id="chat-reply-cancel" aria-label="Cancel reply">✕</button>
            </div>
            <form id="chat-form" autocomplete="off">
                <input type="text" id="chat-input" placeholder="Tulis pesan..." maxlength="2000" required>
                <button type="submit" id="chat-send">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 2L11 13"/><path d="M22 2L15 22L11 13L2 9L22 2Z"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <style>
        /* ═══════════════════════════════════════════════════
           CHAT TOGGLE BUTTON
        ═══════════════════════════════════════════════════ */
        #chat-toggle {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: none;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: #fff;
            font-size: 24px;
            cursor: pointer;
            box-shadow: 0 6px 24px rgba(99,102,241,0.4), 0 2px 8px rgba(0,0,0,0.1);
            z-index: 9998;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        #chat-toggle:hover {
            transform: scale(1.08);
            box-shadow: 0 8px 32px rgba(99,102,241,0.5), 0 4px 12px rgba(0,0,0,0.15);
        }
        #chat-toggle:active {
            transform: scale(0.95);
        }
        #chat-toggle.chat-open #chat-toggle-icon {
            display: none;
        }

        /* Badge */
        #chat-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            min-width: 22px;
            height: 22px;
            padding: 0 6px;
            border-radius: 11px;
            background: #ef4444;
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 6px rgba(239,68,68,0.4);
            animation: chat-badge-pulse 2s ease-in-out infinite;
        }
        @keyframes chat-badge-pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        /* ═══════════════════════════════════════════════════
           CHAT OVERLAY
        ═══════════════════════════════════════════════════ */
        #chat-overlay {
            position: fixed;
            bottom: 96px;
            right: 24px;
            z-index: 9999;
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            transform-origin: bottom right;
        }
        #chat-overlay.chat-hidden {
            opacity: 0;
            transform: scale(0.8) translateY(20px);
            pointer-events: none;
        }
        #chat-overlay.chat-visible {
            opacity: 1;
            transform: scale(1) translateY(0);
            pointer-events: auto;
        }

        /* ═══════════════════════════════════════════════════
           CHAT CONTAINER
        ═══════════════════════════════════════════════════ */
        #chat-container {
            width: 380px;
            max-height: 520px;
            border-radius: 20px;
            background: #fff;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15), 0 4px 16px rgba(0,0,0,0.08);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.06);
        }

        /* Header */
        #chat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: #fff;
        }
        #chat-header-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        #chat-header-icon {
            font-size: 24px;
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.15);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #chat-header h3 {
            margin: 0;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: -0.01em;
        }
        #chat-header p {
            margin: 2px 0 0;
            font-size: 11px;
            opacity: 0.8;
        }
        #chat-close {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: none;
            background: rgba(255,255,255,0.15);
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }
        #chat-close:hover {
            background: rgba(255,255,255,0.25);
        }

        /* Messages area */
        #chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 16px;
            min-height: 300px;
            max-height: 360px;
            background: #f8f9fb;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        #chat-messages::-webkit-scrollbar {
            width: 4px;
        }
        #chat-messages::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 2px;
        }

        /* Loading */
        #chat-loading {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 40px 0;
            color: #9ca3af;
            font-size: 13px;
        }
        .chat-spinner {
            width: 28px;
            height: 28px;
            border: 3px solid #e5e7eb;
            border-top-color: #6366f1;
            border-radius: 50%;
            animation: chat-spin 0.8s linear infinite;
        }
        @keyframes chat-spin {
            to { transform: rotate(360deg); }
        }

        /* Message bubbles */
        .chat-msg {
            display: flex;
            flex-direction: column;
            max-width: 80%;
            animation: chat-msg-in 0.25s ease-out;
            position: relative;
        }
        @keyframes chat-msg-in {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .chat-msg.mine {
            align-self: flex-end;
        }
        .chat-msg.other {
            align-self: flex-start;
        }
        .chat-msg-name {
            font-size: 11px;
            font-weight: 600;
            margin-bottom: 3px;
            padding: 0 4px;
        }
        .chat-msg.mine .chat-msg-name {
            color: #6366f1;
            text-align: right;
        }
        .chat-msg.other .chat-msg-name {
            color: #6b7280;
        }
        .chat-msg-bubble {
            padding: 10px 14px;
            border-radius: 16px;
            font-size: 13.5px;
            line-height: 1.45;
            word-break: break-word;
            position: relative;
        }
        .chat-msg.mine .chat-msg-bubble {
            background: linear-gradient(135deg, #6366f1, #818cf8);
            color: #fff;
            border-bottom-right-radius: 4px;
        }
        .chat-msg.other .chat-msg-bubble {
            background: #fff;
            color: #374151;
            border: 1px solid #e5e7eb;
            border-bottom-left-radius: 4px;
        }
        .chat-msg-time-row {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 3px;
            padding: 0 4px;
        }
        .chat-msg.mine .chat-msg-time-row {
            justify-content: flex-end;
        }
        .chat-msg-time {
            font-size: 10px;
            color: #9ca3af;
        }

        /* Reply button on hover */
        .chat-msg-reply-btn {
            width: 24px;
            height: 24px;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
            background: #fff;
            color: #6b7280;
            font-size: 12px;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            transition: all 0.15s;
            padding: 0;
            line-height: 1;
            flex-shrink: 0;
        }
        .chat-msg:hover .chat-msg-reply-btn {
            display: inline-flex;
        }
        .chat-msg-reply-btn:hover {
            background: #6366f1;
            color: #fff;
            border-color: #6366f1;
        }

        /* Reply quote inside bubble */
        .chat-reply-quote {
            padding: 6px 10px;
            border-radius: 8px;
            margin-bottom: 6px;
            font-size: 12px;
            line-height: 1.35;
            border-left: 3px solid;
            cursor: pointer;
            transition: opacity 0.15s;
        }
        .chat-reply-quote:hover {
            opacity: 0.85;
        }
        .chat-msg.mine .chat-reply-quote {
            background: rgba(255,255,255,0.15);
            border-left-color: rgba(255,255,255,0.5);
            color: rgba(255,255,255,0.9);
        }
        .chat-msg.other .chat-reply-quote {
            background: #f3f4f6;
            border-left-color: #6366f1;
            color: #6b7280;
        }
        .chat-reply-quote-name {
            font-weight: 700;
            font-size: 11px;
            display: block;
            margin-bottom: 2px;
        }
        .chat-msg.mine .chat-reply-quote-name {
            color: rgba(255,255,255,0.95);
        }
        .chat-msg.other .chat-reply-quote-name {
            color: #6366f1;
        }
        .chat-reply-quote-text {
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            max-width: 220px;
        }

        /* Reply preview bar above input */
        #chat-reply-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            padding: 8px 16px;
            background: #f0f0ff;
            border-top: 1px solid #e0e0ff;
            animation: chat-reply-bar-in 0.2s ease-out;
        }
        @keyframes chat-reply-bar-in {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }
        #chat-reply-info {
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 0;
            flex: 1;
        }
        #chat-reply-icon {
            font-size: 16px;
            flex-shrink: 0;
        }
        #chat-reply-content {
            min-width: 0;
            flex: 1;
        }
        #chat-reply-name {
            display: block;
            font-size: 11px;
            font-weight: 700;
            color: #6366f1;
        }
        #chat-reply-text {
            display: block;
            font-size: 12px;
            color: #6b7280;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        #chat-reply-cancel {
            width: 24px;
            height: 24px;
            border-radius: 6px;
            border: none;
            background: rgba(99,102,241,0.1);
            color: #6366f1;
            font-size: 13px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: background 0.15s;
        }
        #chat-reply-cancel:hover {
            background: rgba(99,102,241,0.2);
        }

        /* Date separator */
        .chat-date-sep {
            text-align: center;
            font-size: 11px;
            color: #9ca3af;
            padding: 8px 0 4px;
        }
        .chat-date-sep span {
            background: #f0f1f3;
            padding: 3px 12px;
            border-radius: 10px;
        }

        /* Empty state */
        .chat-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            color: #9ca3af;
            text-align: center;
        }
        .chat-empty-icon {
            font-size: 40px;
            margin-bottom: 12px;
        }
        .chat-empty p {
            font-size: 13px;
            margin: 0;
        }

        /* Form */
        #chat-form {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 16px;
            border-top: 1px solid #f0f1f3;
            background: #fff;
        }
        #chat-input {
            flex: 1;
            padding: 10px 14px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            font-size: 13.5px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            background: #f9fafb;
        }
        #chat-input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
            background: #fff;
        }
        #chat-send {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            border: none;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            flex-shrink: 0;
        }
        #chat-send:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(99,102,241,0.3);
        }
        #chat-send:active {
            transform: scale(0.95);
        }
        #chat-send:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        /* Responsive */
        @media (max-width: 480px) {
            #chat-overlay {
                bottom: 80px;
                right: 12px;
                left: 12px;
            }
            #chat-container {
                width: 100%;
            }
        }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const chatToggle   = document.getElementById('chat-toggle');
        const chatOverlay  = document.getElementById('chat-overlay');
        const chatClose    = document.getElementById('chat-close');
        const chatMessages = document.getElementById('chat-messages');
        const chatForm     = document.getElementById('chat-form');
        const chatInput    = document.getElementById('chat-input');
        const chatBadge    = document.getElementById('chat-badge');

        // Reply elements
        const replyBar    = document.getElementById('chat-reply-bar');
        const replyName   = document.getElementById('chat-reply-name');
        const replyText   = document.getElementById('chat-reply-text');
        const replyCancel = document.getElementById('chat-reply-cancel');

        const API_URL = '{{ url("/admin/api/chat") }}';
        const CSRF    = '{{ csrf_token() }}';
        const POLL_MS = 3000;

        let isOpen      = false;
        let lastMsgId   = 0;
        let pollTimer   = null;
        let unreadCount = 0;
        let initialLoad = true;
        let isFetching  = false;
        const renderedIds = new Set();

        // ── Reply state ─────────────────────────────────
        let replyToId   = null;
        let replyToName = '';
        let replyToMsg  = '';

        function setReply(id, name, message) {
            replyToId   = id;
            replyToName = name;
            replyToMsg  = message;
            replyName.textContent = name;
            replyText.textContent = message.length > 80 ? message.substring(0, 80) + '…' : message;
            replyBar.style.display = 'flex';
            chatInput.focus();
        }

        function clearReply() {
            replyToId   = null;
            replyToName = '';
            replyToMsg  = '';
            replyBar.style.display = 'none';
        }

        replyCancel.addEventListener('click', clearReply);

        // ── Toggle chat ─────────────────────────────────
        chatToggle.addEventListener('click', () => {
            isOpen = !isOpen;
            if (isOpen) {
                chatOverlay.classList.remove('chat-hidden');
                chatOverlay.classList.add('chat-visible');
                chatToggle.classList.add('chat-open');
                unreadCount = 0;
                updateBadge();
                if (initialLoad) {
                    loadMessages();
                    initialLoad = false;
                }
                startPolling();
                setTimeout(() => chatInput.focus(), 350);
            } else {
                closeChat();
            }
        });

        chatClose.addEventListener('click', () => {
            isOpen = false;
            closeChat();
        });

        function closeChat() {
            chatOverlay.classList.remove('chat-visible');
            chatOverlay.classList.add('chat-hidden');
            chatToggle.classList.remove('chat-open');
            clearReply();
        }

        // ── Load messages ───────────────────────────────
        async function loadMessages() {
            if (isFetching) return;
            isFetching = true;
            try {
                const url = lastMsgId > 0 ? `${API_URL}?after=${lastMsgId}` : API_URL;
                const res = await fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    credentials: 'same-origin',
                });
                if (!res.ok) return;

                const data = await res.json();
                const msgs = data.messages || [];

                if (lastMsgId === 0 && msgs.length === 0) {
                    chatMessages.innerHTML = `
                        <div class="chat-empty">
                            <div class="chat-empty-icon">💬</div>
                            <p>Belum ada pesan</p>
                            <p style="font-size:12px;margin-top:4px;">Mulai percakapan dengan admin lain!</p>
                        </div>`;
                    return;
                }

                if (lastMsgId === 0) {
                    chatMessages.innerHTML = '';
                    renderedIds.clear();
                }

                let hasNew = false;
                let lastDate = '';
                msgs.forEach(msg => {
                    // Skip already rendered messages
                    if (renderedIds.has(msg.id)) return;

                    if (msg.date !== lastDate) {
                        lastDate = msg.date;
                        const sep = document.createElement('div');
                        sep.className = 'chat-date-sep';
                        sep.innerHTML = `<span>${msg.date}</span>`;
                        chatMessages.appendChild(sep);
                    }

                    appendMessage(msg);
                    hasNew = true;

                    if (msg.id > lastMsgId) {
                        lastMsgId = msg.id;
                        if (!isOpen && !msg.is_mine) {
                            unreadCount++;
                        }
                    }
                });

                updateBadge();
                if (hasNew) scrollToBottom();
            } catch (e) {
                console.error('Chat load error:', e);
            } finally {
                isFetching = false;
            }
        }

        function appendMessage(msg) {
            // Prevent duplicate rendering
            if (renderedIds.has(msg.id)) return;
            renderedIds.add(msg.id);

            const div = document.createElement('div');
            div.className = `chat-msg ${msg.is_mine ? 'mine' : 'other'}`;
            div.setAttribute('data-msg-id', msg.id);

            // Build reply quote if replying to another message
            let replyHtml = '';
            if (msg.reply_to) {
                const rt = msg.reply_to;
                const truncated = rt.message.length > 60 ? rt.message.substring(0, 60) + '…' : rt.message;
                replyHtml = `
                    <div class="chat-reply-quote" data-scroll-to="${rt.id}">
                        <span class="chat-reply-quote-name">${escapeHtml(rt.user_name)}</span>
                        <span class="chat-reply-quote-text">${escapeHtml(truncated)}</span>
                    </div>`;
            }

            div.innerHTML = `
                <span class="chat-msg-name">${escapeHtml(msg.user_name)}</span>
                <div class="chat-msg-bubble">
                    ${replyHtml}
                    ${escapeHtml(msg.message)}
                </div>
                <div class="chat-msg-time-row">
                    <span class="chat-msg-time">${msg.created_at}</span>
                    <button type="button" class="chat-msg-reply-btn" title="Reply">↩</button>
                </div>
            `;

            // Reply button click
            const replyBtn = div.querySelector('.chat-msg-reply-btn');
            replyBtn.addEventListener('click', () => {
                setReply(msg.id, msg.user_name, msg.message);
            });

            // Click on reply quote to scroll to original message
            const quoteEl = div.querySelector('.chat-reply-quote');
            if (quoteEl) {
                quoteEl.addEventListener('click', () => {
                    const targetId = quoteEl.dataset.scrollTo;
                    const targetEl = chatMessages.querySelector(`[data-msg-id="${targetId}"]`);
                    if (targetEl) {
                        targetEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        targetEl.style.transition = 'background 0.3s';
                        targetEl.style.background = 'rgba(99,102,241,0.08)';
                        setTimeout(() => { targetEl.style.background = ''; }, 1500);
                    }
                });
            }

            chatMessages.appendChild(div);
        }

        // ── Send message ────────────────────────────────
        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const message = chatInput.value.trim();
            if (!message) return;

            const sendBtn = document.getElementById('chat-send');
            sendBtn.disabled = true;
            chatInput.value = '';

            const payload = { message };
            if (replyToId) {
                payload.reply_to_id = replyToId;
            }
            clearReply();

            try {
                const res = await fetch(API_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify(payload),
                });

                if (res.ok) {
                    const data = await res.json();
                    const msg = data.message;

                    const emptyEl = chatMessages.querySelector('.chat-empty');
                    if (emptyEl) emptyEl.remove();

                    appendMessage(msg);
                    if (msg.id > lastMsgId) lastMsgId = msg.id;
                    scrollToBottom();
                }
            } catch (e) {
                console.error('Chat send error:', e);
            } finally {
                sendBtn.disabled = false;
                chatInput.focus();
            }
        });

        // ── Polling ─────────────────────────────────────
        function startPolling() {
            stopPolling();
            pollTimer = setInterval(loadMessages, POLL_MS);
        }

        function stopPolling() {
            if (pollTimer) {
                clearInterval(pollTimer);
                pollTimer = null;
            }
        }

        startPolling();

        // ── Helpers ─────────────────────────────────────
        function scrollToBottom() {
            requestAnimationFrame(() => {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            });
        }

        function updateBadge() {
            if (unreadCount > 0 && !isOpen) {
                chatBadge.textContent = unreadCount > 99 ? '99+' : unreadCount;
                chatBadge.style.display = 'flex';
            } else {
                chatBadge.style.display = 'none';
            }
        }

        function escapeHtml(str) {
            const div = document.createElement('div');
            div.textContent = str;
            return div.innerHTML;
        }
    });
    </script>
@endsection
