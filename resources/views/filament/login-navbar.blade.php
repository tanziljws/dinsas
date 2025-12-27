<div class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo / Brand -->
            <div class="flex-shrink-0 flex items-center">
                <a href="/" class="flex items-center gap-3">
                    <img src="{{ asset('images/logo-smkn4.jpeg') }}" class="h-8 w-auto" alt="SMKN 4 Bogor">
                    <div class="flex flex-col">
                        <span class="font-bold text-gray-900 leading-none">Si-Saling</span>
                        <span class="text-xs text-gray-500 leading-none mt-1">Sistem Surat & Perjalanan Dinas</span>
                    </div>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('login') }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-brand-600 bg-brand-50 hover:bg-brand-100 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    Login Guru
                </a>
            </div>
        </div>
    </div>
</div>
<div class="h-16"></div> <!-- Spacer -->