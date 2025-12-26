<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pelaporan Perjalanan Dinas 2025 - SMKN 4 Bogor</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f0f6fc',
                            100: '#e1ecf8',
                            200: '#bfdaf2',
                            300: '#90c0ea',
                            400: '#5ca2e0',
                            500: '#3685d4',
                            600: '#00458e', /* SMKN 4 Custom Blue */
                            700: '#1d5b9e',
                            800: '#1a4b80',
                            900: '#194066',
                        },
                    },
                    backgroundImage: {
                        'hero-pattern': "url(\"data:image/svg+xml,%3Csvg width='20' height='20' viewBox='0 0 20 20' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'%3E%3Ccircle cx='3' cy='3' r='3'/%3E%3Ccircle cx='13' cy='13' r='3'/%3E%3C/g%3E%3C/svg%3E\")",
                    }
                },
            },
        }
    </script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            background-color: #f3f4f6;
        }

        /* Hero Image/Gradient */
        .hero-section {
            background-color: #00458e;
            background-image: radial-gradient(circle at 10% 20%, rgb(0, 69, 142) 0%, rgb(0, 45, 95) 90%);
            position: relative;
            overflow: hidden;
        }

        .hero-pattern {
            background-image: radial-gradient(#ffffff 1px, transparent 1px);
            background-size: 24px 24px;
            opacity: 0.1;
        }

        /* Glass effect for navbar if needed */
        .glass-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        /* Form input enhancements */
        .form-input {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-input:focus {
            box-shadow: 0 0 0 4px rgba(0, 69, 142, 0.1);
            border-color: #00458e;
            transform: translateY(-1px);
        }
    </style>

    @livewireStyles
</head>

<body class="font-sans antialiased text-gray-800">

    <!-- Navbar -->
    <nav class="glass-nav fixed w-full z-50 top-0 left-0 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center gap-3">
                    <!-- Logo Placeholder/Image -->
                    <img class="h-12 w-auto" src="{{ asset('images/logo-smkn4.jpeg') }}" alt="SMKN 4 Bogor Logo">
                    <div>
                        <h1 class="text-xl font-bold text-gray-900 leading-none tracking-tight">SMK NEGERI 4 BOGOR</h1>
                        <p class="text-xs text-brand-600 font-medium tracking-wide mt-0.5">FORM PERJALANAN DINAS</p>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#"
                        class="text-gray-500 hover:text-brand-600 font-medium transition-colors text-sm">Beranda</a>
                    <a href="https://smkn4bogor.sch.id" target="_blank"
                        class="text-gray-500 hover:text-brand-600 font-medium transition-colors text-sm">Website
                        Resmi</a>
                    <a href="/admin"
                        class="px-5 py-2.5 rounded-full bg-brand-600 text-white text-sm font-medium hover:bg-brand-700 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        Admin Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Wrapper -->
    <div class="pt-20 min-h-screen flex flex-col">
        <!-- Decoration Background (Top Half) -->
        <div class="hero-section absolute top-0 left-0 w-full h-[400px] z-0">
            <div class="absolute inset-0 hero-pattern"></div>
            <!-- Abstract Shapes -->
            <div class="absolute -bottom-16 -left-16 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl"></div>
            <div class="absolute top-10 right-10 w-96 h-96 bg-brand-400 opacity-10 rounded-full blur-3xl"></div>
        </div>

        <!-- Content -->
        <div class="relative z-10 flex-grow py-12 px-4 sm:px-6 lg:px-8">
            {{ $slot }}
        </div>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-100 mt-auto py-8 relative z-10">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <p class="text-gray-500 text-sm">© {{ date('Y') }} SMK Negeri 4 Bogor. All rights reserved.</p>
                <p class="text-gray-400 text-xs mt-2">Pusat Informasi Digital SMKN 4 Bogor</p>
            </div>
        </footer>
    </div>

    @livewireScripts
</body>

</html>