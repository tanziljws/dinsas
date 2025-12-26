<div class="max-w-5xl mx-auto py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Pengaturan Akun</h1>
        <p class="text-gray-500 mt-2">Kelola informasi akun dan keamanan Anda.</p>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 font-medium">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left: Password Change Form (2 cols) -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900">Ubah Password</h2>
                    <p class="text-sm text-gray-500 mt-1">Pastikan password baru aman dan mudah diingat.</p>
                </div>

                <form wire:submit.prevent="updatePassword" class="p-6 space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Password Lama</label>
                        <input type="password" wire:model="current_password"
                            class="w-full px-4 py-3 rounded-lg border-gray-200 bg-white border focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 transition-all"
                            placeholder="Masukkan password lama">
                        @error('current_password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Password Baru</label>
                        <input type="password" wire:model="new_password"
                            class="w-full px-4 py-3 rounded-lg border-gray-200 bg-white border focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 transition-all"
                            placeholder="Minimal 6 karakter">
                        @error('new_password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password Baru</label>
                        <input type="password" wire:model="new_password_confirmation"
                            class="w-full px-4 py-3 rounded-lg border-gray-200 bg-white border focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 transition-all"
                            placeholder="Ulangi password baru">
                    </div>

                    <div class="pt-4">
                        <button type="submit" wire:loading.attr="disabled"
                            class="w-full px-6 py-3 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-lg shadow-lg transition-all disabled:opacity-75 disabled:cursor-not-allowed">
                            <span wire:loading.remove>Simpan Password Baru</span>
                            <span wire:loading>Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right: Account Info Card (1 col) -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900">Informasi Akun</h2>
                </div>

                <div class="p-6 space-y-4">
                    <div class="flex items-center gap-4">
                        <div
                            class="h-14 w-14 rounded-full bg-brand-100 flex items-center justify-center text-brand-700 font-bold text-xl">
                            {{ substr(Auth::user()->name ?? 'G', 0, 1) }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ Auth::user()->name ?? 'Guru' }}</p>
                            <p class="text-sm text-gray-500">{{ Auth::user()->role ?? 'guru' }}</p>
                        </div>
                    </div>

                    <hr class="border-gray-100">

                    <div>
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">Email / Username</p>
                        <p class="text-sm text-gray-900 font-medium">{{ Auth::user()->email ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">Status Akun</p>
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Aktif
                        </span>
                    </div>

                    <div>
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">Bergabung Sejak</p>
                        <p class="text-sm text-gray-900">{{ Auth::user()->created_at?->format('d M Y') ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>