@extends('layouts.spa')

@section('content')
    {{-- @include('spa.fragments.user-navBar')
    @include('spa.fragments.user-asideBar')
    @include('spa.fragments.user-timeCard')
    @include('spa.fragments.user-materiCard')
    @include('spa.fragments.user-progres')
    @include('spa.fragments.user-navBottom') --}}

    <div class="flex min-h-screen">
        <aside class="w-56 shrink-0 border-r border-zinc-200 bg-white p-4">
            <p class="mb-4 text-xs font-semibold uppercase tracking-wide text-zinc-500">User</p>
            <nav class="flex flex-col gap-1 text-sm">
                <a href="#" data-spa-page="dashboard"
                    class="rounded-md px-3 py-2 text-zinc-700 hover:bg-zinc-100">Dashboard</a>
                <a href="#" data-spa-page="history"
                    class="rounded-md px-3 py-2 text-zinc-700 hover:bg-zinc-100">Riwayat</a>
                <a href="#" data-spa-page="account"
                    class="rounded-md px-3 py-2 text-zinc-700 hover:bg-zinc-100">Akun</a>
                <a href="#" data-spa-page="materi"
                    class="rounded-md px-3 py-2 text-zinc-700 hover:bg-zinc-100">Materi</a>
                <a href="#" data-spa-page="submateri" class="rounded-md px-3 py-2 text-zinc-700 hover:bg-zinc-100">Sub
                    materi</a>
                <a href="#" data-spa-page="detail"
                    class="rounded-md px-3 py-2 text-zinc-700 hover:bg-zinc-100">Detail</a>
            </nav>
            <form method="post" action="{{ route('logout') }}" class="mt-6">
                @csrf
                <button type="submit" class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm hover:bg-zinc-50">
                    Keluar
                </button>
            </form>
        </aside>
        <main class="flex-1 p-6">
            <div id="spa-content" class="min-h-[200px] rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
                <p class="text-sm text-zinc-500">Memuat…</p>
            </div>
        </main>
    </div>
@endsection
