<!-- SIDEBAR -->
<aside id="sidebar"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 shadow-sm transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">

    <div class="h-full flex flex-col">
        <!-- Logo -->
        <div class="h-16 flex items-center justify-between px-6 border-b border-gray-200">
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-lg  flex items-center justify-center text-gray-700 mr-3">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <span class="text-lg font-bold text-gray-800">
                    {{ __('FreelanceApp') }}
                </span>
            </div>
            <!-- Tombol tutup untuk mobile -->
            <button class="md:hidden text-gray-600 hover:text-gray-800" onclick="toggleSidebar()">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Informasi Pengguna -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold">
                    {{ Auth::user()->initial }}
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">Freelancer</p>
                    <p class="text-xs text-gray-500">{{ Str::lower(Auth::user()->name) }}</p>
                </div>
            </div>
        </div>
        <!-- Menu -->
        <nav class="flex-1 px-4 py-6 space-y-1 text-sm overflow-y-auto">

            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Data Management</p>
            </div>
            @foreach (config('sidebar') as $menu)
                @if ($menu['route'] === 'ai.index')
                    <div class="pt-4 pb-2">
                        <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">AI Assistant</p>
                    </div>
                    <x-menu-nav-link :href="route($menu['route'])" :active="request()->routeIs($menu['route'])">
                        <x-icon :name="$menu['icon']" />
                        {{ $menu['label'] }}
                        <span
                            class="ml-auto px-2 py-0.5 text-xs font-semibold bg-purple-200 text-blue-600 rounded-full">Baru</span>
                    </x-menu-nav-link>
                @else
                    <x-menu-nav-link :href="route($menu['route'])" :active="request()->routeIs($menu['route'])">
                        <x-icon :name="$menu['icon']" />
                        <span>{{ $menu['label'] }}</span>
                    </x-menu-nav-link>
                @endif
            @endforeach
            {{-- <a href="#"
                class="flex items-center gap-3 px-4 py-2.5 rounded-md text-gray-600 hover:bg-gray-100 transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Pelacakan Waktu
            </a>
            <a href="#"
                class="flex items-center gap-3 px-4 py-2.5 rounded-md text-gray-600 hover:bg-gray-100 transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Finance
            </a>
            <a href="#"
                class="flex items-center gap-3 px-4 py-2.5 rounded-md text-gray-600 hover:bg-gray-100 transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                Reports
            </a>
            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">AI Assistant</p>
            </div> --}}


            {{-- <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Pengaturan</p>
            </div> --}}

            {{-- <div class="px-6 py-4 border-b border-gray-200">
                <a href="#"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-md text-gray-600 hover:bg-gray-100 transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Pengaturan
                </a>
            </div> --}}
        </nav>
        <div class="px-6 py-4 border-t border-gray-200">
            <!-- LOGOUT BUTTON -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 px-4 py-2 rounded-lg
               text-red-500 bg-red-200 hover:bg-red-300
               transition-colors duration-300 text-sm font-medium">

                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V5" />
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </div>
</aside>
