        document.addEventListener('DOMContentLoaded', () => {
            const chatToggle = document.getElementById('chat-toggle');
            const chatOverlay = document.getElementById('chat-overlay');
            const chatClose = document.getElementById('chat-close');
            const chatMessages = document.getElementById('chat-messages');
            const chatForm = document.getElementById('chat-form');
            const chatInput = document.getElementById('chat-input');
            const chatBadge = document.getElementById('chat-badge');

            // Reply elements
            const replyBar = document.getElementById('chat-reply-bar');
            const replyName = document.getElementById('chat-reply-name');
            const replyText = document.getElementById('chat-reply-text');
            const replyCancel = document.getElementById('chat-reply-cancel');

            const API_URL = '{{ url("/admin/api/chat") }}';
            const CSRF = '{{ csrf_token() }}';
            const POLL_MS = 3000;

            let isOpen = false;
            let lastMsgId = 0;
            let pollTimer = null;
            let unreadCount = 0;
            let initialLoad = true;
            let isFetching = false;
            const renderedIds = new Set();
            let prevOnlineAdminIds = new Set();
            let isFirstOnlinePoll = true;

            function showOnlineToast(adminName, avatarUrl) {
                const toast = document.createElement('div');
                toast.className = 'admin-online-toast';
                toast.innerHTML = `
                    <img src="${avatarUrl}" alt="${adminName}">
                    <div class="admin-online-toast-info">
                        <strong>${adminName}</strong>
                        <span>🟢 Baru saja online</span>
                    </div>
                `;
                document.body.appendChild(toast);

                // Play notification chime
                try {
                    const ctx = new (window.AudioContext || window.webkitAudioContext)();
                    const osc = ctx.createOscillator();
                    const gain = ctx.createGain();
                    osc.connect(gain);
                    gain.connect(ctx.destination);
                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(880, ctx.currentTime); // High pitch (A5)
                    osc.frequency.exponentialRampToValueAtTime(1760, ctx.currentTime + 0.1); // Slide up to A6
                    gain.gain.setValueAtTime(0, ctx.currentTime);
                    gain.gain.linearRampToValueAtTime(0.1, ctx.currentTime + 0.05); // Fade in softly
                    gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.4); // Fade out
                    osc.start(ctx.currentTime);
                    osc.stop(ctx.currentTime + 0.4);
                } catch(e) {
                    // Ignore if browser blocks audio API before user interacts
                }

                // Trigger animation
                requestAnimationFrame(() => {
                    requestAnimationFrame(() => toast.classList.add('show'));
                });

                setTimeout(() => {
                    toast.classList.remove('show');
                    toast.classList.add('hide');
                    setTimeout(() => toast.remove(), 400);
                }, 4000);
            }

            // ── Reply state ─────────────────────────────────
            let replyToId = null;
            let replyToName = '';
            let replyToMsg = '';

            function setReply(id, name, message) {
                replyToId = id;
                replyToName = name;
                replyToMsg = message;
                replyName.textContent = name;
                replyText.textContent = message.length > 80 ? message.substring(0, 80) + '…' : message;
                replyBar.style.display = 'flex';
                chatInput.focus();
            }

            function clearReply() {
                replyToId = null;
                replyToName = '';
                replyToMsg = '';
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
                    const onlineAdmins = data.online_admins || [];

                    // Render Online Admins
                    const onlineContainer = document.getElementById('chat-online-admins');
                    const onlineStatus = document.getElementById('chat-online-status');

                    let currentOnlineIds = new Set();

                    if (onlineAdmins.length > 0) {
                        onlineStatus.innerHTML = `<span style="color:#10b981;font-size:8px;">●</span> ${onlineAdmins.length} Admin Online`;
                        onlineContainer.style.display = 'flex';
                        let avatarsHtml = '';
                        onlineAdmins.forEach(adm => {
                            currentOnlineIds.add(adm.id);
                            const backupUrl = `https://ui-avatars.com/api/?name=${encodeURIComponent(adm.name)}&background=${adm.is_it_me ? '1C1C1E' : '6366f1'}&color=ffffff&size=100`;
                            const avatarUrl = adm.avatar || backupUrl;

                            // Show toast if there's a new admin online
                            if (!isFirstOnlinePoll && !adm.is_it_me && !prevOnlineAdminIds.has(adm.id)) {
                                showOnlineToast(adm.name, avatarUrl);
                            }

                            avatarsHtml += `<div class="chat-online-avatar" title="${adm.name} ${adm.is_it_me ? '(Anda)' : ''}"><img src="${avatarUrl}" alt="${adm.name}"></div>`;
                        });
                        onlineContainer.innerHTML = avatarsHtml;
                    } else {
                        onlineStatus.innerHTML = `<span style="color:#ef4444;font-size:8px;">●</span> Offline`;
                        onlineContainer.style.display = 'none';
                    }

                    prevOnlineAdminIds = currentOnlineIds;
                    isFirstOnlinePoll = false;

                    if (lastMsgId === 0 && msgs.length === 0) {
                        chatMessages.innerHTML = `
                            <div class="chat-empty">
                                <div class="chat-empty-icon text-zinc-400">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                </div>
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
                    let isInitialLoad = (lastMsgId === 0);

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
                            // Only increment badge for genuinely new messages (not initial history load)
                            if (!isInitialLoad && !isOpen && !msg.is_mine) {
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
                    <div class="chat-msg-bubble-wrap">
                        <div class="chat-msg-bubble">
                            ${replyHtml}
                            ${escapeHtml(msg.message)}
                        </div>
                        <button type="button" class="chat-msg-reply-btn items-center justify-center pt-0.5" title="Reply"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg></button>
                    </div>
                    <div class="chat-msg-time-row">
                        <span class="chat-msg-time">${msg.created_at}</span>
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
                if (unreadCount > 0 && (!isOpen || !isFabOpen)) {
                    const txt = unreadCount > 99 ? '99+' : unreadCount;
                    chatBadge.textContent = txt;
                    chatBadge.style.display = 'flex';
                    if (chatBadgeMain) {
                        chatBadgeMain.textContent = txt;
                        chatBadgeMain.style.display = 'flex';
                    }
                } else {
                    chatBadge.style.display = 'none';
                    if (chatBadgeMain) chatBadgeMain.style.display = 'none';
                }
            }

            function escapeHtml(str) {
                const div = document.createElement('div');
                div.textContent = str;
                return div.innerHTML;
            }

            // ── CMD Logic ───────────────────────────────────
            const cmdToggle = document.getElementById('cmd-toggle');
            const cmdOverlay = document.getElementById('cmd-overlay');
            const cmdClose = document.getElementById('cmd-close');
            let isCmdOpen = false;

            if (cmdToggle && cmdOverlay) {
                cmdToggle.addEventListener('click', () => {
                    isCmdOpen = !isCmdOpen;
                    if (isCmdOpen) {
                        cmdOverlay.classList.remove('cmd-hidden');
                        cmdOverlay.classList.add('cmd-visible');
                        // Auto close chat if open
                        if (isOpen) {
                            isOpen = false;
                            closeChat();
                        }
                        setTimeout(() => document.getElementById('cmd-input').focus(), 350);
                    } else {
                        closeCmd();
                    }
                });

                cmdClose.addEventListener('click', () => {
                    isCmdOpen = false;
                    closeCmd();
                });

                function closeCmd() {
                    cmdOverlay.classList.remove('cmd-visible');
                    cmdOverlay.classList.add('cmd-hidden');
                }

                // Command Execution logic
                const __cmdForm = document.getElementById('cmd-form');
                const __cmdInput = document.getElementById('cmd-input');
                const __cmdHistory = document.getElementById('cmd-history');
                const __cmdOutputWrapper = document.getElementById('cmd-output-wrapper');
                const __btnClear = document.getElementById('btn-clear-cmd');
                const __cmdCsrf = CSRF;

                if (__cmdForm) {
                    __cmdForm.addEventListener('submit', async (e) => {
                        e.preventDefault();
                        const cmd = __cmdInput.value.trim();
                        if (!cmd) return;

                        const echo = document.createElement('div');
                        echo.className = 'text-zinc-100 font-bold mb-1 mt-3';
                        echo.innerText = `root@tc:~# ${cmd}`;
                        __cmdHistory.appendChild(echo);

                        __cmdInput.value = '';
                        __cmdInput.disabled = true;

                        const loading = document.createElement('div');
                        loading.className = 'text-zinc-500 animate-pulse text-xs';
                        loading.innerText = 'Executing...';
                        __cmdHistory.appendChild(loading);
                        __cmdOutputWrapper.scrollTop = __cmdOutputWrapper.scrollHeight;

                        try {
                            const res = await fetch('/admin/api/cmd', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': __cmdCsrf,
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({ command: cmd })
                            });
                            
                            const data = await res.json();
                            loading.remove();

                            const outputBlock = document.createElement('pre');
                            outputBlock.className = `whitespace-pre-wrap font-mono text-xs ${data.exit_code === 0 ? 'text-zinc-300' : 'text-amber-400'}`;
                            outputBlock.textContent = data.output || '(no output)';
                            __cmdHistory.appendChild(outputBlock);
                        } catch (err) {
                            loading.remove();
                            const errBlock = document.createElement('div');
                            errBlock.className = 'text-red-500 text-xs';
                            errBlock.innerText = `Network/Server Error: ${err.message}`;
                            __cmdHistory.appendChild(errBlock);
                        }

                        __cmdInput.disabled = false;
                        __cmdInput.focus();
                        __cmdOutputWrapper.scrollTop = __cmdOutputWrapper.scrollHeight;
                    });

                    __btnClear.addEventListener('click', () => {
                        __cmdHistory.innerHTML = '';
                        __cmdInput.focus();
                    });
                }
            }
            // ── Report Logic ───────────────────────────────────
            const reportToggle = document.getElementById('report-toggle');
            const reportOverlay = document.getElementById('report-overlay');
            const reportClose = document.getElementById('report-close');
            let isReportOpen = false;

            if (reportToggle && reportOverlay) {
                reportToggle.addEventListener('click', () => {
                    isReportOpen = !isReportOpen;
                    if (isReportOpen) {
                        reportOverlay.classList.remove('report-hidden');
                        reportOverlay.classList.add('report-visible');
                        if (isOpen) { isOpen = false; closeChat(); }
                        if (isCmdOpen) { isCmdOpen = false; closeCmd(); }
                    } else {
                        closeReport();
                    }
                });

                reportClose.addEventListener('click', () => {
                    isReportOpen = false;
                    closeReport();
                });

                function closeReport() {
                    reportOverlay.classList.remove('report-visible');
                    reportOverlay.classList.add('report-hidden');
                }
            }

            // ── Settings Logic ─────────────────────────────────
            const settingsToggle = document.getElementById('settings-toggle');
            const settingsOverlay = document.getElementById('settings-overlay');
            const settingsClose = document.getElementById('settings-close');
            let isSettingsOpen = false;

            if (settingsToggle && settingsOverlay) {
                settingsToggle.addEventListener('click', () => {
                    isSettingsOpen = !isSettingsOpen;
                    if (isSettingsOpen) {
                        settingsOverlay.classList.remove('settings-hidden');
                        settingsOverlay.classList.add('settings-visible');
                        if (isOpen) { isOpen = false; closeChat(); }
                        if (isCmdOpen) { isCmdOpen = false; closeCmd(); }
                        if (isReportOpen) { isReportOpen = false; closeReport(); }
                    } else {
                        closeSettings();
                    }
                });

                settingsClose.addEventListener('click', () => {
                    isSettingsOpen = false;
                    closeSettings();
                });

                function closeSettings() {
                    settingsOverlay.classList.remove('settings-visible');
                    settingsOverlay.classList.add('settings-hidden');
                }

                // Clear cache button
                const btnClearCache = document.getElementById('btn-clear-cache');
                if (btnClearCache) {
                    btnClearCache.addEventListener('click', () => {
                        if (confirm('Yakin ingin menghapus cache & storage lokal?')) {
                            localStorage.clear();
                            sessionStorage.clear();
                            btnClearCache.textContent = '✓ Cache Cleared!';
                            setTimeout(() => { btnClearCache.textContent = 'Clear Cache →'; }, 2000);
                        }
                    });
                }

                // Toggle settings persist to localStorage
                const settingNotif = document.getElementById('setting-notif');
                const settingDarkmode = document.getElementById('setting-darkmode');

                if (settingNotif) {
                    settingNotif.checked = localStorage.getItem('setting_notif') !== 'false';
                    settingNotif.addEventListener('change', () => {
                        localStorage.setItem('setting_notif', settingNotif.checked);
                    });
                }
                if (settingDarkmode) {
                    const darkKey = 'tc_dark_mode';
                    const isDark = localStorage.getItem(darkKey) === 'true';
                    
                    const applyTheme = (on) => {
                        document.documentElement.classList.toggle('dark-mode', on);
                        settingDarkmode.checked = on;
                    };

                    applyTheme(isDark);
                    
                    settingDarkmode.addEventListener('change', () => {
                        const on = settingDarkmode.checked;
                        localStorage.setItem(darkKey, on);
                        applyTheme(on);
                    });
                }

                // ── Language Setting ──
                const langCard = document.getElementById('setting-lang-card');
                const langBadge = document.getElementById('setting-lang-badge');
                const langDesc = document.getElementById('setting-lang-desc');

                if (langCard && langBadge && langDesc) {
                    const langKey = 'tc_lang';
                    let currentLang = localStorage.getItem(langKey) || 'id';

                    const updateLangUI = (lang) => {
                        if (lang === 'en') {
                            langBadge.textContent = 'EN';
                            langDesc.textContent = 'Interface language is currently in English.';
                        } else {
                            langBadge.textContent = 'ID';
                            langDesc.textContent = 'Bahasa antarmuka saat ini dalam Bahasa Indonesia.';
                        }
                    };

                    updateLangUI(currentLang);

                    langCard.addEventListener('click', () => {
                        currentLang = currentLang === 'id' ? 'en' : 'id';
                        localStorage.setItem(langKey, currentLang);
                        updateLangUI(currentLang);
                        // Optional: You could reload or trigger a re-render here if full i18n is implemented
                        // location.reload();
                    });
                }

                // ── Performance Setting ──
                const perfCard = document.getElementById('setting-perf-card');
                const perfBadge = document.getElementById('setting-perf-badge');
                const perfDesc = document.getElementById('setting-perf-desc');

                if (perfCard && perfBadge && perfDesc) {
                    const perfKey = 'tc_perf';
                    const perfModes = ['auto', 'max', 'eco'];
                    let currentPerf = localStorage.getItem(perfKey) || 'auto';
                    if (!perfModes.includes(currentPerf)) currentPerf = 'auto';

                    const updatePerfUI = (perf) => {
                        if (perf === 'max') {
                            perfBadge.textContent = 'MAX';
                            perfBadge.className = 'text-[10px] font-bold text-red-500 uppercase tracking-widest';
                            perfDesc.textContent = 'Performa maksimal tanpa delay. Animasi berjalan penuh.';
                        } else if (perf === 'eco') {
                            perfBadge.textContent = 'ECO';
                            perfBadge.className = 'text-[10px] font-bold text-emerald-500 uppercase tracking-widest';
                            perfDesc.textContent = 'Hemat daya. Beberapa efek visual dan animasi direduksi.';
                        } else {
                            perfBadge.textContent = 'AUTO';
                            perfBadge.className = 'text-[10px] font-bold text-zinc-500 uppercase tracking-widest';
                            perfDesc.textContent = 'Optimasi rendering SPA dan lazy-loading fragment otomatis.';
                        }
                    };

                    updatePerfUI(currentPerf);

                    perfCard.addEventListener('click', () => {
                        const nextIndex = (perfModes.indexOf(currentPerf) + 1) % perfModes.length;
                        currentPerf = perfModes[nextIndex];
                        localStorage.setItem(perfKey, currentPerf);
                        updatePerfUI(currentPerf);
                        
                        // Handle generic performance toggles visually (lazy-load, transitions)
                        if (currentPerf === 'eco') {
                            document.documentElement.style.setProperty('--animate-duration', '0s');
                            document.body.classList.add('perf-eco');
                        } else {
                            document.documentElement.style.removeProperty('--animate-duration');
                            document.body.classList.remove('perf-eco');
                        }
                    });

                    // Initial application of performance state
                    if (currentPerf === 'eco') {
                        document.documentElement.style.setProperty('--animate-duration', '0s');
                        document.body.classList.add('perf-eco');
                    }
                }

                // ── Compact UI Setting ──
                const settingCompact = document.getElementById('setting-compact');
                if (settingCompact) {
                    const compactKey = 'tc_compact';
                    const isCompact = localStorage.getItem(compactKey) === 'true';
                    
                    const applyCompact = (on) => {
                        document.body.classList.toggle('ui-compact', on);
                        settingCompact.checked = on;
                    };

                    applyCompact(isCompact);
                    
                    settingCompact.addEventListener('change', () => {
                        const on = settingCompact.checked;
                        localStorage.setItem(compactKey, on);
                        applyCompact(on);
                    });
                }

                // ── Sound Effects Setting ──
                const settingSound = document.getElementById('setting-sound');
                if (settingSound) {
                    const soundKey = 'tc_sound';
                    // Default to true if not set
                    const storedSound = localStorage.getItem(soundKey);
                    const isSoundOn = storedSound === null ? true : storedSound === 'true';
                    
                    settingSound.checked = isSoundOn;
                    
                    settingSound.addEventListener('change', () => {
                        localStorage.setItem(soundKey, settingSound.checked);
                    });
                }
            }

            // Also close settings when other overlays open
            if (reportToggle && settingsOverlay) {
                const origReportClick = reportToggle.onclick;
                reportToggle.addEventListener('click', () => {
                    if (isSettingsOpen) { isSettingsOpen = false; settingsOverlay.classList.remove('settings-visible'); settingsOverlay.classList.add('settings-hidden'); }
                });
            }

            {
                const reportImageInput = document.getElementById('report-image');
                const reportImagePreview = document.getElementById('report-image-preview');
                const reportImagePlaceholder = document.getElementById('report-image-placeholder');

                if (reportImageInput) {
                    reportImageInput.addEventListener('change', function() {
                        const file = this.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                reportImagePreview.src = e.target.result;
                                reportImagePreview.classList.remove('hidden');
                                reportImagePlaceholder.classList.add('opacity-0');
                            }
                            reader.readAsDataURL(file);
                        } else {
                            reportImagePreview.src = '';
                            reportImagePreview.classList.add('hidden');
                            reportImagePlaceholder.classList.remove('opacity-0');
                        }
                    });
                }

                const reportForm = document.getElementById('report-form');
                const btnSubmitReport = document.getElementById('btn-submit-report');
                const reportStatus = document.getElementById('report-status');

                if (reportForm) {
                    reportForm.addEventListener('submit', async (e) => {
                        e.preventDefault();
                        btnSubmitReport.disabled = true;
                        btnSubmitReport.innerText = 'Mengirim...';
                        reportStatus.classList.add('hidden');

                        const formData = new FormData(reportForm);

                        try {
                            const res = await fetch('{{ route("admin.report.store") }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': CSRF,
                                    'Accept': 'application/json'
                                },
                                body: formData
                            });

                            const data = await res.json();
                            
                            if (res.ok) {
                                reportStatus.innerText = data.message || 'Laporan terkirim!';
                                reportStatus.className = 'text-xs font-medium p-2 rounded-lg text-center bg-emerald-50 text-emerald-600 border border-emerald-200 mt-2 block';
                                setTimeout(() => {
                                    reportForm.reset();
                                    reportImagePreview.src = '';
                                    reportImagePreview.classList.add('hidden');
                                    reportImagePlaceholder.classList.remove('opacity-0');
                                    reportStatus.classList.add('hidden');
                                    isReportOpen = false;
                                    closeReport();
                                }, 3000);
                            } else {
                                throw new Error(data.message || 'Gagal mengirim laporan');
                            }
                        } catch (err) {
                            reportStatus.innerText = err.message;
                            reportStatus.className = 'text-xs font-medium p-2 rounded-lg text-center bg-red-50 text-red-600 border border-red-200 mt-2 block';
                        } finally {
                            btnSubmitReport.disabled = false;
                            btnSubmitReport.innerText = 'Kirim Laporan';
                        }
                    });
                }
            }

            // ── FAB Logic ───────────────────────────────────
            const fabMainToggle = document.getElementById('fab-main-toggle');
            const fabActions = document.getElementById('fab-actions');
            const fabIconBars = document.getElementById('fab-icon-bars');
            const fabIconClose = document.getElementById('fab-icon-close');
            let isFabOpen = false;

            if (fabMainToggle) {
                fabMainToggle.addEventListener('click', () => {
                    isFabOpen = !isFabOpen;
                    if (isFabOpen) {
                        fabActions.classList.remove('opacity-0', 'translate-y-4', 'pointer-events-none');
                        fabIconBars.classList.add('scale-0', '-rotate-90');
                        fabIconClose.classList.remove('scale-0', 'rotate-90');
                    } else {
                        fabActions.classList.add('opacity-0', 'translate-y-4', 'pointer-events-none');
                        fabIconBars.classList.remove('scale-0', '-rotate-90');
                        fabIconClose.classList.add('scale-0', 'rotate-90');
                        if (isOpen) { isOpen = false; closeChat(); }
                        if (isCmdOpen) { isCmdOpen = false; closeCmd(); }
                        if (isReportOpen) { isReportOpen = false; closeReport(); }
                    }
                });
            }

            // ── Notification Bell Logic ─────────────────────
            const notifToggle = document.getElementById('notif-toggle');
            const notifPanel = document.getElementById('notif-panel');
            const notifBadge = document.getElementById('notif-badge');
            const notifList = document.getElementById('notif-list');
            const notifMarkRead = document.getElementById('notif-mark-read');
            let isNotifOpen = false;
            let notifLoaded = false;

            function openNotifPanel() {
                notifPanel.classList.remove('opacity-0', 'translate-y-2', 'pointer-events-none');
                notifPanel.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto');
                isNotifOpen = true;
                if (!notifLoaded) {
                    loadNotifications();
                    notifLoaded = true;
                }
            }

            function closeNotifPanel() {
                notifPanel.classList.add('opacity-0', 'translate-y-2', 'pointer-events-none');
                notifPanel.classList.remove('opacity-100', 'translate-y-0', 'pointer-events-auto');
                isNotifOpen = false;
            }

            if (notifToggle && notifPanel) {
                notifToggle.addEventListener('click', (e) => {
                    e.stopPropagation();
                    isNotifOpen ? closeNotifPanel() : openNotifPanel();
                });

                // Close on click outside
                document.addEventListener('click', (e) => {
                    if (isNotifOpen && !notifPanel.contains(e.target) && !notifToggle.contains(e.target)) {
                        closeNotifPanel();
                    }
                });

                // Mark all as read
                if (notifMarkRead) {
                    notifMarkRead.addEventListener('click', () => {
                        notifBadge.style.display = 'none';
                        localStorage.setItem('admin_notif_read_at', Date.now());
                    });
                }
            }

            const NOTIF_COLORS = {
                rose:    { bg: 'bg-rose-50',    text: 'text-rose-600',    ring: 'ring-rose-200' },
                emerald: { bg: 'bg-emerald-50', text: 'text-emerald-600', ring: 'ring-emerald-200' },
                indigo:  { bg: 'bg-indigo-50',  text: 'text-indigo-600',  ring: 'ring-indigo-200' },
                amber:   { bg: 'bg-amber-50',   text: 'text-amber-600',  ring: 'ring-amber-200' },
            };

            const STATUS_LABELS = {
                pending:   { label: 'Pending',   cls: 'bg-amber-100 text-amber-700' },
                resolved:  { label: 'Resolved',  cls: 'bg-emerald-100 text-emerald-700' },
                published: { label: 'Published', cls: 'bg-indigo-100 text-indigo-700' },
                draft:     { label: 'Draft',     cls: 'bg-zinc-100 text-zinc-600' },
            };

            async function loadNotifications() {
                try {
                    const res = await fetch('{{ route("admin.notifications") }}', {
                        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                        credentials: 'same-origin',
                    });
                    if (!res.ok) throw new Error('Failed');
                    const data = await res.json();

                    // Get last read timestamp from localStorage
                    const lastReadTime = parseInt(localStorage.getItem('admin_notif_read_at')) || 0;

                    // Update badge only if pending > 0 AND the latest pending report is newer than our last read time
                    if (data.pending_count > 0 && data.latest_pending_time > lastReadTime) {
                        notifBadge.textContent = data.pending_count > 99 ? '99+' : data.pending_count;
                        notifBadge.style.display = 'flex';
                    } else {
                        notifBadge.style.display = 'none';
                    }

                    // Render items
                    if (!data.items || data.items.length === 0) {
                        notifList.innerHTML = `
                            <div class="flex flex-col items-center justify-center py-12 text-zinc-400">
                                <svg class="w-8 h-8 mb-2 text-zinc-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"></path></svg>
                                <p class="text-xs font-medium">Belum ada notifikasi</p>
                            </div>`;
                        return;
                    }

                    notifList.innerHTML = data.items.map(item => {
                        const c = NOTIF_COLORS[item.color] || NOTIF_COLORS.indigo;
                        const s = STATUS_LABELS[item.status] || STATUS_LABELS.draft;
                        return `
                        <div class="flex items-start gap-3 px-5 py-3.5 hover:bg-zinc-50/80 transition-colors cursor-default">
                            <span class="shrink-0 flex h-9 w-9 items-center justify-center rounded-xl ${c.bg} ${c.text} text-base ring-1 ${c.ring}">${item.icon}</span>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-2 mb-0.5">
                                    <p class="text-[13px] font-bold text-zinc-800 truncate">${item.title}</p>
                                    <span class="shrink-0 text-[9px] font-bold uppercase tracking-wider px-1.5 py-0.5 rounded-md ${s.cls}">${s.label}</span>
                                </div>
                                <p class="text-[11px] text-zinc-500 truncate">${item.body}</p>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-[10px] font-medium text-zinc-400">${item.user}</span>
                                    <span class="text-zinc-300">·</span>
                                    <span class="text-[10px] text-zinc-400">${item.time}</span>
                                </div>
                            </div>
                        </div>`;
                    }).join('');

                } catch (err) {
                    notifList.innerHTML = `
                        <div class="flex flex-col items-center justify-center py-12 text-zinc-400">
                            <p class="text-xs font-medium text-red-400">Gagal memuat notifikasi</p>
                        </div>`;
                }
            }

            // Auto-poll notifications badge every 30 seconds
            loadNotifications();
            setInterval(() => {
                loadNotifications();
            }, 30000);

            // Listen for manual triggers from other functions
            window.addEventListener('refreshNotifications', () => {
                loadNotifications();
            });

        });
    
