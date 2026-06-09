<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FreelanceHub - Kelola Proyek Freelance Anda dengan Mudah</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes pulse-glow {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -200px 0;
            }

            100% {
                background-position: 200px 0;
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }

        .gradient-text {
            background: linear-gradient(90deg, #3b82f6, #8b5cf6, #ec4899);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 3s infinite linear;
        }

        /* Animasi cursor untuk hero */
        .typing-cursor {
            display: inline-block;
            width: 3px;
            background-color: #3b82f6;
            animation: blink 1s infinite;
            margin-left: 2px;
        }

        @keyframes blink {

            0%,
            50% {
                opacity: 1;
            }

            51%,
            100% {
                opacity: 0;
            }
        }

        /* Loading screen */
        .loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.8s ease-out, visibility 0.8s ease-out;
        }

        .loading-logo {
            width: 100px;
            height: 100px;
            position: relative;
        }

        .loading-spinner {
            width: 80px;
            height: 80px;
            border: 5px solid rgba(255, 255, 255, 0.2);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Hover effects */
        .feature-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            transform-origin: center;
        }

        .feature-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        /* Navbar animation */
        .nav-item {
            position: relative;
        }

        .nav-item::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background-color: #3b82f6;
            transition: width 0.3s ease;
        }

        .nav-item:hover::after {
            width: 100%;
        }

        /* Floating elements */
        .floating-element {
            position: absolute;
            z-index: -1;
            opacity: 0.1;
        }
    </style>
</head>

