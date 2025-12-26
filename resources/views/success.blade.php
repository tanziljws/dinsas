@extends('layouts.public-static')

@section('content')
    <div class="max-w-2xl mx-auto">
        <!-- Success Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-green-500 to-green-600 p-8 text-center">
                <div class="flex justify-center mb-4">
                    <div class="bg-white rounded-full p-4">
                        <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
                <h1 class="text-2xl font-bold text-white mb-2">Terima Kasih!</h1>
                <p class="text-green-100">Formulir Anda telah berhasil dikirim</p>
            </div>

            <!-- Content -->
            <div class="p-8 text-center">
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">Form Pelaporan Perjalanan Dinas</h2>
                    <p class="text-gray-600">
                        Data perjalanan dinas Anda telah tersimpan dan akan segera diproses oleh admin.
                    </p>
                </div>

                <div class="bg-blue-50 rounded-lg p-4 mb-6">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm text-blue-800 text-left">
                            Anda dapat memantau status pengajuan melalui admin atau menghubungi bagian terkait untuk
                            informasi lebih lanjut.
                        </p>
                    </div>
                </div>

                <div class="space-y-3">
                    <a href="{{ route('form.identity') }}"
                        class="inline-flex items-center justify-center w-full px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Kirim Laporan Lain
                    </a>

                    <a href="{{ route('form.identity') }}"
                        class="inline-flex items-center justify-center w-full px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6 text-sm text-gray-500">
            <p>Form Pelaporan Perjalanan Dinas - Tahun 2025</p>
        </div>
    </div>
@endsection