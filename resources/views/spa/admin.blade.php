@extends('layouts.spa')

@section('content')
    <div class="flex min-h-screen bg-[var(--bg-primary)] text-[var(--text-primary)] transition-colors duration-300">
        {{-- ── ASIDE ── --}}
        <aside id="app-sidebar"
            class="fixed top-0 left-0 z-50 h-screen w-[260px] flex-col bg-white dark:bg-[#111113] p-6 pt-10 border-r border-zinc-100 dark:border-zinc-800 transition-all duration-300 flex overflow-y-auto overflow-x-hidden no-scrollbar">
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
            <header class="flex items-center justify-between px-8 lg:px-[60px] py-10 bg-[var(--bg-primary)] mt-2 shrink-0">
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
                        {{-- Online Admins Toggle --}}
                        <div class="relative group">
                            <button type="button" id="online-admins-toggle" class="flex h-11 w-11 items-center justify-center rounded-[16px] bg-white shadow-sm ring-1 ring-inset ring-zinc-200/50 transition-colors hover:bg-emerald-50 relative shrink-0">
                                <svg class="h-[18px] w-[18px] text-zinc-500 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span id="online-admins-badge" class="absolute -top-1 -right-1 min-w-[18px] h-[18px] px-[4px] rounded-full bg-emerald-500 text-white text-[9px] font-black flex items-center justify-center shadow-sm animate-pulse" style="display:none;">0</span>
                                <span class="absolute right-0 top-[calc(100%+8px)] bg-zinc-800 text-white text-[10px] uppercase font-bold tracking-widest px-2 py-1 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-[300]">Admin Online</span>
                            </button>

                            {{-- Online Admins Dropdown Panel --}}
                            <div id="online-admins-panel" class="absolute right-0 top-[calc(100%+8px)] w-[320px] max-h-[480px] rounded-2xl bg-white border border-zinc-200 shadow-[0_20px_40px_-8px_rgba(0,0,0,0.12)] z-[200] opacity-0 translate-y-2 pointer-events-none transition-all duration-300 flex flex-col overflow-hidden">
                                <div class="flex items-center justify-between px-5 py-4 border-b border-zinc-100 bg-zinc-50/50">
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-emerald-100/50 text-emerald-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                        </span>
                                        <div>
                                            <h3 class="text-sm font-extrabold text-zinc-900">Admin Staff</h3>
                                            <p class="text-[10px] text-zinc-500 font-medium">Status Kehadiran</p>
                                        </div>
                                    </div>
                                    <button type="button" id="online-admins-refresh" class="text-zinc-400 hover:text-emerald-500 transition-colors p-1" title="Refresh">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                    </button>
                                </div>
                                <div id="online-admins-list" class="flex-1 overflow-y-auto divide-y divide-zinc-50">
                                    <div class="flex flex-col items-center justify-center py-10 text-zinc-400">
                                        <svg class="w-5 h-5 animate-spin mb-3 text-emerald-500" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                        <span class="text-xs font-medium">Memuat...</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="notif-toggle"
                            class="flex h-11 w-11 items-center justify-center rounded-[16px] bg-white shadow-sm ring-1 ring-inset ring-zinc-200/50 transition-colors hover:bg-zinc-50 relative shrink-0 group">
                            <svg class="h-[18px] w-[18px] text-zinc-500 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"></path>
                            </svg>
                            <span id="notif-badge" class="absolute -top-1 -right-1 min-w-[18px] h-[18px] px-[4px] rounded-full bg-red-500 text-white text-[9px] font-black flex items-center justify-center shadow-sm animate-pulse" style="display:none;">0</span>
                            <span class="absolute right-0 top-[calc(100%+8px)] bg-zinc-800 text-white text-[10px] uppercase font-bold tracking-widest px-2 py-1 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-[300]">Notifikasi</span>
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



    {{-- ═══════════════════════════════════════════════════════
    SCROLL TO TOP BUTTON
    ═══════════════════════════════════════════════════════ --}}
    <button id="scroll-to-top-btn" type="button" aria-label="Scroll to Top" class="fixed bottom-6 right-24 z-[9990] w-12 h-12 rounded-full bg-white text-zinc-600 flex items-center justify-center shadow-[0_8px_20px_rgba(0,0,0,0.1)] transition-all duration-300 opacity-0 translate-y-4 pointer-events-none hover:scale-110 hover:text-indigo-600 border border-zinc-200">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"></path></svg>
    </button>

    {{-- ═══════════════════════════════════════════════════════
    ADMIN GLOBAL WIDGET (FAB)
    ═══════════════════════════════════════════════════════ --}}
    <div id="fab-container" class="fixed bottom-6 right-6 z-[9998] flex flex-col-reverse items-end gap-3">
        {{-- Main Toggle --}}
        <button id="fab-main-toggle" type="button" aria-label="Toggle Admin Tools" class="w-14 h-14 rounded-full bg-indigo-600 text-white flex items-center justify-center shadow-[0_10px_25px_rgba(79,70,229,0.5)] transition-all duration-300 hover:scale-105 active:scale-95 z-[9999] relative">
            <svg id="fab-icon-bars" class="w-6 h-6 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
            <svg id="fab-icon-close" class="w-6 h-6 absolute transition-transform duration-300 scale-0 rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
            <span id="chat-badge-main" class="absolute -top-1 -right-1 min-w-[20px] h-[20px] px-[5px] rounded-full bg-red-500 text-white text-[10px] font-black flex items-center justify-center shadow-sm animate-pulse" style="display:none;">0</span>
        </button>

        {{-- Sub Actions --}}
        <div id="fab-actions" class="flex flex-col-reverse items-end gap-3 transition-all duration-300 opacity-0 translate-y-4 pointer-events-none origin-bottom">
            {{-- Chat --}}
            <button id="chat-toggle" type="button" aria-label="Toggle admin chat" class="w-12 h-12 rounded-full border-none bg-white text-zinc-600 flex items-center justify-center shadow-[0_8px_20px_rgba(0,0,0,0.1)] transition-transform duration-300 hover:scale-110 hover:text-indigo-600 relative group">
                <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                <span id="chat-badge" style="display:none;" class="absolute -top-1 -right-1 min-w-[18px] h-[18px] px-[4px] rounded-full bg-red-500 text-white text-[9px] font-black flex items-center justify-center shadow-sm animate-pulse ring-2 ring-white">0</span>
                <span class="absolute right-[calc(100%+12px)] bg-zinc-800 text-white text-[10px] uppercase font-bold tracking-widest px-2 py-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap hidden md:block">Global Chat</span>
            </button>

            {{-- CMD --}}
            <button id="cmd-toggle" type="button" aria-label="Toggle System Terminal" class="w-12 h-12 rounded-full border-none bg-white text-zinc-600 flex items-center justify-center font-mono font-bold text-[15px] shadow-[0_8px_20px_rgba(0,0,0,0.1)] transition-transform duration-300 hover:scale-110 hover:text-emerald-500 relative group">
                >_
                <span class="absolute right-[calc(100%+12px)] bg-zinc-800 text-white text-[10px] uppercase font-bold tracking-widest px-2 py-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap hidden md:block">Terminal</span>
            </button>

            {{-- Report --}}
            <button id="report-toggle" type="button" aria-label="Report Issue" class="w-12 h-12 rounded-full border-none bg-white text-zinc-600 flex items-center justify-center text-[15px] grayscale opacity-80 shadow-[0_8px_20px_rgba(0,0,0,0.1)] transition-all duration-300 hover:scale-110 hover:grayscale-0 hover:opacity-100 relative group">
                🚩
                <span class="absolute right-[calc(100%+12px)] bg-zinc-800 text-white text-[10px] uppercase font-bold tracking-widest px-2 py-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap hidden md:block">Lapor Masalah</span>
            </button>

            {{-- Settings --}}
            <button id="settings-toggle" type="button" aria-label="Settings" class="w-12 h-12 rounded-full border-none bg-white text-zinc-600 flex items-center justify-center shadow-[0_8px_20px_rgba(0,0,0,0.1)] transition-transform duration-300 hover:scale-110 hover:text-zinc-900 relative group">
                <svg class="w-[20px] h-[20px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                <span class="absolute right-[calc(100%+12px)] bg-zinc-800 text-white text-[10px] uppercase font-bold tracking-widest px-2 py-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap hidden md:block">Pengaturan</span>
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
                    <div id="setting-lang-card" class="settings-card group relative overflow-hidden rounded-2xl p-5 transition-all duration-300 cursor-pointer hover:ring-1 hover:ring-zinc-600" style="background: #1a1a1e;">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex h-10 w-10 items-center justify-center rounded-2xl transition-colors" style="background: #242428;">
                                <svg class="h-5 w-5 text-zinc-400 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                            </div>
                            <span id="setting-lang-badge" class="inline-flex items-center rounded-lg px-2 py-0.5 text-[9px] font-black uppercase tracking-widest text-emerald-400" style="background: #242428;">ID</span>
                        </div>
                        <h4 id="setting-lang-title" class="text-sm font-bold text-white mb-1">Bahasa</h4>
                        <p id="setting-lang-desc" class="text-[11px] text-zinc-500 leading-relaxed">Bahasa antarmuka saat ini dalam Bahasa Indonesia.</p>
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
                    <div id="setting-perf-card" class="settings-card group relative overflow-hidden rounded-2xl p-5 transition-all duration-300 cursor-pointer hover:ring-1 hover:ring-zinc-600" style="background: #1a1a1e;">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex h-10 w-10 items-center justify-center rounded-2xl transition-colors" style="background: #242428;">
                                <svg class="h-5 w-5 text-zinc-400 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <span id="setting-perf-badge" class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest">Auto</span>
                        </div>
                        <h4 class="text-sm font-bold text-white mb-1">Performa</h4>
                        <p id="setting-perf-desc" class="text-[11px] text-zinc-500 leading-relaxed">Optimasi rendering SPA dan lazy-loading fragment otomatis.</p>
                    </div>

                    {{-- Compact Mode --}}
                    <div class="settings-card group relative overflow-hidden rounded-2xl p-5 transition-all duration-300 cursor-pointer hover:ring-1 hover:ring-zinc-600" style="background: #1a1a1e;">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex h-10 w-10 items-center justify-center rounded-2xl transition-colors" style="background: #242428;">
                                <svg class="h-5 w-5 text-zinc-400 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 8h16M4 16h16"></path></svg>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="setting-compact" class="sr-only peer">
                                <div class="w-9 h-5 bg-zinc-700 rounded-full peer peer-checked:bg-emerald-500 transition-colors after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-full"></div>
                            </label>
                        </div>
                        <h4 class="text-sm font-bold text-white mb-1">Tampilan Ringkas</h4>
                        <p class="text-[11px] text-zinc-500 leading-relaxed">Mengurangi jarak margin dan padding untuk memampatkan data tabel.</p>
                    </div>

                    {{-- Sound Effects --}}
                    <div class="settings-card group relative overflow-hidden rounded-2xl p-5 transition-all duration-300 cursor-pointer hover:ring-1 hover:ring-zinc-600" style="background: #1a1a1e;">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex h-10 w-10 items-center justify-center rounded-2xl transition-colors" style="background: #242428;">
                                <svg class="h-5 w-5 text-zinc-400 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.536 8.464a5 5 0 010 7.072M17.95 6.05a8 8 0 010 11.9m-11.3-9.9h-3a1 1 0 00-1 1v6a1 1 0 001 1h3l4 4V4l-4 4z"></path></svg>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="setting-sound" class="sr-only peer" checked>
                                <div class="w-9 h-5 bg-zinc-700 rounded-full peer peer-checked:bg-emerald-500 transition-colors after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-full"></div>
                            </label>
                        </div>
                        <h4 class="text-sm font-bold text-white mb-1">Efek Suara</h4>
                        <p class="text-[11px] text-zinc-500 leading-relaxed">Putar konfirmasi audio saat menyimpan data atau terjadi error.</p>
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
        /* ═══════════════════════════════════════════════════════
           ADMIN DARK MODE — Full Coverage
        ═══════════════════════════════════════════════════════ */

        /* ── Base transitions ── */
        .dark-mode *,
        .dark-mode *::before,
        .dark-mode *::after {
            transition: background-color 0.35s ease, border-color 0.35s ease, color 0.35s ease, box-shadow 0.35s ease;
        }

        /* ── Performance Modes ── */
        .perf-eco *, 
        .perf-eco *::before, 
        .perf-eco *::after {
            transition: none !important;
            animation: none !important;
        }

        /* ── Compact UI Mode ── */
        .ui-compact .spa-fragment {
            gap: 1rem !important;
        }
        .ui-compact .spa-fragment .p-4,
        .ui-compact .spa-fragment .p-5,
        .ui-compact .spa-fragment .p-6,
        .ui-compact .spa-fragment .p-8 {
            padding: 1rem !important;
        }
        .ui-compact .spa-fragment td, 
        .ui-compact .spa-fragment th {
            padding-top: 0.5rem !important;
            padding-bottom: 0.5rem !important;
        }
        .ui-compact .spa-fragment .py-6 {
            padding-top: 1rem !important;
            padding-bottom: 1rem !important;
        }

        /* ── Sidebar ── */
        .dark-mode #app-sidebar {
            background: #111113 !important;
            border-color: #1e1e22 !important;
        }
        .dark-mode #app-sidebar .nav-item {
            color: #71717a !important;
        }
        .dark-mode #app-sidebar .nav-item:hover:not(.active) {
            background: rgba(255,255,255,0.04) !important;
            color: #e4e4e7 !important;
        }
        .dark-mode #app-sidebar .nav-item.active {
            background: #6366f1 !important;
            color: #fff !important;
            box-shadow: 0 8px 24px -4px rgba(99,102,241,0.35) !important;
        }
        .dark-mode #app-sidebar .sidebar-text {
            color: inherit;
        }
        .dark-mode #app-sidebar form button {
            color: #71717a !important;
        }
        .dark-mode #app-sidebar form button:hover {
            background: rgba(239,68,68,0.08) !important;
            color: #f87171 !important;
        }
        .dark-mode #app-sidebar [class*="border-zinc-100"] {
            border-color: #27272a !important;
        }
        .dark-mode #detail-profile-trigger {
            background: #1a1a1e !important;
            border-color: #27272a !important;
        }
        .dark-mode #detail-profile-trigger:hover {
            background: #222226 !important;
            border-color: #3f3f46 !important;
        }
        .dark-mode #detail-profile-trigger h3 {
            color: #e4e4e7 !important;
        }
        .dark-mode #detail-profile-trigger p {
            color: #71717a !important;
        }
        .dark-mode #detail-profile-trigger .text-zinc-400 {
            color: #52525b !important;
        }
        .dark-mode #detail-profile-trigger .border-zinc-200 {
            border-color: #3f3f46 !important;
        }
        .dark-mode #detail-profile-trigger .border-white {
            border-color: #27272a !important;
        }

        /* Logo shapes */
        .dark-mode .sidebar-logo > div {
            background: #e4e4e7 !important;
        }
        .dark-mode .sidebar-logo > div:last-child {
            border-left-color: #e4e4e7 !important;
            background: transparent !important;
        }

        /* ── Header ── */
        .dark-mode #app-main > header {
            background: var(--bg-primary, #0D0C14) !important;
        }
        .dark-mode #sidebar-toggle {
            background: #1a1a1e !important;
            color: #a1a1aa !important;
            box-shadow: none !important;
            --tw-ring-color: rgba(63,63,70,0.5) !important;
        }
        .dark-mode #sidebar-toggle:hover {
            background: #27272a !important;
            color: #e4e4e7 !important;
        }
        .dark-mode #app-main > header h1 {
            color: #f4f4f5 !important;
        }
        .dark-mode #app-main > header p {
            color: #71717a !important;
        }

        /* Search */
        .dark-mode #app-main > header input[type="text"] {
            background: #1a1a1e !important;
            color: #e4e4e7 !important;
            border-color: #27272a !important;
        }
        .dark-mode #app-main > header input[type="text"]::placeholder {
            color: #52525b !important;
        }
        .dark-mode #app-main > header input[type="text"]:hover,
        .dark-mode #app-main > header input[type="text"]:focus {
            background: #222226 !important;
        }
        .dark-mode #app-main > header .text-zinc-500 {
            color: #52525b !important;
        }

        /* Notification bell */
        .dark-mode #notif-toggle {
            background: #1a1a1e !important;
            color: #a1a1aa !important;
            --tw-ring-color: rgba(63,63,70,0.5) !important;
        }
        .dark-mode #notif-toggle:hover {
            background: #27272a !important;
        }
        .dark-mode #notif-panel {
            background: #18181b !important;
            border-color: #27272a !important;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.6) !important;
        }
        .dark-mode #notif-panel [class*="border-zinc-100"],
        .dark-mode #notif-panel [class*="border-zinc-200"] {
            border-color: #27272a !important;
        }
        .dark-mode #notif-panel .text-zinc-900 {
            color: #f4f4f5 !important;
        }
        .dark-mode #notif-panel [class*="bg-zinc-50"] {
            background: #111113 !important;
        }
        .dark-mode .ring-zinc-200\/50 {
            --tw-ring-color: rgba(63,63,70,0.5) !important;
        }

        /* Avatar ring */
        .dark-mode #app-main > header .ring-zinc-200\/50 {
            --tw-ring-color: rgba(63,63,70,0.5) !important;
        }

        /* ── SPA Content Area ── */
        .dark-mode #spa-content .text-zinc-500 {
            color: #71717a !important;
        }

        /* ── Dashboard Stat Cards ── */
        .dark-mode .spa-fragment [class*="bg-white"] {
            background: #18181b !important;
        }
        .dark-mode .spa-fragment [class*="border-zinc-200"] {
            border-color: #27272a !important;
        }
        .dark-mode .spa-fragment [class*="border-zinc-100"] {
            border-color: #1e1e22 !important;
        }
        .dark-mode .spa-fragment .text-zinc-800,
        .dark-mode .spa-fragment h2.text-zinc-800 {
            color: #f4f4f5 !important;
        }
        .dark-mode .spa-fragment .text-zinc-700 {
            color: #d4d4d8 !important;
        }
        .dark-mode .spa-fragment .text-zinc-600 {
            color: #a1a1aa !important;
        }
        .dark-mode .spa-fragment .text-zinc-500 {
            color: #71717a !important;
        }
        .dark-mode .spa-fragment .text-zinc-400 {
            color: #52525b !important;
        }
        .dark-mode .spa-fragment .text-zinc-300 {
            color: #3f3f46 !important;
        }

        /* Card hover states */
        .dark-mode .spa-fragment [class*="hover\\:border-indigo"]:hover {
            border-color: rgba(99,102,241,0.4) !important;
        }
        .dark-mode .spa-fragment [class*="hover\\:border-violet"]:hover {
            border-color: rgba(139,92,246,0.4) !important;
        }
        .dark-mode .spa-fragment [class*="hover\\:border-emerald"]:hover {
            border-color: rgba(16,185,129,0.4) !important;
        }
        .dark-mode .spa-fragment [class*="hover\\:border-amber"]:hover {
            border-color: rgba(245,158,11,0.4) !important;
        }
        .dark-mode .spa-fragment [class*="hover\\:border-cyan"]:hover {
            border-color: rgba(6,182,212,0.4) !important;
        }
        .dark-mode .spa-fragment [class*="hover\\:border-rose"]:hover {
            border-color: rgba(244,63,94,0.4) !important;
        }
        .dark-mode .spa-fragment [class*="hover\\:border-sky"]:hover {
            border-color: rgba(14,165,233,0.4) !important;
        }
        .dark-mode .spa-fragment [class*="hover\\:border-pink"]:hover {
            border-color: rgba(236,72,153,0.4) !important;
        }

        /* Stat card accent circles (top-right decorative) */
        .dark-mode .spa-fragment [class*="bg-indigo-50"] {
            background: rgba(99,102,241,0.1) !important;
        }
        .dark-mode .spa-fragment [class*="bg-violet-50"] {
            background: rgba(139,92,246,0.1) !important;
        }
        .dark-mode .spa-fragment [class*="bg-emerald-50"] {
            background: rgba(16,185,129,0.1) !important;
        }
        .dark-mode .spa-fragment [class*="bg-amber-50"] {
            background: rgba(245,158,11,0.1) !important;
        }
        .dark-mode .spa-fragment [class*="bg-cyan-50"] {
            background: rgba(6,182,212,0.1) !important;
        }
        .dark-mode .spa-fragment [class*="bg-rose-50"] {
            background: rgba(244,63,94,0.1) !important;
        }
        .dark-mode .spa-fragment [class*="bg-sky-50"] {
            background: rgba(14,165,233,0.1) !important;
        }
        .dark-mode .spa-fragment [class*="bg-pink-50"] {
            background: rgba(236,72,153,0.1) !important;
        }

        /* Grid pattern backgrounds */
        .dark-mode .spa-fragment .bg-grid-pattern-box {
            background-image: linear-gradient(to right, rgba(255,255,255,0.03) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(255,255,255,0.03) 1px, transparent 1px) !important;
        }
        .dark-mode .spa-fragment .bg-grid-pattern {
            background-image: radial-gradient(circle, rgba(255,255,255,0.06) 1px, transparent 1px) !important;
        }

        /* ── data-dm-card: All card containers ── */
        [data-dm-card] {
            background: #ffffff;
        }
        .dark-mode [data-dm-card] {
            background: #18181b !important;
            border-color: #27272a !important;
        }

        /* ── data-dm-header: Section headers ── */
        [data-dm-header] {
            background: #fbfbfc;
        }
        .dark-mode [data-dm-header] {
            background: #111113 !important;
            border-color: #1e1e22 !important;
        }

        /* ── data-dm-panel: State Distribution panel ── */
        [data-dm-panel] {
            background: #fafafa;
        }
        .dark-mode [data-dm-panel] {
            background: #111113 !important;
            border-color: #27272a !important;
            box-shadow: inset 0 2px 10px -4px rgba(0,0,0,0.3) !important;
        }

        /* ── data-dm-grid: Grid overlay ── */
        [data-dm-grid] {
            background: linear-gradient(rgba(0,0,0,0.03) 1px, transparent 1px),
                        linear-gradient(90deg, rgba(0,0,0,0.03) 1px, transparent 1px);
            background-size: 16px 16px;
        }
        .dark-mode [data-dm-grid] {
            background: linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
                        linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px) !important;
            background-size: 16px 16px !important;
        }

        /* ── data-dm-label: State Distribution label ── */
        [data-dm-label] {
            background: rgba(255,255,255,0.8);
        }
        .dark-mode [data-dm-label] {
            background: rgba(24,24,27,0.8) !important;
            color: #71717a !important;
        }

        /* ── data-dm-gauge: Quiz circular gauge container ── */
        [data-dm-gauge] {
            background: #fbfbfc;
            box-shadow: inset 0 2px 10px -4px rgba(0,0,0,0.03);
        }
        .dark-mode [data-dm-gauge] {
            background: #111113 !important;
            border-color: #27272a !important;
            box-shadow: inset 0 2px 10px -4px rgba(0,0,0,0.3) !important;
        }

        /* ── data-dm-pill: Pass Rate label ── */
        [data-dm-pill] {
            background: #ffffff;
        }
        .dark-mode [data-dm-pill] {
            background: #1a1a1e !important;
            border-color: #27272a !important;
            color: #71717a !important;
        }

        /* ── Engagement Analytics Colors ── */
        .dark-mode [data-dm-glow-sky] {
            background-color: rgba(14, 165, 233, 0.05) !important;
        }
        .dark-mode [data-dm-icon-sky] {
            background-color: rgba(14, 165, 233, 0.1) !important;
            border-color: rgba(14, 165, 233, 0.2) !important;
        }
        .dark-mode [data-dm-glow-amber] {
            background-color: rgba(245, 158, 11, 0.05) !important;
        }
        .dark-mode [data-dm-icon-amber] {
            background-color: rgba(245, 158, 11, 0.1) !important;
            border-color: rgba(245, 158, 11, 0.2) !important;
        }
        .dark-mode [data-dm-glow-indigo] {
            background-color: rgba(99, 102, 241, 0.05) !important;
        }
        .dark-mode [data-dm-icon-indigo] {
            background-color: rgba(99, 102, 241, 0.1) !important;
            border-color: rgba(99, 102, 241, 0.2) !important;
        }

        /* ── Segmented bar tracks ── */
        .dark-mode .spa-fragment .h-2.w-full {
            background: rgba(63,63,70,0.3) !important;
        }
        .dark-mode .spa-fragment .h-2.w-full > div {
            border-color: rgba(39,39,42,0.5) !important;
        }

        /* ── Divider lines ── */
        .dark-mode .spa-fragment .w-px {
            background-color: #27272a !important;
        }
        .dark-mode .spa-fragment .border-dashed {
            border-color: #27272a !important;
        }

        /* ── List items ── */
        .dark-mode .spa-fragment li {
            border-color: #27272a !important;
        }
        .dark-mode .spa-fragment li:hover {
            background: rgba(255,255,255,0.03) !important;
        }
        .dark-mode .spa-fragment li .border-b,
        .dark-mode .spa-fragment li .border-dashed {
            border-color: #27272a !important;
        }

        /* Activity items left-border (keep status colors) */
        .dark-mode .spa-fragment li.border-l-2 {
            background: transparent !important;
        }
        .dark-mode .spa-fragment li.border-l-2:hover {
            background: rgba(255,255,255,0.03) !important;
        }

        /* ── Zinc utility backgrounds ── */
        .dark-mode .spa-fragment .bg-zinc-50 {
            background: #1e1e22 !important;
        }
        .dark-mode .spa-fragment .bg-zinc-100 {
            background: #222226 !important;
        }
        .dark-mode .spa-fragment .bg-zinc-200 {
            background: #3f3f46 !important;
        }
        .dark-mode .spa-fragment .ring-zinc-200\/50 {
            --tw-ring-color: rgba(63,63,70,0.5) !important;
        }
        .dark-mode .spa-fragment .ring-zinc-200 {
            --tw-ring-color: #3f3f46 !important;
        }

        /* Time badges in activity log */
        .dark-mode .spa-fragment span.bg-zinc-100 {
            background: #27272a !important;
            color: #a1a1aa !important;
        }

        /* ── Quiz gauge circle track ── */
        .dark-mode .spa-fragment svg circle[stroke="#f4f4f5"] {
            stroke: #27272a !important;
        }

        /* Quiz stats rows */
        .dark-mode .spa-fragment .rounded-xl.bg-emerald-50\/50,
        .dark-mode .spa-fragment .rounded-xl[class*="bg-emerald"] {
            background: rgba(16,185,129,0.08) !important;
            border-color: rgba(16,185,129,0.15) !important;
        }
        .dark-mode .spa-fragment .rounded-xl.bg-red-50\/50,
        .dark-mode .spa-fragment .rounded-xl[class*="bg-red"] {
            background: rgba(239,68,68,0.08) !important;
            border-color: rgba(239,68,68,0.15) !important;
        }
        .dark-mode .spa-fragment .rounded-xl.bg-zinc-50 {
            background: #1a1a1e !important;
            border-color: #27272a !important;
        }
        .dark-mode .spa-fragment .rounded-lg.bg-emerald-100 {
            background: rgba(16,185,129,0.15) !important;
        }
        .dark-mode .spa-fragment .rounded-lg.bg-red-100 {
            background: rgba(239,68,68,0.15) !important;
        }
        .dark-mode .spa-fragment .rounded-lg.bg-zinc-200 {
            background: #3f3f46 !important;
        }

        /* ── Bottom metric bar gradient ── */
        .dark-mode .spa-fragment .bg-gradient-to-r {
            background: linear-gradient(to right, rgba(17,17,19,0.5), rgba(24,24,27,0.8), rgba(17,17,19,0.5)) !important;
        }

        /* ── Accent -50 backgrounds ── */
        .dark-mode .spa-fragment .bg-indigo-50 {
            background: rgba(99,102,241,0.12) !important;
        }
        .dark-mode .spa-fragment .bg-violet-50 {
            background: rgba(139,92,246,0.12) !important;
        }
        .dark-mode .spa-fragment .bg-emerald-50 {
            background: rgba(16,185,129,0.12) !important;
        }
        .dark-mode .spa-fragment .bg-amber-50 {
            background: rgba(245,158,11,0.12) !important;
        }
        .dark-mode .spa-fragment .bg-cyan-50 {
            background: rgba(6,182,212,0.12) !important;
        }
        .dark-mode .spa-fragment .bg-rose-50 {
            background: rgba(244,63,94,0.12) !important;
        }
        .dark-mode .spa-fragment .bg-sky-50 {
            background: rgba(14,165,233,0.12) !important;
        }
        .dark-mode .spa-fragment .bg-pink-50 {
            background: rgba(236,72,153,0.12) !important;
        }
        .dark-mode .spa-fragment .bg-red-50 {
            background: rgba(239,68,68,0.1) !important;
        }

        /* ── Profile Popup ── */
        .dark-mode #detail-profile-popup {
            background: #18181b !important;
            border-color: #27272a !important;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5) !important;
        }
        .dark-mode #detail-profile-popup .text-zinc-900 {
            color: #f4f4f5 !important;
        }
        .dark-mode #detail-profile-popup .text-zinc-500 {
            color: #71717a !important;
        }
        .dark-mode #detail-profile-popup .text-zinc-400 {
            color: #52525b !important;
        }
        .dark-mode #detail-profile-popup .bg-zinc-50 {
            background: #111113 !important;
        }
        .dark-mode #detail-profile-popup [class*="border-zinc-100"] {
            border-color: #27272a !important;
        }
        .dark-mode #detail-profile-popup .border-white {
            border-color: #18181b !important;
        }
        .dark-mode #detail-profile-popup .border-2.border-white {
            border-color: #18181b !important;
        }

        /* ── Success alert ── */
        .dark-mode [class*="bg-emerald-50"][class*="border-emerald-100"] {
            background: rgba(16,185,129,0.08) !important;
            border-color: rgba(16,185,129,0.2) !important;
        }

        /* ── Scrollbar Dark ── */
        .dark-mode ::-webkit-scrollbar-thumb {
            background: #3f3f46 !important;
        }
        .dark-mode ::-webkit-scrollbar-track {
            background: transparent !important;
        }

        /* ── Admin Data Tables (Materi, Questions, etc.) ── */
        .dark-mode .spa-fragment table {
            border-color: #27272a !important;
        }
        .dark-mode .spa-fragment th {
            background: #111113 !important;
            color: #a1a1aa !important;
            border-color: #27272a !important;
        }
        .dark-mode .spa-fragment td {
            border-color: #1e1e22 !important;
            color: #d4d4d8 !important;
        }
        .dark-mode .spa-fragment tr:hover td {
            background: rgba(255,255,255,0.02) !important;
        }

        /* ── Form inputs in admin fragments ── */
        .dark-mode .spa-fragment input:not([type="checkbox"]):not([type="radio"]),
        .dark-mode .spa-fragment textarea,
        .dark-mode .spa-fragment select {
            background: #1a1a1e !important;
            color: #e4e4e7 !important;
            border-color: #3f3f46 !important;
        }
        .dark-mode .spa-fragment input:focus,
        .dark-mode .spa-fragment textarea:focus,
        .dark-mode .spa-fragment select:focus {
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 2px rgba(99,102,241,0.15) !important;
        }

        /* ── Buttons ── */
        .dark-mode .spa-fragment button[class*="bg-white"],
        .dark-mode .spa-fragment a[class*="bg-white"] {
            background: #1a1a1e !important;
            color: #d4d4d8 !important;
            border-color: #3f3f46 !important;
        }

        /* ═══════════════════════════════════════════════════════
           BOX SHADOWS — Dark Mode Overrides
        ═══════════════════════════════════════════════════════ */
        .dark-mode .spa-fragment .shadow-sm {
            box-shadow: 0 1px 3px rgba(0,0,0,0.3) !important;
        }
        .dark-mode .spa-fragment .shadow-md,
        .dark-mode .spa-fragment [class*="hover:shadow-md"]:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.4) !important;
        }
        .dark-mode .spa-fragment .shadow-lg {
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.5) !important;
        }
        .dark-mode .spa-fragment .shadow-inner {
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.3) !important;
        }
        /* Stat card hover shadows → dark, tinted with accent */
        .dark-mode .spa-fragment .group:hover {
            box-shadow: 0 8px 25px -5px rgba(0,0,0,0.4) !important;
        }
        /* Ring shadows in dark */
        .dark-mode .spa-fragment .ring-1 {
            --tw-ring-color: rgba(63,63,70,0.5) !important;
        }

        /* ═══════════════════════════════════════════════════════
           STRUKTUR DATABASE — Dark Mode
        ═══════════════════════════════════════════════════════ */

        /* Page title */
        .dark-mode #db-schema-root .text-zinc-900 {
            color: #f4f4f5 !important;
        }
        .dark-mode #db-schema-root .text-zinc-500 {
            color: #71717a !important;
        }
        .dark-mode #db-schema-root .text-zinc-400 {
            color: #52525b !important;
        }
        .dark-mode #db-schema-root .text-zinc-600 {
            color: #a1a1aa !important;
        }
        .dark-mode #db-schema-root .text-zinc-700 {
            color: #d4d4d8 !important;
        }
        .dark-mode #db-schema-root .text-zinc-300 {
            color: #52525b !important;
        }

        /* Search input */
        .dark-mode #db-search {
            background: #1a1a1e !important;
            border-color: #3f3f46 !important;
            color: #e4e4e7 !important;
        }
        .dark-mode #db-search:focus {
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 2px rgba(99,102,241,0.15) !important;
        }

        /* View toggle buttons */
        .dark-mode #db-schema-root .bg-zinc-100 {
            background: #1a1a1e !important;
        }
        .dark-mode #db-schema-root .db-view-btn {
            color: #52525b !important;
        }
        .dark-mode #db-schema-root .db-view-btn.active {
            background: #27272a !important;
            color: #e4e4e7 !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.3) !important;
        }

        /* Table cards */
        .dark-mode .db-table-card {
            background: #18181b !important;
            border-color: #27272a !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.3) !important;
        }
        .dark-mode .db-table-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.4) !important;
        }
        .dark-mode .db-table-card .bg-grid-pattern-box {
            background-image: linear-gradient(to right, rgba(255,255,255,0.02) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(255,255,255,0.02) 1px, transparent 1px) !important;
        }

        /* Accordion trigger hover and active states */
        [data-dm-trigger]:hover {
            background: rgba(250,250,250,0.8);
        }
        .dark-mode [data-dm-trigger]:hover {
            background: rgba(255,255,255,0.03) !important;
        }
        .dark-mode .db-accordion-trigger.bg-zinc-50 {
            background: #1e1e22 !important;
        }

        /* Table icon circle */
        .dark-mode .db-accordion-trigger .bg-zinc-100 {
            background: #222226 !important;
        }
        .dark-mode .db-accordion-trigger .text-zinc-500 {
            color: #71717a !important;
        }

        /* Accordion arrow */
        .dark-mode .db-list-arrow {
            color: #52525b !important;
        }

        /* Grid stats badges */
        .dark-mode .db-grid-stats .bg-zinc-100 {
            background: #27272a !important;
            color: #a1a1aa !important;
        }

        /* Accordion content dropdown (Grid mode inline style overrides) */
        .dark-mode .db-accordion-content {
            background: #18181b !important;
            border-color: #27272a !important;
            box-shadow: 0 12px 32px -4px rgba(0,0,0,0.6) !important;
        }

        /* Table inside accordion */
        .dark-mode .db-accordion-content table {
            color: #d4d4d8 !important;
        }
        .dark-mode .db-accordion-content thead {
            background: #111113 !important;
            color: #52525b !important;
            border-color: #27272a !important;
        }
        .dark-mode .db-accordion-content th {
            background: #111113 !important;
            color: #52525b !important;
        }
        .dark-mode .db-accordion-content tbody {
            border-color: #1e1e22 !important;
        }
        .dark-mode .db-accordion-content td {
            border-color: #1e1e22 !important;
            color: #d4d4d8 !important;
        }
        
        /* Table Row Hover */
        [data-dm-row]:hover {
            background-color: rgba(250,250,250,0.6);
        }
        .dark-mode [data-dm-row]:hover {
            background-color: rgba(255,255,255,0.02) !important;
        }
        
        .dark-mode .db-accordion-content .divide-y > * + * {
            border-color: #1e1e22 !important;
        }

        /* Column name bold text */
        .dark-mode .db-accordion-content .text-zinc-900 {
            color: #f4f4f5 !important;
        }

        /* Code/type badges */
        .dark-mode .db-accordion-content code {
            background: #222226 !important;
            color: #a1a1aa !important;
            --tw-ring-color: rgba(63,63,70,0.5) !important;
        }

        /* Attribute badges */
        .dark-mode .db-accordion-content .bg-amber-50 {
            background: rgba(245,158,11,0.1) !important;
            border-color: rgba(245,158,11,0.2) !important;
        }
        .dark-mode .db-accordion-content .bg-emerald-50 {
            background: rgba(16,185,129,0.1) !important;
            border-color: rgba(16,185,129,0.2) !important;
        }
        .dark-mode .db-accordion-content .bg-sky-50 {
            background: rgba(14,165,233,0.1) !important;
            border-color: rgba(14,165,233,0.2) !important;
        }
        .dark-mode .db-accordion-content .bg-indigo-50 {
            background: rgba(99,102,241,0.1) !important;
        }

        /* PK / FK relation badges */
        .dark-mode .db-accordion-content .ring-amber-200\/60 {
            --tw-ring-color: rgba(245,158,11,0.2) !important;
        }
        .dark-mode .db-accordion-content .ring-indigo-200\/60 {
            --tw-ring-color: rgba(99,102,241,0.2) !important;
        }
        .dark-mode .db-accordion-content .ring-zinc-200\/60 {
            --tw-ring-color: rgba(63,63,70,0.4) !important;
        }

        /* Foreign Keys Summary section */
        .dark-mode .db-accordion-content .bg-indigo-50\/40 {
            background: rgba(99,102,241,0.06) !important;
            border-color: rgba(99,102,241,0.15) !important;
        }
        .dark-mode .db-accordion-content .bg-indigo-50\/40 .bg-white {
            background: #1a1a1e !important;
            border-color: #3f3f46 !important;
        }

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
            const chatBadgeMain = document.getElementById('chat-badge-main');

            // Reply elements
            const replyBar = document.getElementById('chat-reply-bar');
            const replyName = document.getElementById('chat-reply-name');
            const replyText = document.getElementById('chat-reply-text');
            const replyCancel = document.getElementById('chat-reply-cancel');

            const API_URL = '{{ url("/admin/api/chat") }}';
            const CSRF = '{{ csrf_token() }}';
            const POLL_MS = 3000;

            let isOpen = false;
            let isFabOpen = false;
            let isCmdOpen = false;
            let isReportOpen = false;
            let isSettingsOpen = false;
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

            // ── Helper: close other overlays ────────────────
            function closeOtherOverlays(except) {
                if (except !== 'chat') {
                    isOpen = false;
                    const chatO = document.getElementById('chat-overlay');
                    if (chatO) { chatO.classList.remove('chat-visible'); chatO.classList.add('chat-hidden'); }
                    const ct = document.getElementById('chat-toggle');
                    if (ct) ct.classList.remove('chat-open');
                }
                if (except !== 'cmd') {
                    isCmdOpen = false;
                    const cmdO = document.getElementById('cmd-overlay');
                    if (cmdO) { cmdO.classList.remove('cmd-visible'); cmdO.classList.add('cmd-hidden'); }
                }
                if (except !== 'report') {
                    isReportOpen = false;
                    const repO = document.getElementById('report-overlay');
                    if (repO) { repO.classList.remove('report-visible'); repO.classList.add('report-hidden'); }
                }
                if (except !== 'settings') {
                    isSettingsOpen = false;
                    const setO = document.getElementById('settings-overlay');
                    if (setO) { setO.classList.remove('settings-visible'); setO.classList.add('settings-hidden'); }
                }
            }

            // ── Helper: collapse FAB menu visually ──────────
            function collapseFab() {
                const fa = document.getElementById('fab-actions');
                const ib = document.getElementById('fab-icon-bars');
                const ic = document.getElementById('fab-icon-close');
                if (fa) fa.classList.add('opacity-0', 'translate-y-4', 'pointer-events-none');
                if (ib) { ib.classList.remove('scale-0', '-rotate-90'); }
                if (ic) { ic.classList.add('scale-0', 'rotate-90'); }
                isFabOpen = false;
            }

            // ── Toggle chat ─────────────────────────────────
            chatToggle.addEventListener('click', () => {
                isOpen = !isOpen;
                if (isOpen) {
                    closeOtherOverlays('chat');
                    chatOverlay.classList.remove('chat-hidden');
                    chatOverlay.classList.add('chat-visible');
                    chatToggle.classList.add('chat-open');
                    chatBadge.style.display = 'none';
                    if (chatBadgeMain) chatBadgeMain.style.display = 'none';
                    unreadCount = 0;
                    updateBadge();
                    if (initialLoad) {
                        loadMessages();
                        initialLoad = false;
                    }
                    startPolling();
                    setTimeout(() => chatInput.focus(), 350);
                    if (isFabOpen) { collapseFab(); }
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


            if (cmdToggle && cmdOverlay) {
                cmdToggle.addEventListener('click', () => {
                    isCmdOpen = !isCmdOpen;
                    if (isCmdOpen) {
                        closeOtherOverlays('cmd');
                        cmdOverlay.classList.remove('cmd-hidden');
                        cmdOverlay.classList.add('cmd-visible');
                        setTimeout(() => document.getElementById('cmd-input').focus(), 350);
                        if (isFabOpen) { collapseFab(); }
                    } else {
                        cmdOverlay.classList.remove('cmd-visible');
                        cmdOverlay.classList.add('cmd-hidden');
                    }
                });

                cmdClose.addEventListener('click', () => {
                    isCmdOpen = false;
                    cmdOverlay.classList.remove('cmd-visible');
                    cmdOverlay.classList.add('cmd-hidden');
                });


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


            if (reportToggle && reportOverlay) {
                reportToggle.addEventListener('click', () => {
                    isReportOpen = !isReportOpen;
                    if (isReportOpen) {
                        closeOtherOverlays('report');
                        reportOverlay.classList.remove('report-hidden');
                        reportOverlay.classList.add('report-visible');
                        if (isFabOpen) { collapseFab(); }
                    } else {
                        reportOverlay.classList.remove('report-visible');
                        reportOverlay.classList.add('report-hidden');
                    }
                });

                reportClose.addEventListener('click', () => {
                    isReportOpen = false;
                    reportOverlay.classList.remove('report-visible');
                    reportOverlay.classList.add('report-hidden');
                });

            }

            // ── Settings Logic ─────────────────────────────────
            const settingsToggle = document.getElementById('settings-toggle');
            const settingsOverlay = document.getElementById('settings-overlay');
            const settingsClose = document.getElementById('settings-close');


            if (settingsToggle && settingsOverlay) {
                settingsToggle.addEventListener('click', () => {
                    isSettingsOpen = !isSettingsOpen;
                    if (isSettingsOpen) {
                        closeOtherOverlays('settings');
                        settingsOverlay.classList.remove('settings-hidden');
                        settingsOverlay.classList.add('settings-visible');
                        if (isFabOpen) { collapseFab(); }
                    } else {
                        settingsOverlay.classList.remove('settings-visible');
                        settingsOverlay.classList.add('settings-hidden');
                    }
                });

                settingsClose.addEventListener('click', () => {
                    isSettingsOpen = false;
                    settingsOverlay.classList.remove('settings-visible');
                    settingsOverlay.classList.add('settings-hidden');
                });


                // ── Scroll To Top Logic ─────────────────────────────────
                const scrollTopBtn = document.getElementById('scroll-to-top-btn');
                if (scrollTopBtn) {
                    window.addEventListener('scroll', () => {
                        if (window.scrollY > 300) {
                            scrollTopBtn.classList.remove('opacity-0', 'translate-y-4', 'pointer-events-none');
                            scrollTopBtn.classList.add('opacity-100', 'translate-y-0');
                        } else {
                            scrollTopBtn.classList.remove('opacity-100', 'translate-y-0');
                            scrollTopBtn.classList.add('opacity-0', 'translate-y-4', 'pointer-events-none');
                        }
                    });

                    scrollTopBtn.addEventListener('click', () => {
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    });
                }                // Clear cache button
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
                    if (isOnlineAdminsOpen) closeOnlineAdminsPanel();
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

            // ── Online Admins Logic ─────────────────────
            const onlineAdminsToggle = document.getElementById('online-admins-toggle');
            const onlineAdminsPanel = document.getElementById('online-admins-panel');
            const onlineAdminsBadge = document.getElementById('online-admins-badge');
            const onlineAdminsList = document.getElementById('online-admins-list');
            const onlineAdminsRefresh = document.getElementById('online-admins-refresh');
            let isOnlineAdminsOpen = false;
            let onlineAdminsLoaded = false;

            function openOnlineAdminsPanel() {
                onlineAdminsPanel.classList.remove('opacity-0', 'translate-y-2', 'pointer-events-none');
                onlineAdminsPanel.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto');
                isOnlineAdminsOpen = true;
                if (!onlineAdminsLoaded) {
                    loadOnlineAdmins();
                    onlineAdminsLoaded = true;
                }
            }

            function closeOnlineAdminsPanel() {
                onlineAdminsPanel.classList.add('opacity-0', 'translate-y-2', 'pointer-events-none');
                onlineAdminsPanel.classList.remove('opacity-100', 'translate-y-0', 'pointer-events-auto');
                isOnlineAdminsOpen = false;
            }

            if (onlineAdminsToggle && onlineAdminsPanel) {
                onlineAdminsToggle.addEventListener('click', (e) => {
                    e.stopPropagation();
                    isOnlineAdminsOpen ? closeOnlineAdminsPanel() : openOnlineAdminsPanel();
                    if (isNotifOpen) closeNotifPanel();
                });

                // Close on click outside
                document.addEventListener('click', (e) => {
                    if (isOnlineAdminsOpen && !onlineAdminsPanel.contains(e.target) && !onlineAdminsToggle.contains(e.target)) {
                        closeOnlineAdminsPanel();
                    }
                });

                if (onlineAdminsRefresh) {
                    onlineAdminsRefresh.addEventListener('click', (e) => {
                        e.stopPropagation();
                        // Add spin class temporarily
                        const icon = onlineAdminsRefresh.querySelector('svg');
                        icon.classList.add('animate-spin');
                        loadOnlineAdmins().finally(() => {
                            setTimeout(() => icon.classList.remove('animate-spin'), 500);
                        });
                    });
                }
            }

            async function loadOnlineAdmins() {
                try {
                    const res = await fetch('{{ route("admin.online-admins") }}', {
                        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                        credentials: 'same-origin',
                    });
                    if (!res.ok) throw new Error('Failed');
                    const admins = await res.json();
                    
                    const onlineCount = admins.filter(a => a.is_online).length;
                    
                    if (onlineCount > 0) {
                        onlineAdminsBadge.textContent = onlineCount;
                        onlineAdminsBadge.style.display = 'flex';
                    } else {
                        onlineAdminsBadge.style.display = 'none';
                    }

                    if (!admins || admins.length === 0) {
                        onlineAdminsList.innerHTML = `
                            <div class="flex flex-col items-center justify-center py-10 text-zinc-400">
                                <p class="text-xs font-medium">Tidak ada admin lain</p>
                            </div>
                        `;
                        return;
                    }

                    onlineAdminsList.innerHTML = admins.map(admin => {
                        const statusColor = admin.is_online ? 'bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]' : 'bg-zinc-300';
                        const statusText = admin.is_online 
                            ? 'Online di ' + (admin.last_page_display || 'Aplikasi')
                            : 'Terakhir di ' + (admin.last_page_display || 'Aplikasi') + ' (' + admin.last_seen_human + ')';
                        
                        const statusHtml = admin.is_online 
                            ? '<span class="text-emerald-600 font-bold">Online</span> di <span class="font-medium text-emerald-700">' + (admin.last_page_display || 'Aplikasi') + '</span>' 
                            : 'Terakhir di <span class="font-medium text-zinc-600">' + (admin.last_page_display || 'Aplikasi') + '</span> (' + admin.last_seen_human + ')';
                        
                        const safeAdmin = JSON.stringify({
                            name: admin.name,
                            email: admin.email,
                            avatar: admin.avatar_url,
                            statusText: statusText,
                            is_online: admin.is_online
                        }).replace(/"/g, '&quot;');

                        return `
                        <div onclick="showAdminPreview(${safeAdmin})" class="flex items-center gap-3 px-5 py-3.5 hover:bg-zinc-50/80 transition-colors cursor-pointer">
                            <div class="relative shrink-0">
                                <img src="${admin.avatar_url}" alt="${admin.name}" class="h-10 w-10 rounded-xl object-cover ring-1 ring-zinc-200 shadow-sm" loading="lazy">
                                <div class="absolute -bottom-1 -right-1 h-3.5 w-3.5 rounded-full border-2 border-white ${statusColor}"></div>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-[13px] font-bold text-zinc-800 truncate">${admin.name}</p>
                                <p class="text-[10px] text-zinc-400 truncate">${admin.email}</p>
                                <p class="text-[10px] mt-0.5 ${admin.is_online ? '' : 'text-zinc-500'}">${statusHtml}</p>
                            </div>
                        </div>
                        `;
                    }).join('');

                } catch (err) {
                    onlineAdminsList.innerHTML = `<div class="py-10 text-center text-xs text-red-500">Gagal memuat daftar admin.</div>`;
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

            // ── Restore FAB logic ───────────────────────────────────
            const fabMainToggle = document.getElementById('fab-main-toggle');
            const fabActions = document.getElementById('fab-actions');
            const fabIconBars = document.getElementById('fab-icon-bars');
            const fabIconClose = document.getElementById('fab-icon-close');

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

                    }
                });
            }

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
        window.showAdminPreview = function(admin) {
            const modal = document.getElementById('admin-preview-modal');
            const backdrop = document.getElementById('admin-preview-backdrop');
            const content = document.getElementById('admin-preview-content');
            
            document.getElementById('admin-preview-img').src = admin.avatar;
            document.getElementById('admin-preview-name').textContent = admin.name;
            document.getElementById('admin-preview-email').textContent = admin.email;
            document.getElementById('admin-preview-status').innerHTML = admin.statusText;
            
            const dot = document.getElementById('admin-preview-status-dot');
            if (admin.is_online) {
                dot.className = 'absolute bottom-1 right-1 h-5 w-5 rounded-full border-4 border-white bg-emerald-500 shadow-sm';
            } else {
                dot.className = 'absolute bottom-1 right-1 h-5 w-5 rounded-full border-4 border-white bg-zinc-300 shadow-sm';
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                backdrop.classList.add('pointer-events-auto');
                content.classList.remove('scale-95', 'opacity-0');
            }, 10);
        };

        window.closeAdminPreview = function() {
            const modal = document.getElementById('admin-preview-modal');
            const backdrop = document.getElementById('admin-preview-backdrop');
            const content = document.getElementById('admin-preview-content');
            
            backdrop.classList.add('opacity-0');
            backdrop.classList.remove('pointer-events-auto');
            content.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        };

        document.getElementById('admin-preview-backdrop')?.addEventListener('click', window.closeAdminPreview);
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

    {{-- Admin Preview Modal --}}
    <div id="admin-preview-modal" class="fixed inset-0 z-[500] hidden items-center justify-center pointer-events-none">
        <div id="admin-preview-backdrop" class="absolute inset-0 bg-zinc-900/40 backdrop-blur-sm opacity-0 transition-opacity duration-300 pointer-events-none"></div>
        
        <div id="admin-preview-content" class="relative z-10 w-full max-w-sm rounded-[24px] bg-white p-6 shadow-2xl scale-95 opacity-0 transition-all duration-300 pointer-events-auto">
            <button onclick="window.closeAdminPreview()" class="absolute top-4 right-4 h-8 w-8 rounded-full bg-zinc-100 flex items-center justify-center text-zinc-500 hover:bg-zinc-200 hover:text-zinc-700 transition-colors">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="flex flex-col items-center text-center mt-2">
                <div class="relative mb-4 h-24 w-24 rounded-full p-1 bg-gradient-to-tr from-emerald-400 to-teal-500">
                    <img id="admin-preview-img" src="" alt="Profile" class="h-full w-full rounded-full object-cover border-[3px] border-white backdrop-blur-md">
                    <div id="admin-preview-status-dot" class="absolute bottom-1 right-1 h-5 w-5 rounded-full border-4 border-white bg-emerald-500 shadow-sm"></div>
                </div>
                <h3 id="admin-preview-name" class="text-lg font-[800] text-zinc-900 mb-1 tracking-tight">Name</h3>
                <p id="admin-preview-email" class="text-xs font-medium text-zinc-500 mb-6">email</p>
                
                <div class="w-full rounded-[16px] bg-zinc-50 border border-zinc-100 p-4 text-left">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-[10px] uppercase font-bold text-zinc-400">Role</span>
                        <span class="text-[11px] font-bold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-md capitalize tracking-wide">Admin Staff</span>
                    </div>
                    <div class="flex flex-col gap-1.5 pt-3 border-t border-zinc-200/60">
                        <span class="text-[10px] uppercase font-bold text-zinc-400">Status Aktivitas</span>
                        <span id="admin-preview-status" class="text-xs font-medium text-zinc-700">Online di Dashboard</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══ Database Data Viewer Modal ═══ --}}
    <div id="db-data-modal" class="fixed inset-0 z-[600] hidden">
        <div id="db-data-backdrop" class="absolute inset-0 bg-zinc-900/50 backdrop-blur-sm opacity-0 transition-opacity duration-300"></div>
        <div id="db-data-content" class="absolute inset-4 md:inset-8 lg:inset-12 bg-white rounded-2xl shadow-2xl flex flex-col overflow-hidden scale-95 opacity-0 transition-all duration-300">
            <div class="flex items-center justify-between px-6 py-4 border-b border-zinc-100 bg-zinc-50/50 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-600">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375"/></svg>
                    </div>
                    <div>
                        <h3 id="db-data-title" class="text-base font-extrabold text-zinc-900 tracking-tight">Table</h3>
                        <p id="db-data-count" class="text-[11px] text-zinc-400 font-medium">0 records</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" id="db-data-refresh-btn" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-zinc-100 text-zinc-600 text-xs font-bold hover:bg-zinc-200 transition-colors">
                        <svg id="db-data-refresh-icon" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        Refresh
                    </button>
                    <button type="button" id="db-data-close-btn" class="h-9 w-9 rounded-lg bg-zinc-100 text-zinc-500 hover:bg-red-50 hover:text-red-500 flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>
            <div id="db-data-body" class="flex-1 overflow-auto px-1">
                <div class="flex items-center justify-center py-16 text-zinc-400">
                    <svg class="w-6 h-6 animate-spin mr-3 text-indigo-500" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                    <span class="text-sm font-medium">Memuat data...</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══ Database Edit Row Modal ═══ --}}
    <div id="db-edit-modal" class="fixed inset-0 z-[700] hidden items-center justify-center">
        <div id="db-edit-backdrop" class="absolute inset-0 bg-zinc-900/50 backdrop-blur-sm opacity-0 transition-opacity duration-300"></div>
        <div id="db-edit-content" class="relative z-10 w-full max-w-lg max-h-[80vh] bg-white rounded-2xl shadow-2xl flex flex-col overflow-hidden scale-95 opacity-0 transition-all duration-300">
            <div class="flex items-center justify-between px-6 py-4 border-b border-zinc-100 bg-zinc-50/50 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                    </div>
                    <div>
                        <h3 id="db-edit-title" class="text-sm font-extrabold text-zinc-900">Edit Row</h3>
                        <p id="db-edit-subtitle" class="text-[11px] text-zinc-400">ID: 0</p>
                    </div>
                </div>
                <button type="button" id="db-edit-close-btn" class="h-8 w-8 rounded-lg bg-zinc-100 text-zinc-500 hover:bg-red-50 hover:text-red-500 flex items-center justify-center transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div id="db-edit-form-container" class="flex-1 overflow-y-auto p-6 space-y-4"></div>
            <div class="flex items-center justify-end gap-2 px-6 py-4 border-t border-zinc-100 bg-zinc-50/30 shrink-0">
                <button type="button" id="db-edit-cancel-btn" class="px-4 py-2 rounded-xl text-xs font-bold text-zinc-600 bg-zinc-100 hover:bg-zinc-200 transition-colors">Batal</button>
                <button type="button" id="db-edit-save-btn" class="px-5 py-2 rounded-xl text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 transition-colors shadow-sm">Simpan</button>
            </div>
        </div>
    </div>

@endsection