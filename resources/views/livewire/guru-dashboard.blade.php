<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="md:flex md:items-center md:justify-between mb-8">
        <div class="min-w-0 flex-1">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">Dashboard Pegawai</h2>
            <p class="mt-1 text-sm text-gray-500">Selamat datang kembali, {{ $guru?->nama ?? 'Pengguna' }}</p>
        </div>
        <div class="mt-4 flex md:ml-4 md:mt-0">
            <a href="{{ route('form.submit') }}" class="inline-flex items-center rounded-md bg-brand-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-brand-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-600">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z" clip-rule="evenodd" />
                </svg>
                Ajukan Perjalanan
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session()->has('error'))
        <div class="rounded-md bg-red-50 p-4 mb-6 border border-red-200">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(session()->has('success'))
        <div class="rounded-md bg-green-50 p-4 mb-6 border border-green-200">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Stats Grid -->
    <dl class="grid grid-cols-1 gap-5 sm:grid-cols-4 mb-8">
        <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6 border border-gray-200">
            <dt class="truncate text-sm font-medium text-gray-500">Menunggu Verifikasi</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ $history->where('status', 'Terkirim')->count() }}</dd>
        </div>
        <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6 border border-gray-200">
            <dt class="truncate text-sm font-medium text-gray-500">Sedang Diproses</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ $history->where('status', 'Diproses')->count() }}</dd>
        </div>
        <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6 border border-gray-200">
            <dt class="truncate text-sm font-medium text-gray-500">Ditolak</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ $history->where('status', 'Ditolak')->count() }}</dd>
        </div>
        <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6 border border-gray-200">
            <dt class="truncate text-sm font-medium text-gray-500">Selesai / Dibayar</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ $history->where('status', 'Sudah Dibayar')->count() }}</dd>
        </div>
    </dl>

    <!-- Recent Activity Table -->
    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
        <div class="border-b border-gray-200 px-4 py-5 sm:px-6">
            <h3 class="text-base font-semibold leading-6 text-gray-900">Riwayat Pengajuan</h3>
        </div>
        <div class="overflow-x-auto">
        @if($history->count() > 0)
            <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Tanggal</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">No. Surat</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Kegiatan</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Jenis</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Keterangan</th>
                        <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900 pr-6">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach($history as $item)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-500 sm:pl-6">{{ $item->created_at->format('d/m/Y') }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-900">{{ $item->nomor_surat }}</td>
                            <td class="px-3 py-4 text-sm text-gray-500">{{ Str::limit($item->nama_kegiatan, 50) }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $item->jenis }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm">
                                @php
                                    $badgeClass = match($item->status) {
                                        'Terkirim' => 'bg-yellow-50 text-yellow-700 ring-yellow-600/20',
                                        'Diproses' => 'bg-blue-50 text-blue-700 ring-blue-700/10',
                                        'Ditolak' => 'bg-red-50 text-red-700 ring-red-600/10',
                                        'Sudah Dibayar' => 'bg-green-50 text-green-700 ring-green-600/20',
                                        default => 'bg-gray-50 text-gray-600 ring-gray-500/10',
                                    };
                                @endphp
                                <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $badgeClass }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="px-3 py-4 text-sm text-gray-500">
                                @if($item->status === 'Ditolak' && $item->alasan_ditolak)
                                    <span class="text-red-600">{{ $item->alasan_ditolak }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                @if(in_array($item->status, ['Terkirim', 'Ditolak', 'Belum Dicek']))
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('form.submit', ['id' => $item->id]) }}" 
                                           class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-2 py-1 rounded transition-colors"
                                           title="Edit">
                                            Edit
                                        </a>
                                        <button wire:click="delete({{ $item->id }})" 
                                                wire:confirm="Yakin ingin menghapus pengajuan ini?"
                                                class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-2 py-1 rounded transition-colors"
                                                title="Hapus">
                                            Hapus
                                        </button>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="text-center py-10">
                <p class="text-gray-500">Belum ada riwayat pengajuan.</p>
            </div>
        @endif
        </div>
    </div>
</div>