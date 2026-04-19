@extends('layouts.spa')

@section('content')
    <div class="flex min-h-screen bg-[#F8F9FB] text-zinc-800">
        {{-- ── ASIDE ── --}}
        <aside id="app-sidebar"
            class="fixed top-0 left-0 z-50 h-screen w-[260px] flex-col bg-white p-6 pt-10 border-r border-zinc-100 transition-all duration-300 flex overflow-y-auto overflow-x-hidden no-scrollbar">
            {{-- Logo --}}
            <div class="mb-14 flex items-center justify-center shrink-0">
                <div class="flex items-center gap-2 text-zinc-900 sidebar-logo">
                    <div class="h-4 w-4 shrink-0 bg-zinc-900"></div>
                    <div class="h-4 w-4 shrink-0 rounded-full bg-zinc-900"></div>
                    <div class="h-0 w-0 shrink-0 border-y-[8px] border-l-[10px] border-y-transparent border-l-zinc-900">
                    </div>
                </div>
            </div>

            {{-- Nav --}}
            <nav class="flex flex-col gap-2 text-[13px] font-semibold tracking-wide shrink-0" id="spa-nav">
                <a href="#" data-spa-page="dashboard"
                    class="nav-item flex items-center gap-4 rounded-2xl p-3.5 text-zinc-400 transition-all duration-200 [&.active]:bg-[#1C1C1E] [&.active]:text-white [&.active]:shadow-lg [&.active]:shadow-zinc-900/10 hover:[&:not(.active)]:bg-zinc-50 hover:[&:not(.active)]:text-zinc-900 group/link">
                    <span class="flex h-5 w-5 shrink-0 items-center justify-center translate-x-1 sidebar-icon">
                        <span class="grid grid-cols-2 gap-0.5" style="width: 14px; height: 14px;">
                            <span class="h-1.5 w-1.5 rounded-[2px] bg-current opacity-40"></span>
                            <span class="h-1.5 w-1.5 rounded-[2px] bg-current"></span>
                            <span class="h-1.5 w-1.5 rounded-[2px] bg-current opacity-70"></span>
                            <span class="h-1.5 w-1.5 rounded-[2px] bg-current opacity-40"></span>
                        </span>
                    </span>
                    <span class="sidebar-text truncate">Dashboard</span>
                </a>

                {{-- Data Main Materi --}}
                <a href="#" data-spa-page="main-materi"
                    class="nav-item flex items-center gap-4 rounded-2xl p-3.5 text-zinc-400 transition-all duration-200 [&.active]:bg-[#1C1C1E] [&.active]:text-white [&.active]:shadow-lg [&.active]:shadow-zinc-900/10 hover:[&:not(.active)]:bg-zinc-50 hover:[&:not(.active)]:text-zinc-900 group/link">
                    <span class="flex h-5 w-5 shrink-0 items-center justify-center translate-x-1 sidebar-icon">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                    </span>
                    <span class="sidebar-text truncate">Data Kategori</span>
                </a>

                {{-- Data Materi --}}
                <a href="#" data-spa-page="materi"
                    class="nav-item flex items-center gap-4 rounded-2xl p-3.5 text-zinc-400 transition-all duration-200 [&.active]:bg-[#1C1C1E] [&.active]:text-white [&.active]:shadow-lg [&.active]:shadow-zinc-900/10 hover:[&:not(.active)]:bg-zinc-50 hover:[&:not(.active)]:text-zinc-900 group/link">
                    <span class="flex h-5 w-5 shrink-0 items-center justify-center translate-x-1 sidebar-icon">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </span>
                    <span class="sidebar-text truncate">Data Topik</span>
                </a>

                {{-- Divider --}}
                <div class="my-2 border-t border-zinc-100 sidebar-text"></div>

                {{-- Kelola Sub Materi --}}
                <a href="#" data-spa-page="addsubmateri"
                    class="nav-item flex items-center gap-4 rounded-2xl p-3.5 text-zinc-400 transition-all duration-200 [&.active]:bg-[#1C1C1E] [&.active]:text-white [&.active]:shadow-lg [&.active]:shadow-zinc-900/10 hover:[&:not(.active)]:bg-zinc-50 hover:[&:not(.active)]:text-zinc-900 group/link">
                    <span class="flex h-5 w-5 shrink-0 items-center justify-center translate-x-1 sidebar-icon">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                    </span>
                    <span class="sidebar-text truncate">Manajemen Materi</span>
                </a>

                {{-- Kelola Soal --}}
                <a href="#" data-spa-page="questions"
                    class="nav-item flex items-center gap-4 rounded-2xl p-3.5 text-zinc-400 transition-all duration-200 [&.active]:bg-[#1C1C1E] [&.active]:text-white [&.active]:shadow-lg [&.active]:shadow-zinc-900/10 hover:[&:not(.active)]:bg-zinc-50 hover:[&:not(.active)]:text-zinc-900 group/link">
                    <span class="flex h-5 w-5 shrink-0 items-center justify-center translate-x-1 sidebar-icon">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </span>
                    <span class="sidebar-text truncate">Bank Soal</span>
                </a>

                {{-- Divider --}}
                <div class="my-2 border-t border-zinc-100 sidebar-text"></div>

                {{-- Struktur Database --}}
                <a href="#" data-spa-page="database"
                    class="nav-item flex items-center gap-4 rounded-2xl p-3.5 text-zinc-400 transition-all duration-200 [&.active]:bg-[#1C1C1E] [&.active]:text-white [&.active]:shadow-lg [&.active]:shadow-zinc-900/10 hover:[&:not(.active)]:bg-zinc-50 hover:[&:not(.active)]:text-zinc-900 group/link">
                    <span class="flex h-5 w-5 shrink-0 items-center justify-center translate-x-1 sidebar-icon">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4">
                            </path>
                        </svg>
                    </span>
                    <span class="sidebar-text truncate">Struktur Database</span>
                </a>
            </nav>

            <div class="mt-auto shrink-0 flex flex-col gap-4">
                <form method="post" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button type="submit"
                        class="flex w-full items-center gap-4 rounded-2xl p-3.5 text-[13px] font-semibold text-zinc-400 transition-colors hover:bg-zinc-50 hover:text-red-500">
                        <span class="flex h-5 w-5 shrink-0 items-center justify-center translate-x-1">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                        </span>
                        <span class="sidebar-text">Logout</span>
                    </button>
                </form>

                {{-- Profile Section (Minimalist Trigger) --}}
                <div class="relative mt-2" id="detail-profile-container">


                    {{-- The Minimalist Trigger --}}
                    <button type="button" id="detail-profile-trigger" class="sidebar-text w-full flex items-center justify-between rounded-2xl bg-zinc-50 p-2 border border-zinc-100 transition-colors hover:bg-zinc-100 hover:border-zinc-200 focus:outline-none">
                        <div class="flex items-center gap-3 overflow-hidden">
                            <div class="relative h-10 w-10 shrink-0 rounded-full border border-zinc-200">
                                <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=f4f4f5&color=18181b' }}" 
                                     alt="Profile" 
                                     class="h-full w-full rounded-full object-cover">
                                <div class="absolute bottom-0 right-0 h-2.5 w-2.5 rounded-full border-2 border-white bg-emerald-500"></div>
                            </div>
                            
                            <div class="flex flex-col text-left overflow-hidden">
                                <h3 class="text-xs font-bold text-zinc-900 truncate">{{ auth()->user()->name }}</h3>
                                <p class="text-[10px] font-medium text-zinc-500 truncate">{{ auth()->user()->email }}</p>
                            </div>
                        </div>

                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl text-zinc-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path>
                            </svg>
                        </div>
                    </button>
                </div>
            </div>
        </aside>

        {{-- ── MAIN CONTENT ── --}}
        <main id="app-main" class="flex-1 flex flex-col min-w-0 ml-[260px] transition-all duration-300">
            {{-- Header --}}
            <header class="flex items-center justify-between px-8 lg:px-[60px] py-10 bg-[#F8F9FB] mt-2 shrink-0">
                <div class="flex items-center gap-6">
                    <button id="sidebar-toggle"
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-white shadow-sm ring-1 ring-inset ring-zinc-200/50 text-zinc-500 transition-colors hover:bg-zinc-50 hover:text-zinc-900 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <div>
                        @php $name = explode(" ", auth()->user()->name ?? 'Admin')[0]; @endphp
                        <h1 class="text-3xl font-[800] text-zinc-900 tracking-tight leading-none mb-2">Hello, {{ $name }}
                        </h1>
                        <p class="text-[13px] text-zinc-400 font-medium tracking-wide">Welcome back!</p>
                    </div>
                </div>

                <div class="flex items-center gap-[30px]">
                    <div class="relative w-[260px] hidden md:block">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-5 pointer-events-none">
                            <span class="text-zinc-500 text-sm font-semibold">Q</span>
                        </div>
                        <input type="text"
                            class="block w-full rounded-[20px] bg-[#f0f1f4] border-0 py-3.5 pl-12 pr-4 text-[13px] text-zinc-900 placeholder:text-zinc-500 font-medium focus:ring-0 focus:outline-none transition-all hover:bg-[#ebecef] focus:bg-[#ebecef]"
                            placeholder="Search">
                    </div>

                    <div class="flex items-center gap-6 text-zinc-600 relative">
                        <button type="button" id="notif-toggle"
                            class="flex h-11 w-11 items-center justify-center rounded-[16px] bg-white shadow-sm ring-1 ring-inset ring-zinc-200/50 transition-colors hover:bg-zinc-50 relative shrink-0">
                            <svg class="h-[18px] w-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"></path>
                            </svg>
                            <span id="notif-badge" class="absolute -top-1 -right-1 min-w-[18px] h-[18px] px-[4px] rounded-full bg-red-500 text-white text-[9px] font-black flex items-center justify-center shadow-sm animate-pulse" style="display:none;">0</span>
                        </button>

                        {{-- Notification Dropdown Panel --}}
                        <div id="notif-panel" class="absolute right-0 top-[calc(100%+8px)] w-[380px] max-h-[480px] rounded-2xl bg-white border border-zinc-200 shadow-[0_20px_40px_-8px_rgba(0,0,0,0.12)] z-[200] opacity-0 translate-y-2 pointer-events-none transition-all duration-300 flex flex-col overflow-hidden">
                            {{-- Panel Header --}}
                            <div class="flex items-center justify-between px-5 py-4 border-b border-zinc-100">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-indigo-50 text-indigo-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"></path></svg>
                                    </span>
                                    <div>
                                        <h3 class="text-sm font-extrabold text-zinc-900">Notifikasi</h3>
                                        <p class="text-[10px] text-zinc-400 font-medium">Aktivitas terbaru</p>
                                    </div>
                                </div>
                                <button type="button" id="notif-mark-read" class="text-[10px] font-bold uppercase tracking-widest text-indigo-500 hover:text-indigo-700 transition-colors px-2 py-1 rounded-lg hover:bg-indigo-50">Tandai dibaca</button>
                            </div>

                            {{-- Panel Body --}}
                            <div id="notif-list" class="flex-1 overflow-y-auto divide-y divide-zinc-50">
                                <div class="flex items-center justify-center py-10 text-zinc-400">
                                    <svg class="w-5 h-5 animate-spin mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                    <span class="text-xs font-medium">Memuat...</span>
                                </div>
                            </div>

                            {{-- Panel Footer --}}
                            <div class="border-t border-zinc-100 px-5 py-3 bg-zinc-50/50">
                                <p class="text-[10px] text-center text-zinc-400 font-medium uppercase tracking-widest">Menampilkan 10 terbaru</p>
                            </div>
                        </div>

                        <div
                            class="h-11 w-11 overflow-hidden rounded-[16px] shadow-sm relative shrink-0 ring-1 ring-zinc-200/50">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($name) }}&background=6366f1&color=ffffff"
                                alt="Avatar" class="h-full w-full object-cover">
                        </div>
                    </div>
                </div>
            </header>

            {{-- SPA Fragment Container --}}
            <div class="flex-1 px-8 lg:px-[60px] pb-10">
                @if (session('success'))
                    <div
                        class="mb-6 rounded-2xl border border-emerald-100 bg-emerald-50 px-6 py-4 text-sm font-medium text-emerald-800 shadow-[0_4px_15px_-3px_rgba(16,185,129,0.1)]">
                        {{ session('success') }}
                    </div>
                @endif
                <div id="spa-content" class="w-full">
                    <p class="text-sm text-zinc-500 font-medium">Memuat UI...</p>
                </div>
            </div>
        </main>
    </div>

    {{-- Script for Sidebar Collapse --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('app-sidebar');
            const main = document.getElementById('app-main');

            // Detailed Profile Popup Logic
            const detailProfileTrigger = document.getElementById('detail-profile-trigger');
            const detailProfilePopup = document.getElementById('detail-profile-popup');
            let isDetailProfileOpen = false;

            if (detailProfileTrigger && detailProfilePopup) {
                const togglePopup = (forceState) => {
                    isDetailProfileOpen = forceState;
                    if (isDetailProfileOpen) {
                        const rect = detailProfileTrigger.getBoundingClientRect();
                        detailProfilePopup.style.left = (rect.right + 24) + 'px';
                        detailProfilePopup.style.bottom = (window.innerHeight - rect.bottom - 4) + 'px';
                        detailProfilePopup.style.zIndex = '99999';
                        
                        detailProfilePopup.style.opacity = '1';
                        detailProfilePopup.style.transform = 'translateY(0) scale(1)';
                        detailProfilePopup.style.pointerEvents = 'auto';
                    } else {
                        detailProfilePopup.style.opacity = '0';
                        detailProfilePopup.style.transform = 'translateY(12px) scale(0.95)';
                        detailProfilePopup.style.pointerEvents = 'none';
                    }
                };

                detailProfileTrigger.addEventListener('click', (e) => {
                    e.stopPropagation();
                    togglePopup(!isDetailProfileOpen);
                });

                document.addEventListener('click', (e) => {
                    if (isDetailProfileOpen && !detailProfileTrigger.contains(e.target) && !detailProfilePopup.contains(e.target)) {
                        togglePopup(false);
                    }
                });

                detailProfilePopup.addEventListener('click', (e) => {
                    if (e.target.closest('a')) {
                        togglePopup(false);
                    }
                });
            }


            let isCollapsed = localStorage.getItem('sidebar_collapsed') === 'true';

            const applySidebarState = () => {
                if (isCollapsed) {
                    sidebar.classList.remove('w-[260px]', 'p-6');
                    sidebar.classList.add('w-[88px]', 'p-3');
                    main.classList.remove('ml-[260px]');
                    main.classList.add('ml-[88px]');
                    // Hide text
                    document.querySelectorAll('.sidebar-text').forEach(el => el.classList.add('hidden'));
                    document.querySelectorAll('.sidebar-logo').forEach(el => el.classList.add('scale-75'));
                    document.querySelectorAll('.sidebar-icon').forEach(el => el.classList.replace('translate-x-1', 'translate-x-[5px]'));
                } else {
                    sidebar.classList.remove('w-[88px]', 'p-3');
                    sidebar.classList.add('w-[260px]', 'p-6');
                    main.classList.remove('ml-[88px]');
                    main.classList.add('ml-[260px]');
                    // Show text
                    document.querySelectorAll('.sidebar-text').forEach(el => el.classList.remove('hidden'));
                    document.querySelectorAll('.sidebar-logo').forEach(el => el.classList.remove('scale-75'));
                    document.querySelectorAll('.sidebar-icon').forEach(el => el.classList.replace('translate-x-[5px]', 'translate-x-1'));
                }
            };

            // Apply on load
            applySidebarState();

            // Toggle
            if (toggleBtn) {
                toggleBtn.addEventListener('click', () => {
                    isCollapsed = !isCollapsed;
                    localStorage.setItem('sidebar_collapsed', isCollapsed);
                    applySidebarState();
                });
            }
        });
    </script>

    {{-- ═══════════════════════════════════════════════════════
    ADMIN GLOBAL CHAT WIDGET
    ═══════════════════════════════════════════════════════ --}}

    {{-- Floating Action Menu (FAB) --}}
    <div id="fab-container" class="fixed bottom-6 right-6 z-[9998] flex flex-col-reverse items-end gap-2">
        {{-- Main Toggle --}}
        <button id="fab-main-toggle" type="button" aria-label="Toggle Admin Tools" class="w-14 h-14 rounded-full bg-indigo-600 text-white flex items-center justify-center shadow-[0_8px_24px_rgba(79,70,229,0.4)] transition-transform duration-300 hover:scale-105 active:scale-95 z-[9999] relative">
            <svg id="fab-icon-bars" class="w-6 h-6 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
            <svg id="fab-icon-close" class="w-6 h-6 absolute transition-transform duration-300 scale-0 rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            <span id="chat-badge-main" class="absolute -top-1 -right-1 min-w-[20px] h-[20px] px-[5px] rounded-full bg-red-500 text-white text-[10px] font-black flex items-center justify-center shadow-sm animate-pulse" style="display:none;">0</span>
        </button>

        {{-- Sub Actions --}}
        <div id="fab-actions" class="flex flex-col-reverse items-end gap-2 transition-all duration-300 opacity-0 translate-y-4 pointer-events-none origin-bottom">
            {{-- Floating toggle button --}}
            <button id="chat-toggle" type="button" aria-label="Toggle admin chat" class="w-12 h-12 rounded-full border-none bg-[#1C1C1E] text-white flex items-center justify-center shadow-[0_8px_24px_rgba(0,0,0,0.15)] transition-transform duration-300 hover:scale-110 relative group">
                <span id="chat-toggle-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                </span>
                <span id="chat-badge" style="display:none;" class="absolute -top-1 -right-1 min-w-[18px] h-[18px] px-[4px] rounded-full bg-red-500 text-white text-[9px] font-black flex items-center justify-center shadow-sm animate-pulse">0</span>
                <span class="absolute right-full mr-3 bg-zinc-800 text-white text-[10px] uppercase font-bold tracking-widest px-2 py-1 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap">Global Chat</span>
            </button>

            {{-- Floating CMD toggle button --}}
            <button id="cmd-toggle" type="button" aria-label="Toggle System Terminal" class="w-12 h-12 rounded-full border-none bg-[#121214] text-emerald-400 flex items-center justify-center text-sm font-mono font-bold shadow-[0_8px_24px_rgba(0,0,0,0.15)] transition-transform duration-300 hover:scale-110 relative group">
                <span id="cmd-toggle-icon">>_</span>
                <span class="absolute right-full mr-3 bg-zinc-800 text-white text-[10px] uppercase font-bold tracking-widest px-2 py-1 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap">System Terminal</span>
            </button>

            {{-- Floating Settings toggle button --}}
            <button id="settings-toggle" type="button" aria-label="Settings" class="w-12 h-12 rounded-full border-none bg-zinc-700 text-white flex items-center justify-center shadow-[0_8px_24px_rgba(0,0,0,0.2)] transition-transform duration-300 hover:scale-110 relative group">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                <span class="absolute right-full mr-3 bg-zinc-800 text-white text-[10px] uppercase font-bold tracking-widest px-2 py-1 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap">Settings</span>
            </button>

            {{-- Floating Report toggle button --}}
            <button id="report-toggle" type="button" aria-label="Lapor Issue" class="w-12 h-12 rounded-full border-none bg-red-500 text-white flex items-center justify-center text-xl shadow-[0_8px_24px_rgba(239,68,68,0.4)] transition-transform duration-300 hover:scale-110 relative group">
                <span id="report-toggle-icon">🚩</span>
                <span class="absolute right-full mr-3 bg-zinc-800 text-white text-[10px] uppercase font-bold tracking-widest px-2 py-1 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap">Lapor Masalah</span>
            </button>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════
    SETTINGS POPUP OVERLAY
    ═══════════════════════════════════════════════════════ --}}
    <div id="settings-overlay" class="settings-hidden">
        <div id="settings-container" class="rounded-3xl overflow-hidden shadow-[0_30px_80px_rgba(0,0,0,0.6)] border border-zinc-700/50" style="width: 560px; max-height: 85vh;">
            {{-- Header --}}
            <div class="flex items-center justify-between px-8 py-6 border-b border-zinc-800" style="background: #111113;">
                <div class="flex items-center gap-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-zinc-800 text-zinc-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-white uppercase tracking-widest">Settings</h3>
                        <p class="text-[10px] text-zinc-500 font-medium">Pengaturan preferensi admin</p>
                    </div>
                </div>
                <button id="settings-close" type="button" aria-label="Close settings" class="flex h-8 w-8 items-center justify-center rounded-xl text-zinc-500 hover:text-white hover:bg-zinc-800 transition-colors">✕</button>
            </div>

            {{-- Content Grid --}}
            <div class="p-6 overflow-y-auto" style="background: #0e0e10; max-height: calc(85vh - 80px);">
                <div class="grid grid-cols-2 gap-3">

                    {{-- Notifikasi --}}
                    <div class="settings-card group relative overflow-hidden rounded-2xl p-5 transition-all duration-300 cursor-pointer hover:ring-1 hover:ring-zinc-600" style="background: #1a1a1e;">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex h-10 w-10 items-center justify-center rounded-2xl transition-colors" style="background: #242428;">
                                <svg class="h-5 w-5 text-zinc-400 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"></path></svg>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="setting-notif" class="sr-only peer" checked>
                                <div class="w-9 h-5 bg-zinc-700 rounded-full peer peer-checked:bg-emerald-500 transition-colors after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-full"></div>
                            </label>
                        </div>
                        <h4 class="text-sm font-bold text-white mb-1">Notifikasi</h4>
                        <p class="text-[11px] text-zinc-500 leading-relaxed">Aktifkan push notifikasi untuk jadwal dan update sistem.</p>
                    </div>

                    {{-- Dark Mode --}}
                    <div class="settings-card group relative overflow-hidden rounded-2xl p-5 transition-all duration-300 cursor-pointer hover:ring-1 hover:ring-zinc-600" style="background: #1a1a1e;">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex h-10 w-10 items-center justify-center rounded-2xl transition-colors" style="background: #242428;">
                                <svg class="h-5 w-5 text-zinc-400 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="setting-darkmode" class="sr-only peer">
                                <div class="w-9 h-5 bg-zinc-700 rounded-full peer peer-checked:bg-emerald-500 transition-colors after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-full"></div>
                            </label>
                        </div>
                        <h4 class="text-sm font-bold text-white mb-1">Dark Mode</h4>
                        <p class="text-[11px] text-zinc-500 leading-relaxed">Mode gelap untuk mengurangi cahaya layar pada malam hari.</p>
                    </div>

                    {{-- Data & Storage --}}
                    <div class="settings-card group relative overflow-hidden rounded-2xl p-5 transition-all duration-300 cursor-pointer hover:ring-1 hover:ring-zinc-600" style="background: #1a1a1e;">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex h-10 w-10 items-center justify-center rounded-2xl transition-colors" style="background: #242428;">
                                <svg class="h-5 w-5 text-zinc-400 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                            </div>
                            <span class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest">Cache</span>
                        </div>
                        <h4 class="text-sm font-bold text-white mb-1">Data & Storage</h4>
                        <p class="text-[11px] text-zinc-500 leading-relaxed">Kelola cache browser dan data sesi admin lokal.</p>
                        <button type="button" id="btn-clear-cache" class="mt-3 text-[10px] font-bold uppercase tracking-widest text-red-400 hover:text-red-300 transition-colors">Clear Cache →</button>
                    </div>

                    {{-- Bahasa --}}
                    <div class="settings-card group relative overflow-hidden rounded-2xl p-5 transition-all duration-300 cursor-pointer hover:ring-1 hover:ring-zinc-600" style="background: #1a1a1e;">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex h-10 w-10 items-center justify-center rounded-2xl transition-colors" style="background: #242428;">
                                <svg class="h-5 w-5 text-zinc-400 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                            </div>
                            <span class="inline-flex items-center rounded-lg px-2 py-0.5 text-[9px] font-black uppercase tracking-widest text-emerald-400" style="background: #242428;">ID</span>
                        </div>
                        <h4 class="text-sm font-bold text-white mb-1">Bahasa</h4>
                        <p class="text-[11px] text-zinc-500 leading-relaxed">Bahasa antarmuka saat ini dalam Bahasa Indonesia.</p>
                    </div>

                    {{-- Keamanan --}}
                    <div class="settings-card group relative overflow-hidden rounded-2xl p-5 transition-all duration-300 cursor-pointer hover:ring-1 hover:ring-zinc-600" style="background: #1a1a1e;">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex h-10 w-10 items-center justify-center rounded-2xl transition-colors" style="background: #242428;">
                                <svg class="h-5 w-5 text-zinc-400 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="setting-security" class="sr-only peer" checked>
                                <div class="w-9 h-5 bg-zinc-700 rounded-full peer peer-checked:bg-emerald-500 transition-colors after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-full"></div>
                            </label>
                        </div>
                        <h4 class="text-sm font-bold text-white mb-1">Keamanan</h4>
                        <p class="text-[11px] text-zinc-500 leading-relaxed">CSRF protection dan session guard aktif secara default.</p>
                    </div>

                    {{-- Performa --}}
                    <div class="settings-card group relative overflow-hidden rounded-2xl p-5 transition-all duration-300 cursor-pointer hover:ring-1 hover:ring-zinc-600" style="background: #1a1a1e;">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex h-10 w-10 items-center justify-center rounded-2xl transition-colors" style="background: #242428;">
                                <svg class="h-5 w-5 text-zinc-400 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <span class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest">Auto</span>
                        </div>
                        <h4 class="text-sm font-bold text-white mb-1">Performa</h4>
                        <p class="text-[11px] text-zinc-500 leading-relaxed">Optimasi rendering SPA dan lazy-loading fragment otomatis.</p>
                    </div>

                </div>

                {{-- Footer Info --}}
                <div class="mt-6 rounded-2xl p-4 flex items-center gap-4" style="background: #1a1a1e;">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl" style="background: #242428;">
                        <div class="flex items-center gap-0.5 text-zinc-500">
                            <div class="h-2.5 w-2.5 bg-zinc-500"></div>
                            <div class="h-2.5 w-2.5 rounded-full bg-zinc-500"></div>
                            <div class="h-0 w-0 border-y-[5px] border-l-[6px] border-y-transparent border-l-zinc-500"></div>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[11px] font-bold text-zinc-400">TurningCode Admin Panel</p>
                        <p class="text-[10px] text-zinc-600 font-mono">v2.0.0 • Laravel {{ app()->version() }} • Built with 💻</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Chat overlay --}}
    <div id="chat-overlay" class="chat-hidden">
        <div id="chat-container">
            <div id="chat-header">
                <div id="chat-header-info">
                    <span id="chat-header-icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    </span>
                    <div>
                        <h3 class="capitalize">{{ explode('@', auth()->user()->email)[0] }}</h3>
                        <p id="chat-online-status">Global • Menghitung...</p>
                    </div>
                </div>
                <button id="chat-close" type="button" aria-label="Close chat">✕</button>
            </div>
            {{-- Online avatars bar --}}
            <div id="chat-online-admins" class="chat-online-admins" style="display:none;"></div>
            <div id="chat-messages">
                <div id="chat-loading">
                    <div class="chat-spinner"></div>
                    <p>Memuat pesan...</p>
                </div>
            </div>
            {{-- Reply preview bar --}}
            <div id="chat-reply-bar" style="display:none;">
                <div id="chat-reply-info">
                    <span id="chat-reply-icon" class="text-zinc-400 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                    </span>
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
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 2L11 13" />
                        <path d="M22 2L15 22L11 13L2 9L22 2Z" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    {{-- CMD overlay --}}
    <div id="cmd-overlay" class="cmd-hidden">
        <div class="rounded-2xl border border-zinc-700/50 shadow-[0_20px_50px_rgba(0,0,0,0.5)] overflow-hidden flex flex-col font-mono text-sm" style="height: 480px; background-color: #000;">
            <div class="border-b border-zinc-800 px-4 py-3 flex items-center justify-between" style="background-color: #0a0a0a;">
                <div class="flex items-center gap-2">
                    <span class="flex gap-1.5">
                        <span class="h-3 w-3 rounded-full bg-red-500/80"></span>
                        <span class="h-3 w-3 rounded-full bg-amber-500/80"></span>
                        <span class="h-3 w-3 rounded-full bg-emerald-500/80"></span>
                    </span>
                    <span class="ml-3 text-[11px] font-bold tracking-widest text-zinc-400 uppercase">System Terminal</span>
                </div>
                <div class="flex items-center gap-4">
                    <button type="button" id="btn-clear-cmd" class="text-[10px] text-zinc-500 hover:text-emerald-400 uppercase font-bold tracking-widest transition-colors">Clear</button>
                    <button type="button" id="cmd-close" class="text-[13px] text-zinc-500 hover:text-white transition-colors focus:outline-none">✕</button>
                </div>
            </div>
            
            <div id="cmd-output-wrapper" class="flex-1 p-4 overflow-y-auto text-zinc-300 space-y-1 scrollbar-thin scrollbar-thumb-zinc-800 scrollbar-track-transparent" style="background-color: #000;">
                <div class="text-emerald-400 mb-4 text-xs">
                    > TurningCode Secure Shell [Version 1.0.0]<br>
                    > Node authorized. Type your command below.
                </div>
                <div id="cmd-history"></div>
            </div>
            
            <form id="cmd-form" class="border-t border-zinc-800 flex items-center px-4 py-3 shrink-0" style="background-color: #050505;">
                <span class="text-emerald-500 font-bold mr-3 shrink-0">root@tc:~#</span>
                <input type="text" id="cmd-input" class="flex-1 bg-transparent border-0 outline-none focus:ring-0 text-zinc-200 placeholder:text-zinc-700 font-mono text-sm py-0 w-full" placeholder="e.g. php artisan optimize" autocomplete="off" spellcheck="false">
            </form>
        </div>
    </div>

    {{-- Report overlay --}}
    <div id="report-overlay" class="report-hidden">
        <div id="report-container">
            <div id="report-header" class="border-b border-zinc-200">
                <div id="report-header-info">
                    <span id="report-header-icon" class="bg-red-500 text-white">🚩</span>
                    <div>
                        <h3 class="capitalize">Lapor Masalah</h3>
                        <p class="text-[10px] text-zinc-500">Ada bug? Sampaikan ke dev.</p>
                    </div>
                </div>
                <button id="report-close" type="button" aria-label="Close report">✕</button>
            </div>
            
            <form id="report-form" class="p-5 overflow-y-auto space-y-4" autocomplete="off" enctype="multipart/form-data">
                <div>
                    <label class="block text-[10px] font-bold text-zinc-700 uppercase tracking-widest mb-1 pointer-events-none">Judul Laporan</label>
                    <input type="text" name="name" required class="w-full rounded-xl border border-zinc-200 px-3 py-2 text-sm focus:ring-1 focus:ring-red-500/50 focus:border-red-500 outline-none" placeholder="Contoh: CSS Terpotong di Data Topik">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-zinc-700 uppercase tracking-widest mb-1 pointer-events-none">Deskripsi</label>
                    <textarea name="description" rows="3" required class="w-full rounded-xl border border-zinc-200 px-3 py-2 text-sm focus:ring-1 focus:ring-red-500/50 focus:border-red-500 outline-none resize-none" placeholder="Jelaskan detail area dan langkah penemuannya..."></textarea>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-zinc-700 uppercase tracking-widest mb-1 pointer-events-none">Lampiran Gambar (Opsional)</label>
                    <div class="mt-1 flex items-center justify-center w-full">
                        <label for="report-image" class="relative flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-zinc-300 rounded-xl cursor-pointer bg-zinc-50 hover:bg-zinc-100 overflow-hidden">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6 z-10 transition-opacity" id="report-image-placeholder">
                                <svg class="w-6 h-6 mb-2 text-zinc-400" fill="none" viewBox="0 0 20 16"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/></svg>
                                <p class="mb-1 text-[11px] text-zinc-500"><span class="font-bold">Klik untuk upload</span></p>
                            </div>
                            <img id="report-image-preview" src="" class="absolute inset-0 w-full h-full object-cover hidden opacity-80" alt="Preview">
                            <input id="report-image" name="image" type="file" accept="image/*" class="hidden" />
                        </label>
                    </div>
                </div>

                <div id="report-status" class="hidden text-xs font-medium p-2 rounded-lg text-center"></div>

                <div class="pt-2">
                    <button type="submit" id="btn-submit-report" class="w-full rounded-xl bg-red-600 px-4 py-2.5 text-sm font-bold text-white transition-colors hover:bg-red-700 disabled:opacity-50">Kirim Laporan</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* Overlays Configuration */
        #chat-overlay, #cmd-overlay, #report-overlay, #settings-overlay {
            position: fixed;
            bottom: 24px;
            right: 96px; /* Space for the FAB menus */
            z-index: 9999;
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            transform-origin: bottom right;
        }

        #chat-overlay.chat-hidden, #cmd-overlay.cmd-hidden, #report-overlay.report-hidden, #settings-overlay.settings-hidden {
            opacity: 0;
            transform: scale(0.8) translateY(20px);
            pointer-events: none;
        }

        #chat-overlay.chat-visible, #cmd-overlay.cmd-visible, #report-overlay.report-visible, #settings-overlay.settings-visible {
            opacity: 1;
            transform: scale(1) translateY(0);
            pointer-events: auto;
        }

        /* Specific overlay widths */
        #cmd-overlay {
            width: 540px;
            max-width: calc(100vw - 120px);
        }

        #report-container {
            width: 360px;
            border-radius: 24px;
            background: #fff;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08), 0 4px 12px rgba(0, 0, 0, 0.04);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            border: 1px solid #f3f4f6;
        }
        #report-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            background: #ffffff;
            color: #1C1C1E;
        }
        #report-header-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        #report-header-icon {
            font-size: 20px;
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        #report-header h3 { margin: 0; font-size: 15px; font-weight: 800; }
        #report-close {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            border: none;
            background: #f4f4f5;
            color: #71717a;
            font-size: 15px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }
        #report-close:hover { background: #fee2e2; color: #ef4444; }

        /* ═══════════════════════════════════════════════════
               CHAT CONTAINER
            ═══════════════════════════════════════════════════ */
        #chat-container {
            width: 360px;
            height: 520px;
            border-radius: 24px;
            background: #fff;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08), 0 4px 12px rgba(0, 0, 0, 0.04);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            border: 1px solid #f3f4f6;
        }

        /* Header */
        #chat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            background: #ffffff;
            color: #1C1C1E;
            border-bottom: 1px solid #f3f4f6;
        }

        #chat-header-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        #chat-header-icon {
            font-size: 20px;
            width: 38px;
            height: 38px;
            background: #1C1C1E;
            color: #ffffff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        #chat-header h3 {
            margin: 0;
            font-size: 15px;
            font-weight: 800;
            /* Matching dashboard font weights */
            letter-spacing: -0.01em;
        }

        #chat-header p {
            margin: 2px 0 0;
            font-size: 11px;
            font-weight: 500;
            color: #a1a1aa;
            /* text-zinc-400 */
        }

        #chat-close {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            border: none;
            background: #f4f4f5;
            color: #71717a;
            font-size: 15px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        #chat-close:hover {
            background: #e4e4e7;
            color: #18181b;
        }

        /* Online Admins Horizontal List */
        .chat-online-admins {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 15px 20px;
            background: #fff;
            border-bottom: 1px solid #f3f4f6;
            overflow-x: auto;
            white-space: nowrap;
        }

        .chat-online-admins::-webkit-scrollbar {
            display: none;
        }

        .chat-online-avatar {
            position: relative;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #f4f4f5;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid #e4e4e7;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .chat-online-avatar img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        .chat-online-avatar::after {
            content: '';
            position: absolute;
            bottom: -1px;
            right: -1px;
            width: 8px;
            height: 8px;
            background: #22c55e;
            /* green dot */
            border: 2px solid #fff;
            border-radius: 50%;
        }

        /* Messages area */
        #chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 16px;
            min-height: 0;
            background: #F8F9FB;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        #chat-messages::-webkit-scrollbar {
            width: 5px;
        }

        #chat-messages::-webkit-scrollbar-thumb {
            background: #d4d4d8;
            border-radius: 4px;
        }

        /* Loading */
        #chat-loading {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 40px 0;
            color: #a1a1aa;
            font-size: 13px;
        }

        .chat-spinner {
            width: 28px;
            height: 28px;
            border: 3px solid #e4e4e7;
            border-top-color: #1C1C1E;
            border-radius: 50%;
            animation: chat-spin 0.8s linear infinite;
        }

        @keyframes chat-spin {
            to {
                transform: rotate(360deg);
            }
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
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .chat-msg.mine {
            align-self: flex-end;
        }

        .chat-msg.other {
            align-self: flex-start;
        }

        .chat-msg-name {
            font-size: 11px;
            font-weight: 700;
            margin-bottom: 4px;
            padding: 0 6px;
        }

        .chat-msg.mine .chat-msg-name {
            color: #18181b;
            text-align: right;
        }

        .chat-msg.other .chat-msg-name {
            color: #71717a;
        }

        .chat-msg-bubble {
            padding: 12px 14px;
            border-radius: 16px;
            font-size: 13px;
            line-height: 1.5;
            word-break: break-word;
            position: relative;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
        }

        .chat-msg.mine .chat-msg-bubble {
            background: #1C1C1E;
            color: #ffffff;
            border-bottom-right-radius: 4px;
        }

        .chat-msg.other .chat-msg-bubble {
            background: #ffffff;
            color: #3f3f46;
            border: 1px solid #e4e4e7;
            border-bottom-left-radius: 4px;
        }

        .chat-msg-bubble-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .chat-msg.mine .chat-msg-bubble-wrap {
            flex-direction: row-reverse;
        }

        .chat-msg.other .chat-msg-bubble-wrap {
            flex-direction: row;
        }

        .chat-msg-time-row {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 4px;
            padding: 0 6px;
        }

        .chat-msg.mine .chat-msg-time-row {
            justify-content: flex-end;
        }

        .chat-msg-time {
            font-size: 10px;
            color: #a1a1aa;
            font-weight: 500;
        }

        /* Reply button on hover */
        .chat-msg-reply-btn {
            width: 24px;
            height: 24px;
            border-radius: 8px;
            border: 1px solid #e4e4e7;
            background: #fff;
            color: #a1a1aa;
            font-size: 12px;
            cursor: pointer;
            display: flex;
            opacity: 0;
            pointer-events: none;
            align-items: center;
            justify-content: center;
            transition: all 0.15s;
            padding: 0;
            line-height: 1;
            flex-shrink: 0;
        }

        .chat-msg-bubble-wrap:hover .chat-msg-reply-btn {
            opacity: 1;
            pointer-events: auto;
        }

        .chat-msg-reply-btn:hover {
            background: #1C1C1E;
            color: #fff;
            border-color: #1C1C1E;
        }

        /* Reply quote inside bubble */
        .chat-reply-quote {
            padding: 8px 10px;
            border-radius: 8px;
            margin-bottom: 8px;
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
            background: rgba(255, 255, 255, 0.1);
            border-left-color: rgba(255, 255, 255, 0.4);
            color: rgba(255, 255, 255, 0.8);
        }

        .chat-msg.other .chat-reply-quote {
            background: #f4f4f5;
            border-left-color: #d4d4d8;
            color: #71717a;
        }

        .chat-reply-quote-name {
            font-weight: 700;
            font-size: 10px;
            display: block;
            margin-bottom: 3px;
            text-transform: uppercase;
            letter-spacing: 0.02em;
        }

        .chat-msg.mine .chat-reply-quote-name {
            color: rgba(255, 255, 255, 0.9);
        }

        .chat-msg.other .chat-reply-quote-name {
            color: #52525b;
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
            padding: 10px 16px;
            background: #fafafa;
            border-top: 1px solid #f3f4f6;
            animation: chat-reply-bar-in 0.2s ease-out;
        }

        @keyframes chat-reply-bar-in {
            from {
                opacity: 0;
                transform: translateY(6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #chat-reply-info {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
            flex: 1;
        }

        #chat-reply-icon {
            font-size: 16px;
            flex-shrink: 0;
            color: #d4d4d8;
            /* light arrow */
        }

        #chat-reply-content {
            min-width: 0;
            flex: 1;
        }

        #chat-reply-name {
            display: block;
            font-size: 10px;
            font-weight: 800;
            color: #52525b;
            text-transform: uppercase;
            letter-spacing: 0.02em;
        }

        #chat-reply-text {
            display: block;
            font-size: 12px;
            color: #a1a1aa;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            margin-top: 1px;
        }

        #chat-reply-cancel {
            width: 26px;
            height: 26px;
            border-radius: 8px;
            border: none;
            background: #f4f4f5;
            color: #71717a;
            font-size: 13px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all 0.2s;
        }

        #chat-reply-cancel:hover {
            background: #e4e4e7;
            color: #18181b;
        }

        /* Date separator */
        .chat-date-sep {
            text-align: center;
            font-size: 10px;
            font-weight: 600;
            color: #a1a1aa;
            padding: 12px 0 6px;
        }

        .chat-date-sep span {
            background: #ffffff;
            padding: 4px 14px;
            border-radius: 12px;
            border: 1px solid #e4e4e7;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.01);
        }

        /* Empty state */
        .chat-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 50px 20px;
            color: #a1a1aa;
            text-align: center;
        }

        .chat-empty-icon {
            font-size: 40px;
            margin-bottom: 16px;
            opacity: 0.6;
        }

        .chat-empty p {
            font-size: 13px;
            font-weight: 500;
            margin: 0;
        }

        /* Form */
        #chat-form {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 16px;
            border-top: 1px solid #f3f4f6;
            background: #fff;
        }

        #chat-input {
            flex: 1;
            padding: 12px 16px;
            border: 1px solid #e4e4e7;
            border-radius: 16px;
            font-size: 13px;
            outline: none;
            transition: all 0.2s;
            background: #f8f9fb;
        }

        #chat-input:focus {
            border-color: #1C1C1E;
            box-shadow: 0 0 0 3px rgba(28, 28, 30, 0.05);
            background: #fff;
        }

        #chat-send {
            width: 44px;
            height: 44px;
            border-radius: 16px;
            border: none;
            background: #1C1C1E;
            color: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        #chat-send:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
        }

        #chat-send:active {
            transform: scale(0.95);
        }

        #chat-send:disabled {
            opacity: 0.4;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
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

        /* Online Toast Notification */
        .admin-online-toast {
            position: fixed;
            bottom: 100px;
            right: 24px;
            background: #fff;
            border-radius: 12px;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1), 0 4px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid #f3f4f6;
            z-index: 10000;
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .admin-online-toast.show {
            transform: translateY(0);
            opacity: 1;
        }

        .admin-online-toast.hide {
            transform: translateY(20px);
            opacity: 0;
        }

        .admin-online-toast img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #e4e4e7;
        }

        .admin-online-toast-info {
            display: flex;
            flex-direction: column;
        }

        .admin-online-toast-info strong {
            font-size: 13px;
            color: #1c1c1e;
        }

        .admin-online-toast-info span {
            font-size: 11px;
            color: #10b981;
            font-weight: 600;
        }
    </style>

    <script>
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
                    settingDarkmode.checked = localStorage.getItem('setting_darkmode') === 'true';
                    settingDarkmode.addEventListener('change', () => {
                        localStorage.setItem('setting_darkmode', settingDarkmode.checked);
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
    </script>
    <script>
        // Global function for resolving Issue Reports directly from the Dashboard
        window.resolveIssueReport = async function(id, btn) {
            if (!confirm('Apakah masalah ini sudah diselesaikan?')) return;
            
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<span class="animate-pulse">...</span>';
            btn.disabled = true;

            try {
                const res = await fetch('{{ url("/admin/api/report") }}/' + id + '/resolve', {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                if (res.ok) {
                    // Update state visually immediately
                    const parent = btn.parentElement;
                    btn.remove();
                    
                    const resolvedBadge = document.createElement('span');
                    resolvedBadge.className = 'text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded min-w-[60px] text-center cursor-default';
                    resolvedBadge.innerText = 'RESOLVED';
                    
                    parent.prepend(resolvedBadge);
                    
                    // Force refresh notifications badge (if defined in the previous block)
                    if (typeof window.loadNotifications === 'function') {
                        window.loadNotifications();
                    } else {
                        // The loadNotifications function is local, so we just dispatch a custom event
                        window.dispatchEvent(new Event('refreshNotifications'));
                    }
                } else {
                    throw new Error('Gagal update status');
                }
            } catch (e) {
                alert(e.message);
                btn.innerHTML = originalHtml;
                btn.disabled = false;
            }
        };
    </script>

    {{-- Detail Profile Popup (Moved to top level strictly outside aside constraints) --}}
    <div id="detail-profile-popup" class="pointer-events-none fixed z-[100] w-[20em] rounded-[26px] border border-zinc-100 bg-white p-6 shadow-[0_20px_40px_-5px_rgba(0,0,0,0.15)] opacity-0 transition-all duration-300 ease-out translate-y-3 scale-95 origin-bottom-left">
        <div class="flex flex-col items-center text-center">
            <div class="relative mb-3 h-16 w-16 rounded-full p-1 bg-gradient-to-tr from-indigo-500 to-purple-500">
                <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=1C1C1E&color=ffffff' }}" 
                     alt="Profile" 
                     class="h-full w-full rounded-full object-cover border-[3px] border-white">
                <div class="absolute bottom-0 right-0 h-4 w-4 rounded-full border-2 border-white bg-emerald-500"></div>
            </div>
            <h3 class="text-[13px] font-[800] text-zinc-900 mb-0.5 w-full truncate tracking-tight">{{ auth()->user()->name }}</h3>
            <p class="text-[11px] font-medium text-zinc-500 mb-5 w-full truncate">{{ auth()->user()->email }}</p>
            
            <div class="w-full rounded-[14px] bg-zinc-50 border border-zinc-100 p-3 text-left mb-5">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[10px] uppercase font-bold text-zinc-400">Role</span>
                    <span class="text-[10px] font-bold text-indigo-600 bg-indigo-50 px-2.5 py-0.5 rounded-full capitalize">{{ auth()->user()->role ?? 'Admin' }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[10px] uppercase font-bold text-zinc-400">Status</span>
                    <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2.5 py-0.5 rounded-full flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Online</span>
                </div>
            </div>

            <a href="#" data-spa-page="profile" class="w-full inline-flex justify-center items-center gap-2 rounded-[14px] bg-[#1C1C1E] px-4 py-2.5 text-xs font-semibold text-white transition-colors hover:bg-zinc-800 shadow-md shadow-zinc-900/10">
                <span>Edit Profile</span>
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            </a>
        </div>
    </div>
@endsection