<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- @livewireStyles --}}

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Tambahan styling untuk mencegah scroll saat sidebar terbuka */
        body.sidebar-open {
            overflow: hidden;
            height: 100vh;
        }

        /* Pastikan z-index berurutan dengan benar */
        #sidebar {
            z-index: 50;
        }

        #overlay {
            z-index: 40;
        }

        /* Hapus overlay di desktop */
        @media (min-width: 768px) {
            #overlay {
                display: none !important;
            }
        }

        /* Backdrop blur custom untuk Tailwind v3 */
        .backdrop-blur-custom {
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        /* Custom styles for icons */
        .icon {
            width: 1.25rem;
            height: 1.25rem;
        }

        /* Smooth transitions */
        * {
            transition: background-color 0.3s ease, border-color 0.3s ease, transform 0.3s ease;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }

        /* Hover effects */
        .hover-lift:hover {
            transform: translateY(-2px);
        }

        /* Animation for progress bars */
        @keyframes progress {
            from {
                width: 0%;
            }

            to {
                width: var(--progress);
            }
        }

        .progress-animate {
            animation: progress 1s ease-out forwards;
        }
    </style>
    @stack('styles')
</head>

<body class="font-sans antialiased bg-gray-50">
    @if (session('success'))
        <script>
            console.log('SESSION:', @json(session('success')));
        </script>
    @endif

    <div class="flex h-screen overflow-hidden">

        <!-- OVERLAY (mobile) -->
        <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden">
        </div>

        <!-- Sidebar -->
        @include('layouts.partials.sidebar')
        {{-- <x-sidebar /> --}}

        <div class="flex-1 flex flex-col md:ml-64 w-full min-w-0">
            <!-- Page Heading -->
            @include('layouts.partials.header')
            {{-- <x-header /> --}}

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-3 sm:p-4 md:p-6 min-w-0">
                {{ $slot }}
            </main>
        </div>
    </div>




    @include('sweetalert::alert')

    <!-- SCRIPTS -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const body = document.body;

            // Toggle sidebar
            sidebar.classList.toggle('-translate-x-full');

            // Toggle overlay
            overlay.classList.toggle('hidden');

            // Toggle body scroll
            body.classList.toggle('sidebar-open');
        }

        // Tutup sidebar ketika overlay diklik (untuk mobile)
        document.getElementById('overlay').addEventListener('click', function() {
            toggleSidebar();
        });

        // Tutup sidebar ketika link menu diklik di mobile
        document.querySelectorAll('#sidebar nav a').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 768) {
                    toggleSidebar();
                }
            });
        });

        // Handle resize untuk memastikan sidebar dalam state yang benar
        function handleResize() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const body = document.body;

            if (window.innerWidth < 768) {
                // Mobile: pastikan sidebar tertutup secara default
                if (!sidebar.classList.contains('-translate-x-full')) {
                    sidebar.classList.add('-translate-x-full');
                }
                overlay.classList.add('hidden');
                body.classList.remove('sidebar-open');
            } else {
                // Desktop: pastikan sidebar terbuka
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.add('hidden');
                body.classList.remove('sidebar-open');
            }
        }

        // Jalankan saat halaman dimuat
        window.addEventListener('load', handleResize);

        // Jalankan saat ukuran window berubah
        window.addEventListener('resize', handleResize);

        // Update waktu real-time
        function updateTime() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const timeString = `${hours}:${minutes}:${seconds}`;

            const timeElement = document.getElementById('currentTime');
            if (timeElement) {
                timeElement.textContent = timeString;
            }
        }

        // Update waktu setiap detik
        updateTime();
        setInterval(updateTime, 1000);

        // Modal Tambah Projek
        function showAddProjectModal() {
            document.getElementById('addProjectModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function hideAddProjectModal() {
            document.getElementById('addProjectModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Toggle Sidebar for Mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');

            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        // Switch View (Grid/List)
        function switchView(view) {
            const gridView = document.getElementById('gridView');
            const listView = document.getElementById('listView');
            const gridBtn = document.getElementById('gridViewBtn');
            const listBtn = document.getElementById('listViewBtn');

            if (view === 'grid') {
                gridView.classList.remove('hidden');
                listView.classList.add('hidden');
                gridBtn.classList.add('bg-blue-100', 'text-blue-600');
                gridBtn.classList.remove('text-gray-400', 'hover:bg-gray-100');
                listBtn.classList.remove('bg-blue-100', 'text-blue-600');
                listBtn.classList.add('text-gray-400', 'hover:bg-gray-100');
            } else {
                gridView.classList.add('hidden');
                listView.classList.remove('hidden');
                listBtn.classList.add('bg-blue-100', 'text-blue-600');
                listBtn.classList.remove('text-gray-400', 'hover:bg-gray-100');
                gridBtn.classList.remove('bg-blue-100', 'text-blue-600');
                gridBtn.classList.add('text-gray-400', 'hover:bg-gray-100');
            }
        }

        // Modal Functions
        function openAddClientModal() {
            const modal = document.getElementById('addClientModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeEditClientModal() {
            const modal = document.getElementById('editClientModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }


        // Close sidebar when clicking overlay
        document.getElementById('overlay')?.addEventListener('click', function() {
            toggleSidebar();
        });
    </script>
    @stack('scripts')


    {{-- @livewireScripts --}}

</body>

</html>
