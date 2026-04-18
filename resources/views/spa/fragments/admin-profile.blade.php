<div class="spa-fragment max-w-2xl mx-auto space-y-6" id="profile-app">
    <div>
        <h1 class="text-2xl font-bold text-zinc-900">Edit Profile</h1>
        <p class="mt-1 text-sm text-zinc-500">Perbarui informasi profil admin Anda, ganti avatar, atau ubah identitas username.</p>
    </div>

    @if(session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 flex items-center gap-3">
            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
            </span>
            <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
        </div>
    @endif

    <form method="post" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col sm:flex-row items-center gap-6 sm:gap-8">
                <div class="shrink-0 relative group">
                    <div class="h-24 w-24 rounded-full overflow-hidden border-4 border-white shadow-md bg-zinc-100 relative">
                        <img id="avatar-preview" 
                             src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=1C1C1E&color=ffffff' }}" 
                             alt="Avatar" class="h-full w-full object-cover">
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                            <span class="text-white text-xs font-semibold">Change</span>
                        </div>
                    </div>
                    <label for="avatar-upload" class="absolute bottom-0 right-0 h-8 w-8 bg-indigo-600 rounded-full border-2 border-white flex items-center justify-center text-white cursor-pointer hover:bg-indigo-700 transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </label>
                    <input type="file" id="avatar-upload" name="avatar" accept="image/*" class="hidden" onchange="previewAvatar(event)">
                </div>
                <div class="flex-1 space-y-1 text-center sm:text-left">
                    <h3 class="text-lg font-bold text-zinc-900">{{ $user->name }}</h3>
                    <p class="text-sm font-medium text-indigo-600 bg-indigo-50 inline-block px-2.5 py-0.5 rounded-full">{{ $user->role ?? 'Admin' }}</p>
                    <p class="text-[11px] text-zinc-400 mt-2">Maksimal ukuran gambar 2MB. Format: JPG, PNG, WEBP.</p>
                </div>
            </div>
            
            <hr class="my-6 border-zinc-100 border-dashed">
            
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-zinc-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full rounded-lg border-zinc-200 px-4 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors placeholder-zinc-400 @error('name') border-red-500 @enderror"
                           placeholder="Masukkan nama Anda">
                    @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
                
                @php
                    $emailParts = explode('@', old('email_name', $user->email));
                    $emailName = $emailParts[0] ?? '';
                @endphp
                <div>
                    <label class="block text-sm font-medium text-zinc-700 mb-1">Email Username</label>
                    <div class="flex items-center">
                        <input type="text" name="email_name" value="{{ $emailName }}" required pattern="^[a-zA-Z0-9_\-\.]+$"
                               class="w-full rounded-l-lg border-zinc-200 border-r-0 px-4 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors placeholder-zinc-400 bg-white z-10 @error('email_name') border-red-500 @enderror"
                               placeholder="username">
                        <span class="inline-flex items-center px-4 py-2.5 rounded-r-lg border border-zinc-200 border-l-0 bg-zinc-50 text-zinc-500 text-sm font-medium font-mono select-none">
                            @gmail.com
                        </span>
                    </div>
                    @error('email_name') 
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p> 
                    @else
                        <p class="mt-1.5 text-xs text-zinc-400">Email harus berupa suffix <strong>@gmail.com</strong>. Hanya gunakan huruf, angka, titik, strip (-), atau underscore (_).</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <button type="button" data-spa-page="dashboard" class="px-5 py-2.5 text-sm font-semibold text-zinc-600 bg-white border border-zinc-200 rounded-xl hover:bg-zinc-50 transition-colors outline-none focus:ring-2 focus:ring-zinc-200">
                Batal
            </button>
            <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-[#1C1C1E] rounded-xl hover:bg-zinc-800 transition-colors shadow-lg shadow-zinc-900/20 active:scale-95 outline-none focus:ring-2 focus:ring-zinc-900 focus:ring-offset-2">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
    function previewAvatar(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