<body class="bg-white overflow-x-hidden">

    <!-- Loading Screen -->
    <div class="loading-screen" id="loadingScreen">
        <div class="loading-logo">
            <div class="w-20 h-20 bg-white rounded-xl flex items-center justify-center mx-auto mb-4 animate-pulse-glow">
                <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
            </div>
            <div class="loading-spinner"></div>
        </div>
    </div>

    <!-- NAVIGASI -->
    <nav class="fixed w-full bg-white/95 backdrop-blur-sm shadow-sm z-50 transform -translate-y-full transition-transform duration-500"
        id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center opacity-0" id="logo">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-gray-800">FreelanceHub</span>
                </div>

                <!-- Menu Desktop -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features"
                        class="nav-item text-gray-600 hover:text-blue-600 transition-colors opacity-0">Fitur</a>
                    <a href="#benefits"
                        class="nav-item text-gray-600 hover:text-blue-600 transition-colors opacity-0">Manfaat</a>
                    <a href="#pricing"
                        class="nav-item text-gray-600 hover:text-blue-600 transition-colors opacity-0">Harga</a>
                    <a href="#testimonials"
                        class="nav-item text-gray-600 hover:text-blue-600 transition-colors opacity-0">Testimoni</a>
                </div>

                <!-- Tombol Autentikasi -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('login') }}"
                        class="text-gray-600 hover:text-blue-600 font-medium transition-colors opacity-0">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" id="registerBtn"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg font-medium hover:from-blue-700 hover:to-indigo-700 transition-all shadow-lg hover:shadow-xl transform hover:scale-105 opacity-0">
                        Mulai Sekarang
                    </a>
                </div>

                <!-- Tombol Menu Mobile -->
                <button onclick="toggleMobileMenu()" class="md:hidden text-gray-600 opacity-0" id="mobileMenuBtn">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Menu Mobile -->
        <div id="mobileMenu" class="hidden md:hidden border-t">
            <div class="px-4 py-4 space-y-3">
                <a href="#features"
                    class="block text-gray-600 hover:text-blue-600 py-2 transform translate-x-10 opacity-0 transition-all duration-300">Fitur</a>
                <a href="#benefits"
                    class="block text-gray-600 hover:text-blue-600 py-2 transform translate-x-10 opacity-0 transition-all duration-300 delay-75">Manfaat</a>
                <a href="#pricing"
                    class="block text-gray-600 hover:text-blue-600 py-2 transform translate-x-10 opacity-0 transition-all duration-300 delay-100">Harga</a>
                <a href="#testimonials"
                    class="block text-gray-600 hover:text-blue-600 py-2 transform translate-x-10 opacity-0 transition-all duration-300 delay-150">Testimoni</a>
                <div class="pt-4 space-y-2">
                    <a href="{{ route('login') }}"
                        class="block text-center text-gray-600 border border-gray-300 px-6 py-2 rounded-lg font-medium transform translate-x-10 opacity-0 transition-all duration-300 delay-200">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                        class="block text-center bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-2 rounded-lg font-medium transform translate-x-10 opacity-0 transition-all duration-300 delay-250">
                        Mulai Sekarang
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- BAGIAN HERO -->
    <section
        class="pt-32 pb-20 px-4 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 overflow-hidden relative">
        <!-- Floating elements -->
        <div class="floating-element w-64 h-64 bg-blue-200 rounded-full -top-20 -left-20 animate-float"></div>
        <div
            class="floating-element w-40 h-40 bg-purple-200 rounded-full top-1/4 right-10 animate-float animation-delay-2000">
        </div>
        <div
            class="floating-element w-32 h-32 bg-indigo-200 rounded-full bottom-20 left-1/4 animate-float animation-delay-4000">
        </div>

        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Konten Kiri -->
                <div>
                    <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                        Kelola <span class="gradient-text">Proyek Freelance</span> Anda dengan Mudah
                        <span class="typing-cursor"></span>
                    </h1>
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed opacity-0" id="heroText">
                        Lacak proyek, kelola klien, pantau tenggat waktu, dan kembangkan bisnis freelance Anda dengan
                        platform all-in-one kami yang didukung AI.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('register') }}" id="heroCta"
                            class="inline-flex items-center justify-center bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-8 py-4 rounded-lg font-semibold hover:from-blue-700 hover:to-indigo-700 transition-all shadow-lg hover:shadow-xl transform opacity-0">
                            Mulai Gratis Kok
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                        <a href="#demo" id="demoBtn"
                            class="inline-flex items-center justify-center border-2 border-gray-300 text-gray-700 px-8 py-4 rounded-lg font-semibold hover:border-blue-600 hover:text-blue-600 transition-all opacity-0">
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
                <div class="relative opacity-0" id="heroImage">
                    <div
                        class="relative z-10 bg-white rounded-2xl shadow-2xl p-4 transform hover:scale-105 transition-transform duration-500">
                        <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?w=800&h=600&fit=crop"
                            alt="Pratinjau Dashboard" class="rounded-lg w-full">
                    </div>
                    <!-- Elemen Dekoratif -->
                    <div
                        class="absolute -top-4 -right-4 w-72 h-72 bg-purple-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob">
                    </div>
                    <div
                        class="absolute -bottom-8 -left-4 w-72 h-72 bg-blue-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- BAGIAN FITUR -->
    <section id="features" class="py-20 px-4 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 opacity-0" id="featuresTitle">
                    Semua yang Anda Butuhkan untuk <span class="gradient-text">Sukses</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto opacity-0" id="featuresSubtitle">
                    Fitur canggih yang dirancang khusus untuk freelancer untuk menyederhanakan alur kerja
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Fitur 1 -->
                <div class="feature-card bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-8 hover:shadow-xl transition-all opacity-0"
                    data-feature="1">
                    <div class="w-14 h-14 bg-blue-600 rounded-xl flex items-center justify-center mb-6">
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
                <div class="feature-card bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-8 hover:shadow-xl transition-all opacity-0"
                    data-feature="2">
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
                <div class="feature-card bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-8 hover:shadow-xl transition-all opacity-0"
                    data-feature="3">
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
                <div class="feature-card bg-gradient-to-br from-orange-50 to-red-50 rounded-2xl p-8 hover:shadow-xl transition-all opacity-0"
                    data-feature="4">
                    <div class="w-14 h-14 bg-orange-600 rounded-xl flex items-center justify-center mb-6">
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
                <div class="feature-card bg-gradient-to-br from-cyan-50 to-blue-50 rounded-2xl p-8 hover:shadow-xl transition-all opacity-0"
                    data-feature="5">
                    <div class="w-14 h-14 bg-cyan-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Analitik & Laporan</h3>
                    <p class="text-gray-600">Dapatkan wawasan tentang kinerja bisnis Anda dengan analitik terperinci.
                    </p>
                </div>

                <!-- Fitur 6 - Asisten AI -->
                <div class="feature-card bg-gradient-to-br from-violet-50 to-purple-50 rounded-2xl p-8 hover:shadow-xl transition-all border-2 border-purple-200 opacity-0"
                    data-feature="6">
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-14 h-14 bg-violet-600 rounded-xl flex items-center justify-center">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                        <span
                            class="bg-gradient-to-r from-purple-500 to-pink-500 text-white text-xs font-bold px-3 py-1 rounded-full animate-pulse-glow">Didukung
                            AI</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Asisten AI</h3>
                    <p class="text-gray-600">Dapatkan jawaban instan tentang proyek, tenggat waktu, dan metrik bisnis
                        Anda dengan AI.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- BAGIAN MANFAAT -->
    <section id="benefits" class="py-20 px-4 bg-gradient-to-br from-blue-50 to-indigo-50 overflow-hidden relative">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 opacity-0" id="benefitsTitle">
                        Mengapa Freelancer <span class="gradient-text">Menyukai Kami</span>
                    </h2>
                    <div class="space-y-6">
                        <div class="flex items-start gap-4 opacity-0" data-benefit="1">
                            <div
                                class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Hemat 10+ Jam Per Minggu</h3>
                                <p class="text-gray-600">Otomatiskan tugas berulang dan fokus pada yang penting -
                                    pekerjaan Anda yang sebenarnya.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 opacity-0" data-benefit="2">
                            <div
                                class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Tingkatkan Produktivitas sebesar 40%
                                </h3>
                                <p class="text-gray-600">Alur kerja yang disederhanakan membantu Anda menyelesaikan
                                    lebih banyak proyek dengan lebih cepat.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 opacity-0" data-benefit="3">
                            <div
                                class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Tingkatkan Pendapatan sebesar 25%</h3>
                                <p class="text-gray-600">Organisasi yang lebih baik berarti lebih banyak proyek dan
                                    pendapatan yang lebih tinggi.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative opacity-0" id="benefitsImage">
                    <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=600&h=400&fit=crop"
                        alt="Analitik" class="rounded-2xl shadow-2xl w-full">
                </div>
            </div>
        </div>
    </section>

    <!-- BAGIAN TESTIMONI -->
    <section id="testimonials" class="py-20 px-4 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 opacity-0" id="testimonialsTitle">
                    Apa Kata <span class="gradient-text">Pengguna Kami</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto opacity-0" id="testimonialsSubtitle">
                    Bergabunglah dengan ribuan freelancer yang telah mengubah alur kerja mereka
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Testimoni 1 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 opacity-0"
                    data-testimonial="1">
                    <div class="flex items-center mb-6">
                        <img src="https://i.pravatar.cc/60?img=5" class="w-12 h-12 rounded-full mr-4"
                            alt="Sarah Chen">
                        <div>
                            <h4 class="font-bold text-gray-900">Sarah Chen</h4>
                            <p class="text-gray-600">Desainer UI/UX</p>
                        </div>
                    </div>
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">
                        "FreelanceHub telah mengubah cara saya mengelola proyek. Asisten AI-nya sendiri menghemat saya
                        berjam-jam setiap minggu!"
                    </p>
                </div>

                <!-- Testimoni 2 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 opacity-0"
                    data-testimonial="2">
                    <div class="flex items-center mb-6">
                        <img src="https://i.pravatar.cc/60?img=6" class="w-12 h-12 rounded-full mr-4"
                            alt="Marcus Johnson">
                        <div>
                            <h4 class="font-bold text-gray-900">Marcus Johnson</h4>
                            <p class="text-gray-600">Pengembang Web</p>
                        </div>
                    </div>
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">
                        "Fitur pelacakan waktu adalah pengubah permainan. Penagihan saya sekarang akurat dan
                        profesional. Sangat direkomendasikan!"
                    </p>
                </div>

                <!-- Testimoni 3 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 opacity-0"
                    data-testimonial="3">
                    <div class="flex items-center mb-6">
                        <img src="https://i.pravatar.cc/60?img=7" class="w-12 h-12 rounded-full mr-4"
                            alt="Elena Rodriguez">
                        <div>
                            <h4 class="font-bold text-gray-900">Elena Rodriguez</h4>
                            <p class="text-gray-600">Pembuat Konten</p>
                        </div>
                    </div>
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">
                        "Manajemen klien tidak pernah semudah ini. Semua komunikasi dan file dalam satu tempat. Itu
                        tepat yang saya butuhkan!"
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- BAGIAN AJAKAN -->
    <section class="py-20 px-4 bg-gradient-to-br from-blue-600 to-indigo-600 overflow-hidden relative">
        <!-- Animated background elements -->
        <div class="floating-element w-96 h-96 bg-white/10 rounded-full -top-40 -right-40 animate-float"></div>
        <div
            class="floating-element w-64 h-64 bg-white/5 rounded-full bottom-20 -left-20 animate-float animation-delay-2000">
        </div>

        <div class="max-w-4xl mx-auto text-center relative z-10">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6 opacity-0" id="ctaTitle">
                Siap Mengubah Bisnis Freelance Anda?
            </h2>
            <p class="text-xl text-blue-100 mb-8 opacity-0" id="ctaText">
                Bergabunglah dengan 10.000+ freelancer yang sudah bekerja lebih cerdas dengan FreelanceHub
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" id="ctaBtn"
                    class="inline-flex items-center justify-center bg-white text-blue-600 px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition-all shadow-lg hover:shadow-xl transform hover:scale-105 opacity-0">
                    Mulai Uji Coba Gratis
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
                <a href="#demo" id="ctaDemoBtn"
                    class="inline-flex items-center justify-center border-2 border-white text-white px-8 py-4 rounded-lg font-semibold hover:bg-white/10 transition-all opacity-0">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Tonton Demo
                </a>
            </div>
            <p class="mt-8 text-blue-200 text-sm opacity-0" id="ctaNote">
                Tidak diperlukan kartu kredit • Uji coba gratis 14 hari • Batalkan kapan saja
            </p>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-white py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="opacity-0" id="footerLogo">
                    <div class="flex items-center mb-6">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold">FreelanceHub</span>
                    </div>
                    <p class="text-gray-400 mb-6">
                        Kelola proyek freelance Anda dengan mudah dengan platform all-in-one kami.
                    </p>
                </div>

                <div class="opacity-0" id="footerProduct">
                    <h3 class="font-bold text-lg mb-6">Produk</h3>
                    <ul class="space-y-3">
                        <li><a href="#features" class="text-gray-400 hover:text-white transition-colors">Fitur</a>
                        </li>
                        <li><a href="#pricing" class="text-gray-400 hover:text-white transition-colors">Harga</a></li>
                        <li><a href="#testimonials"
                                class="text-gray-400 hover:text-white transition-colors">Testimoni</a></li>
                        <li><a href="#demo" class="text-gray-400 hover:text-white transition-colors">Demo</a></li>
                    </ul>
                </div>

                <div class="opacity-0" id="footerCompany">
                    <h3 class="font-bold text-lg mb-6">Perusahaan</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Tentang
                                Kami</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Blog</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Karir</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Kontak</a></li>
                    </ul>
                </div>

                <div class="opacity-0" id="footerLegal">
                    <h3 class="font-bold text-lg mb-6">Legal</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Kebijakan
                                Privasi</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Syarat
                                Layanan</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Kebijakan
                                Cookie</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">GDPR</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-400 opacity-0" id="footerCopyright">
                <p>&copy; <span id="currentYear"></span> FreelanceHub. By Junior Programming</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/ScrollTrigger.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/ScrollToPlugin.min.js"></script>

    <script>
        // Set current year in footer
        document.getElementById('currentYear').textContent = new Date().getFullYear();

        // Initialize GSAP
        gsap.registerPlugin(ScrollTrigger);

        // Loading animation
        window.addEventListener('load', function() {
            // Hide loading screen
            gsap.to('#loadingScreen', {
                opacity: 0,
                duration: 0.8,
                onComplete: function() {
                    document.getElementById('loadingScreen').style.display = 'none';

                    // Animate navbar in
                    gsap.to('#navbar', {
                        y: 0,
                        duration: 0.8,
                        ease: "power3.out"
                    });

                    // Animate logo
                    gsap.to('#logo', {
                        opacity: 1,
                        duration: 0.8,
                        delay: 0.2
                    });

                    // Animate nav items
                    gsap.to('.nav-item', {
                        opacity: 1,
                        duration: 0.6,
                        stagger: 0.1,
                        delay: 0.3
                    });

                    // Animate buttons
                    gsap.to('#registerBtn, #mobileMenuBtn', {
                        opacity: 1,
                        duration: 0.8,
                        delay: 0.5
                    });

                    // Hero section animations
                    gsap.to('#heroText', {
                        opacity: 1,
                        duration: 1,
                        delay: 0.6,
                        ease: "power2.out"
                    });

                    gsap.to('#heroCta', {
                        opacity: 1,
                        y: 0,
                        duration: 0.8,
                        delay: 0.8,
                        ease: "back.out(1.7)"
                    });

                    gsap.to('#demoBtn', {
                        opacity: 1,
                        y: 0,
                        duration: 0.8,
                        delay: 0.9,
                        ease: "back.out(1.7)"
                    });

                    gsap.to('#heroImage', {
                        opacity: 1,
                        x: 0,
                        duration: 1,
                        delay: 0.7,
                        ease: "power3.out"
                    });
                }
            });
        });

        // Typing effect for hero title
        const heroTitle = document.querySelector('h1');
        const originalText = heroTitle.innerHTML;
        const cursor = document.querySelector('.typing-cursor');

        // Remove cursor after animation
        setTimeout(() => {
            cursor.style.display = 'none';
        }, 3000);

        // Scroll animations for sections
        // Features section
        gsap.utils.toArray('[data-feature]').forEach((feature, i) => {
            gsap.to(feature, {
                opacity: 1,
                y: 0,
                duration: 0.8,
                scrollTrigger: {
                    trigger: feature,
                    start: "top 80%",
                    toggleActions: "play none none none"
                },
                delay: i * 0.1
            });
        });

        // Features title
        gsap.to('#featuresTitle', {
            opacity: 1,
            y: 0,
            duration: 1,
            scrollTrigger: {
                trigger: '#features',
                start: "top 70%",
                toggleActions: "play none none none"
            }
        });

        gsap.to('#featuresSubtitle', {
            opacity: 1,
            y: 0,
            duration: 1,
            delay: 0.2,
            scrollTrigger: {
                trigger: '#features',
                start: "top 70%",
                toggleActions: "play none none none"
            }
        });

        // Benefits section
        gsap.to('#benefitsTitle', {
            opacity: 1,
            x: 0,
            duration: 1,
            scrollTrigger: {
                trigger: '#benefits',
                start: "top 70%",
                toggleActions: "play none none none"
            }
        });

        gsap.utils.toArray('[data-benefit]').forEach((benefit, i) => {
            gsap.to(benefit, {
                opacity: 1,
                x: 0,
                duration: 0.8,
                scrollTrigger: {
                    trigger: benefit,
                    start: "top 80%",
                    toggleActions: "play none none none"
                },
                delay: i * 0.2
            });
        });

        gsap.to('#benefitsImage', {
            opacity: 1,
            scale: 1,
            duration: 1.2,
            scrollTrigger: {
                trigger: '#benefits',
                start: "top 70%",
                toggleActions: "play none none none"
            },
            ease: "back.out(1.2)"
        });

        // Testimonials section
        gsap.to('#testimonialsTitle', {
            opacity: 1,
            y: 0,
            duration: 1,
            scrollTrigger: {
                trigger: '#testimonials',
                start: "top 70%",
                toggleActions: "play none none none"
            }
        });

        gsap.to('#testimonialsSubtitle', {
            opacity: 1,
            y: 0,
            duration: 1,
            delay: 0.2,
            scrollTrigger: {
                trigger: '#testimonials',
                start: "top 70%",
                toggleActions: "play none none none"
            }
        });

        gsap.utils.toArray('[data-testimonial]').forEach((testimonial, i) => {
            gsap.to(testimonial, {
                opacity: 1,
                y: 0,
                duration: 0.8,
                scrollTrigger: {
                    trigger: testimonial,
                    start: "top 80%",
                    toggleActions: "play none none none"
                },
                delay: i * 0.2
            });
        });

        // CTA section
        gsap.to('#ctaTitle', {
            opacity: 1,
            y: 0,
            duration: 1,
            scrollTrigger: {
                trigger: '.bg-gradient-to-br',
                start: "top 70%",
                toggleActions: "play none none none"
            }
        });

        gsap.to('#ctaText', {
            opacity: 1,
            y: 0,
            duration: 1,
            delay: 0.2,
            scrollTrigger: {
                trigger: '.bg-gradient-to-br',
                start: "top 70%",
                toggleActions: "play none none none"
            }
        });

        gsap.to('#ctaBtn', {
            opacity: 1,
            scale: 1,
            duration: 0.8,
            delay: 0.4,
            ease: "back.out(1.7)",
            scrollTrigger: {
                trigger: '.bg-gradient-to-br',
                start: "top 70%",
                toggleActions: "play none none none"
            }
        });

        gsap.to('#ctaDemoBtn', {
            opacity: 1,
            scale: 1,
            duration: 0.8,
            delay: 0.5,
            ease: "back.out(1.7)",
            scrollTrigger: {
                trigger: '.bg-gradient-to-br',
                start: "top 70%",
                toggleActions: "play none none none"
            }
        });

        gsap.to('#ctaNote', {
            opacity: 1,
            y: 0,
            duration: 1,
            delay: 0.6,
            scrollTrigger: {
                trigger: '.bg-gradient-to-br',
                start: "top 70%",
                toggleActions: "play none none none"
            }
        });

        // Footer animations
        gsap.to('#footerLogo', {
            opacity: 1,
            y: 0,
            duration: 1,
            scrollTrigger: {
                trigger: 'footer',
                start: "top 90%",
                toggleActions: "play none none none"
            }
        });

        gsap.to('#footerProduct', {
            opacity: 1,
            y: 0,
            duration: 1,
            delay: 0.1,
            scrollTrigger: {
                trigger: 'footer',
                start: "top 90%",
                toggleActions: "play none none none"
            }
        });

        gsap.to('#footerCompany', {
            opacity: 1,
            y: 0,
            duration: 1,
            delay: 0.2,
            scrollTrigger: {
                trigger: 'footer',
                start: "top 90%",
                toggleActions: "play none none none"
            }
        });

        gsap.to('#footerLegal', {
            opacity: 1,
            y: 0,
            duration: 1,
            delay: 0.3,
            scrollTrigger: {
                trigger: 'footer',
                start: "top 90%",
                toggleActions: "play none none none"
            }
        });

        gsap.to('#footerCopyright', {
            opacity: 1,
            y: 0,
            duration: 1,
            delay: 0.4,
            scrollTrigger: {
                trigger: 'footer',
                start: "top 90%",
                toggleActions: "play none none none"
            }
        });

        // Parallax effect for floating elements
        gsap.utils.toArray('.floating-element').forEach(element => {
            gsap.to(element, {
                y: 30,
                duration: 3,
                repeat: -1,
                yoyo: true,
                ease: "sine.inOut"
            });
        });

        // Button hover animations
        document.querySelectorAll('a[href*="register"]').forEach(button => {
            button.addEventListener('mouseenter', function() {
                gsap.to(this, {
                    scale: 1.05,
                    duration: 0.3,
                    ease: "power2.out"
                });
            });

            button.addEventListener('mouseleave', function() {
                gsap.to(this, {
                    scale: 1,
                    duration: 0.3,
                    ease: "power2.out"
                });
            });
        });

        // Feature card hover enhancement
        document.querySelectorAll('.feature-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                gsap.to(this, {
                    y: -10,
                    duration: 0.4,
                    ease: "power2.out"
                });
            });

            card.addEventListener('mouseleave', function() {
                gsap.to(this, {
                    y: 0,
                    duration: 0.4,
                    ease: "power2.out"
                });
            });
        });

        // Mobile menu toggle function
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            const isHidden = mobileMenu.classList.contains('hidden');

            if (isHidden) {
                mobileMenu.classList.remove('hidden');
                // Animate mobile menu items
                gsap.to('#mobileMenu a', {
                    x: 0,
                    opacity: 1,
                    duration: 0.4,
                    stagger: 0.05,
                    ease: "power2.out"
                });
            } else {
                // Hide mobile menu items
                gsap.to('#mobileMenu a', {
                    x: 10,
                    opacity: 0,
                    duration: 0.3,
                    stagger: 0.05,
                    ease: "power2.in",
                    onComplete: () => {
                        mobileMenu.classList.add('hidden');
                    }
                });
            }
        }

        // Smooth scrolling untuk tautan anchor
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');

                // Skip if it's just "#"
                if (href === '#') return;

                // Don't prevent default for demo button in CTA section
                if (this.id === 'ctaDemoBtn' || this.id === 'demoBtn') {
                    // Just scroll without preventing default
                    return;
                }

                e.preventDefault();

                const targetId = href;
                const targetElement = document.querySelector(targetId);

                if (targetElement) {
                    gsap.to(window, {
                        duration: 1,
                        scrollTo: {
                            y: targetElement,
                            offsetY: 80
                        },
                        ease: "power2.inOut"
                    });
                }
            });
        });

        // Navbar scroll effect
        let lastScroll = 0;
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            const currentScroll = window.pageYOffset;

            if (currentScroll <= 100) {
                navbar.style.boxShadow = "0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1)";
            } else if (currentScroll > lastScroll) {
                // Scrolling down
                gsap.to(navbar, {
                    y: -80,
                    duration: 0.3
                });
            } else {
                // Scrolling up
                gsap.to(navbar, {
                    y: 0,
                    duration: 0.3
                });
                navbar.style.boxShadow = "0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1)";
            }

            lastScroll = currentScroll;
        });

        // Add ripple effect to buttons
        document.querySelectorAll('a[href*="register"], #ctaBtn, #heroCta').forEach(button => {
            button.addEventListener('click', function(e) {
                // Create ripple element
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                ripple.style.cssText = `
                    position: absolute;
                    border-radius: 50%;
                    background: rgba(255, 255, 255, 0.7);
                    transform: scale(0);
                    animation: ripple 0.6s linear;
                    width: ${size}px;
                    height: ${size}px;
                    top: ${y}px;
                    left: ${x}px;
                    pointer-events: none;
                `;

                this.style.position = 'relative';
                this.style.overflow = 'hidden';
                this.appendChild(ripple);

                // Remove ripple after animation
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // Add CSS for ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>

</html>
