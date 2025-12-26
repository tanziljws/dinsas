<div class="max-w-md mx-auto z-20 relative">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100/50">
        <!-- Header -->
        <div class="bg-brand-600 p-8 text-center relative overflow-hidden">
            <div class="absolute inset-0 hero-pattern opacity-10"></div>
            <h2 class="text-2xl md:text-3xl font-bold text-white mb-2 relative z-10">Login Pegawai</h2>
            <p class="text-brand-100 text-sm relative z-10">
                Masuk menggunakan NIP untuk mengakses dashboard
            </p>
        </div>

        <div class="p-8">
            <form wire:submit.prevent="login" class="space-y-6">
                <!-- Error Message -->
                @if($error)
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-red-700 text-sm font-medium">{{ $error }}</p>
                        </div>
                    </div>
                @endif

                <!-- NIP Field -->
                <div>
                    <label for="nip" class="block text-sm font-semibold text-gray-700 mb-2 uppercase tracking-wide">
                        NIP <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nip" wire:model="nip" placeholder="Masukkan NIP Anda"
                        class="form-input w-full px-4 py-3.5 text-base border-gray-200 bg-gray-50 rounded-xl focus:bg-white text-gray-800 placeholder-gray-400"
                        autofocus>
                    @error('nip')
                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password"
                        class="block text-sm font-semibold text-gray-700 mb-2 uppercase tracking-wide">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" id="password" wire:model="password" placeholder="Masukkan password"
                        class="form-input w-full px-4 py-3.5 text-base border-gray-200 bg-gray-50 rounded-xl focus:bg-white text-gray-800 placeholder-gray-400">
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500">
                        *Password default adalah NIP Anda
                    </p>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit"
                        class="w-full py-4 px-6 bg-brand-600 hover:bg-brand-700 text-white font-semibold text-lg rounded-xl shadow-lg shadow-brand-600/30 transition-all duration-300 transform hover:-translate-y-1 focus:outline-none focus:ring-4 focus:ring-brand-200 disabled:opacity-70 disabled:cursor-not-allowed disabled:transform-none"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove>Masuk</span>
                        <span wire:loading class="flex items-center justify-center gap-2">
                            <svg class="animate-spin h-5 w-5 text-white" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"
                                    fill="none"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Memverifikasi...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>