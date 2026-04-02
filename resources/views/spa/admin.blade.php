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
@endsection
