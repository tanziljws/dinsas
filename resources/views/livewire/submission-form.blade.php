<div class="max-w-3xl mx-auto py-8">
    <!-- Back Button -->
    <div class="md:hidden mb-6">
        <a href="{{ route('guru.dashboard') }}"
            class="inline-flex items-center text-sm text-gray-500 hover:text-brand-600">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Dashboard
        </a>
    </div>

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Formulir Pengajuan</h1>
        <p class="text-gray-500 mt-2">Silakan lengkapi seluruh data perjalanan dinas di bawah ini.</p>
    </div>

    <!-- Main Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <form wire:submit.prevent="submit" class="p-8 space-y-10">

            <!-- SECTION 1: Informasi Personil -->
            <div class="space-y-6">
                <div class="border-b border-gray-100 pb-3">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center">
                        <span
                            class="flex items-center justify-center w-8 h-8 rounded-full bg-brand-100 text-brand-600 text-sm font-bold mr-3">1</span>
                        Personil Pelaksana
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" value="{{ $guru->nama }}" readonly
                            class="w-full px-4 py-3 rounded-lg border-gray-200 bg-gray-100 text-gray-600 focus:ring-0 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">NIP / Nomor Identitas</label>
                        <input type="text" value="{{ $guru->nomor }}" readonly
                            class="w-full px-4 py-3 rounded-lg border-gray-200 bg-gray-100 text-gray-600 focus:ring-0 cursor-not-allowed">
                    </div>
                </div>

                <div class="pt-2">
                    <div class="space-y-4">
                        @foreach($pengikut as $index => $p)
                            <div class="flex gap-3 items-center">
                                <span
                                    class="flex-none flex items-center justify-center w-6 h-6 rounded-full bg-gray-100 text-gray-500 text-xs font-bold">{{ $index + 2 }}</span>
                                <div class="flex-1">
                                    <select wire:model="pengikut.{{ $index }}"
                                        class="w-full px-4 py-3 rounded-lg border-gray-200 bg-white border focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 transition-all text-sm">
                                        <option value="">-- Pilih Pegawai --</option>
                                        @foreach($gurus as $g)
                                            @if($g->id !== $guru->id)
                                                <option value="{{ $g->nama }}">{{ $g->nama }} - {{ $g->nomor }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <button type="button" wire:click="removePengikut({{ $index }})"
                                    class="p-3 text-red-500 hover:bg-red-50 rounded-lg transition-colors border border-transparent hover:border-red-100"
                                    title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    </div>

                    @if(count($pengikut) < 10)
                        <button type="button" wire:click="addPengikut"
                            class="mt-4 inline-flex items-center px-4 py-2 text-sm font-medium text-brand-600 bg-white border border-brand-200 rounded-lg hover:bg-brand-50 transition-colors shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Personil Pengikut
                        </button>
                    @endif
                </div>
            </div>

            <!-- SECTION 2: Detail Surat & Perjalanan -->
            <div class="space-y-6">
                <div class="border-b border-gray-100 pb-3">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center">
                        <span
                            class="flex items-center justify-center w-8 h-8 rounded-full bg-brand-100 text-brand-600 text-sm font-bold mr-3">2</span>
                        Detail Surat & Perjalanan
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Surat <span
                                class="text-red-500">*</span></label>
                        <input type="text" wire:model="nomor_surat"
                            class="w-full px-4 py-3 rounded-lg border-gray-200 bg-white border focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 transition-all placeholder-gray-400"
                            placeholder="Masukkan Nomor Surat Tugas">
                        @error('nomor_surat') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Surat <span
                                class="text-red-500">*</span></label>
                        <input type="date" wire:model="tanggal_surat"
                            class="w-full px-4 py-3 rounded-lg border-gray-200 bg-white border focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 transition-all">
                        @error('tanggal_surat') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Perjalanan Dinas <span
                                class="text-red-500">*</span></label>
                        <select wire:model="jenis"
                            class="w-full px-4 py-3 rounded-lg border-gray-200 bg-white border focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 transition-all">
                            <option value="">-- Pilih Jenis Perjalanan --</option>
                            <option value="Dalam Kota">Dalam Kota</option>
                            <option value="Luar Kota">Luar Kota</option>
                        </select>
                        @error('jenis') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Lama Perjalanan Dinas (Hari) <span
                                class="text-red-500">*</span></label>
                        <input type="number" wire:model.live="lama" min="1"
                            class="w-full px-4 py-3 rounded-lg border-gray-200 bg-white border focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 transition-all placeholder-gray-400"
                            placeholder="Contoh: 1">
                        @error('lama') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Berangkat <span
                                class="text-red-500">*</span></label>
                        <input type="date" wire:model.live="tanggal_berangkat"
                            class="w-full px-4 py-3 rounded-lg border-gray-200 bg-white border focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 transition-all">
                        @error('tanggal_berangkat') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Kembali <span
                                class="text-red-500">*</span></label>
                        <input type="date" wire:model="tanggal_kembali" @if((int) $lama === 1) readonly @endif
                            class="w-full px-4 py-3 rounded-lg border-gray-200 bg-white border focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 transition-all {{ (int) $lama === 1 ? 'bg-gray-50 cursor-not-allowed' : '' }}">
                        @error('tanggal_kembali') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- SECTION 3: Kegiatan & Instansi -->
            <div class="space-y-6">
                <div class="border-b border-gray-100 pb-3">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center">
                        <span
                            class="flex items-center justify-center w-8 h-8 rounded-full bg-brand-100 text-brand-600 text-sm font-bold mr-3">3</span>
                        Kegiatan & Instansi
                    </h2>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kegiatan <span
                            class="text-red-500">*</span></label>
                    <textarea wire:model="nama_kegiatan" rows="3"
                        class="w-full px-4 py-3 rounded-lg border-gray-200 bg-white border focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 transition-all placeholder-gray-400 leading-relaxed"
                        placeholder="Jelaskan nama kegiatan secara lengkap..."></textarea>
                    @error('nama_kegiatan') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Instansi Tujuan <span
                            class="text-red-500">*</span></label>
                    <input type="text" wire:model="nama_instansi"
                        class="w-full px-4 py-3 rounded-lg border-gray-200 bg-white border focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 transition-all placeholder-gray-400"
                        placeholder="Contoh: Dinas Pendidikan Provinsi Jawa Barat">
                    @error('nama_instansi') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Instansi <span
                            class="text-red-500">*</span></label>
                    <textarea wire:model="alamat_instansi" rows="2"
                        class="w-full px-4 py-3 rounded-lg border-gray-200 bg-white border focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 transition-all placeholder-gray-400"
                        placeholder="Alamat lengkap instansi..."></textarea>
                    @error('alamat_instansi') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- SECTION 4: Upload Dokumen -->
            <div class="space-y-6">
                <div class="border-b border-gray-100 pb-3">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center">
                        <span
                            class="flex items-center justify-center w-8 h-8 rounded-full bg-brand-100 text-brand-600 text-sm font-bold mr-3">4</span>
                        Upload Dokumen
                    </h2>
                </div>

                <div class="border-2 border-dashed border-gray-300 rounded-xl p-10 text-center transition-all hover:border-brand-400 hover:bg-gray-50 group relative"
                    x-data="{ isDragging: false }" x-on:dragover.prevent="isDragging = true"
                    x-on:dragleave.prevent="isDragging = false" x-on:drop.prevent="isDragging = false"
                    :class="{ 'border-brand-500 bg-brand-50': isDragging }">

                    <input type="file" wire:model="file" accept=".pdf"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" id="file-upload">

                    <div class="relative z-0">
                        @if($file)
                            <div
                                class="bg-brand-50 w-20 h-20 rounded-xl flex items-center justify-center mx-auto mb-4 text-brand-600">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="font-bold text-gray-900 text-lg">{{ $file->getClientOriginalName() }}</p>
                            <p class="text-sm text-gray-500 mt-1">{{ number_format($file->getSize() / 1024 / 1024, 2) }} MB
                            </p>
                            <p class="text-sm text-brand-600 font-medium mt-4 group-hover:underline">Klik atau drag untuk
                                mengganti</p>
                        @elseif($pengajuanId && !$file)
                            <div
                                class="bg-gray-100 w-20 h-20 rounded-xl flex items-center justify-center mx-auto mb-4 text-gray-500">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">File Tersimpan</h3>
                            <p class="text-gray-500 mt-2 max-w-sm mx-auto">Anda sudah mengunggah dokumen sebelumnya. Unggah
                                lagi hanya jika ingin menggantinya.</p>
                            <div class="mt-6">
                                <span
                                    class="px-5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 shadow-sm group-hover:border-gray-400 group-hover:text-gray-900 transition-colors">Ganti
                                    File</span>
                            </div>
                        @else
                            <div
                                class="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400 group-hover:scale-110 group-hover:text-gray-600 transition-all duration-300">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Upload File PDF</h3>
                            <p class="text-gray-500 mt-2 max-w-sm mx-auto">Pastikan file berisi Surat Tugas, SPPD, dan
                                Laporan Kegiatan dalam satu file.</p>
                            <div class="mt-6">
                                <span
                                    class="px-5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 shadow-sm group-hover:border-gray-400 group-hover:text-gray-900 transition-colors">Pilih
                                    File</span>
                            </div>
                        @endif
                    </div>
                </div>
                @error('file') <p class="text-red-500 text-sm text-center font-medium bg-red-50 py-2 rounded-lg">
                    {{ $message }}
                </p> @enderror
            </div>

            <!-- Submit Button -->
            <div class="pt-8 mt-8 border-t border-gray-100 pb-4">
                <button type="submit" wire:loading.attr="disabled"
                    class="w-full px-8 py-4 bg-brand-600 hover:bg-brand-700 text-white font-bold text-lg rounded-xl shadow-xl shadow-brand-500/20 transition-all hover:bg-brand-800 flex items-center justify-center disabled:opacity-75 disabled:cursor-not-allowed transform hover:-translate-y-1">
                    <span wire:loading.remove>Kirim Pengajuan</span>
                    <span wire:loading class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Mengirim Data...
                    </span>
                </button>
            </div>

        </form>
    </div>
</div>