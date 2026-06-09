<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FreelanceHub - Kelola Proyek Freelance dengan Mudah</title>

    <!-- Vite untuk asset Laravel -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">


</head>

<body class="bg-white overflow-x-hidden">

    <!-- Loading Screen -->
    <div id="loadingScreen"
        class="fixed inset-0 bg-white z-[9999] flex flex-col items-center justify-center transition-all duration-500 opacity-0 pointer-events-none">
        <!-- Animated Logo Container -->
        <div class="relative mb-8">
            <!-- Logo Utama -->
            <div
                class="w-24 h-24 bg-blue-500 rounded-2xl flex items-center justify-center shadow-2xl shadow-blue-500/30 animate-pulse">
                <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
            </div>

            <!-- Ring Animation -->
            <div class="absolute inset-0 border-4 border-blue-500/30 border-t-blue-500 rounded-2xl animate-spin"></div>

            <!-- Floating Dots -->
            <div class="absolute -top-2 -right-2 w-6 h-6 bg-blue-500 rounded-full animate-pulse"></div>
            <div
                class="absolute -bottom-2 -left-2 w-4 h-4 bg-indigo-500 rounded-full animate-pulse animation-delay-300">
            </div>
        </div>

        <!-- Loading Text dengan Typing Effect -->
        <div class="text-center">
            <h3 class="text-2xl font-bold text-gray-800 mb-2">
                <span>JRCode</span>
                <span class="animate-pulse">.</span>
                <span class="animate-pulse animation-delay-150">.</span>
                <span class="animate-pulse animation-delay-300">.</span>
            </h3>
            <p class="text-gray-600 animate-pulse">Loading...</p>
        </div>

        <!-- Progress Bar -->
        <div class="w-64 h-2 bg-gray-200 rounded-full overflow-hidden mt-6">
            <div id="loadingProgress"
                class="h-full bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full w-0 transition-all duration-1000">
            </div>
        </div>
    </div>

    <!-- Overlay untuk mencegah interaksi -->
    <div id="loadingOverlay" class="fixed inset-0 bg-black/20 backdrop-blur-sm z-[9998] hidden"></div>

    <!-- NAVIGASI  -->
    <nav class="fixed w-full z-50" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-gray-800">Freelance App</span>
                </div>

                <!-- Menu Desktop -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home"
                        class="text-gray-700 hover:text-blue-500 transition-colors nav-item font-medium">Home</a>
                    <a href="#features"
                        class="text-gray-700 hover:text-blue-500 transition-colors nav-item font-medium">Fitur</a>
                </div>

                <!-- Tombol Autentikasi -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="bg-blue-500 text-white px-6 py-2.5 rounded-lg font-medium hover:bg-blue-700 transition-all shadow-lg hover:shadow-xl loading-button">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="bg-blue-500 text-white px-6 py-2.5 rounded-lg font-medium hover:bg-blue-700 transition-all shadow-lg hover:shadow-xl loading-button">
                            Mulai Sekarang
                        </a>
                    @endauth
                </div>

                <!-- Tombol Menu Mobile -->
                <button onclick="toggleMobileMenu()" class="md:hidden text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Menu Mobile -->
        <div id="mobileMenu" class="hidden md:hidden border-t border-gray-200/50">
            <div class="px-4 py-4 space-y-3 bg-white/95 backdrop-blur-sm">
                <a href="#home" class="block text-gray-700 hover:text-blue-500 py-2 nav-link font-medium">Home</a>
                <a href="#features" class="block text-gray-700 hover:text-blue-500 py-2 nav-link font-medium">Fitur</a>
                <div class="pt-4 space-y-2">
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="block text-center bg-blue-500 text-white px-6 py-2.5 rounded-lg font-medium hover:bg-blue-700 transition-all loading-button">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="block text-center bg-blue-500 text-white px-6 py-2.5 rounded-lg font-medium hover:bg-blue-700 transition-all loading-button">
                            Mulai Sekarang
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- BAGIAN HERO -->
    <section id="home" class="pt-32 pb-20 px-4 bg-blue-100">

        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Konten Kiri -->
                <div class="hero-content">
                    <h1 class="text-4xl md:text-6xl font-bold text-gray-900 leading-tight">
                        Pengelolaan <span class="text-transparent bg-clip-text bg-blue-500">Proyek
                        </span> dengan Mudah
                    </h1>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        Lacak proyek, kelola klien, pantau deadline, dan kembangkan bisnis freelance.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center justify-center bg-blue-500 text-white px-8 py-4 rounded-lg font-semibold hover:bg-blue-700 transition-all shadow-lg hover:shadow-xl transform hover:scale-105 loading-button">
                            Mulai Gratis Kok
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                        <a href="#demo"
                            class="inline-flex items-center justify-center border-2 border-gray-300 text-gray-700 px-8 py-4 rounded-lg font-semibold hover:border-blue-500 hover:text-blue-500 transition-all">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Tonton Demo
                        </a>
                    </div>
                </div>

                <!-- Konten Kanan - Gambar Hero -->
                <div class="relative">
                    <div class="relative z-10 bg-white rounded-2xl shadow-2xl p-4">
                        <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?w=800&h=600&fit=crop"
                            alt="Pratinjau Dashboard" class="rounded-lg w-full">
                    </div>
                    <!-- Elemen Dekoratif -->
                    <div
                        class="absolute -top-4 -right-4 w-72 h-72 bg-purple-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 ">
                    </div>
                    <div
                        class="absolute -bottom-8 -left-4 w-72 h-72 bg-blue-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 ">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- BAGIAN FITUR -->
    <section id="features" class="py-20 px-4 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16" data-animate="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-2">
                    Fitur Utama
                </h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Fitur dirancang khusus untuk freelancer.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Fitur 1 -->
                <div
                    class="feature-card hover-card bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-8 shadow-lg transition-shadow">
                    <div class="w-14 h-14 bg-blue-500 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Manajemen Proyek</h3>
                    <p class="text-gray-600">Atur semua proyek Anda di satu tempat dengan papan dan timeline yang
                        intuitif.</p>
                </div>

                <!-- Fitur 2 -->
                <div
                    class="feature-card hover-card bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-8 shadow-lg transition-shadow">
                    <div class="w-14 h-14 bg-purple-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Pelacakan Waktu</h3>
                    <p class="text-gray-600">Lacak jam yang dapat ditagih secara otomatis dan buat faktur yang akurat.
                    </p>
                </div>

                <!-- Fitur 3 -->
                <div
                    class="feature-card hover-card bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-8 shadow-lg transition-shadow">
                    <div class="w-14 h-14 bg-green-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Manajemen Klien</h3>
                    <p class="text-gray-600">Simpan semua informasi klien dan riwayat komunikasi di satu tempat yang
                        aman.</p>
                </div>

                <!-- Fitur 4 -->
                <div
                    class="feature-card hover-card bg-gradient-to-br from-orange-50 to-red-50 rounded-2xl p-8 shadow-lg transition-shadow">
                    <div class="w-14 h-14 bg-orange-600  rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Pelacakan Keuangan</h3>
                    <p class="text-gray-600">Pantau pendapatan, pengeluaran, dan buat faktur profesional dengan mudah.
                    </p>
                </div>

                <!-- Fitur 5 -->
                <div
                    class="feature-card hover-card bg-gradient-to-br from-cyan-50 to-blue-50 rounded-2xl p-8 shadow-lg transition-shadow">
                    <div class="w-14 h-14 bg-cyan-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Analitik & Laporan</h3>
                    <p class="text-gray-600">Dapatkan wawasan tentang kinerja bisnis dengan analitik terperinci.
                    </p>
                </div>

                <!-- Fitur 6 - Asisten AI -->
                <div
                    class="feature-card hover-card bg-gradient-to-br from-violet-50 to-purple-50 rounded-2xl p-8 transition-shadow border-2 border-purple-200">
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-14 h-14 bg-violet-600 rounded-xl flex items-center justify-center">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                        <span class="bg-purple-500 text-white text-xs font-bold px-3 py-1 rounded-full">Didukung
                            AI</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Asisten AI</h3>
                    <p class="text-gray-600">Dapatkan jawaban instan tentang proyek, tenggat waktu, dan metrik bisnis
                        dengan AI.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-white py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Freelance App. By Junior Programming</p>
            </div>
        </div>
    </footer>


    <!-- GSAP Library untuk animasi -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

    <script src="{{ asset('js/script.js') }}"></script>


</body>

</html>
