<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clients') }}
        </h2>
    </x-slot>

    <!-- HEADER -->
    <div class="bg-white rounded-lg p-4 md:p-6 mb-6 text-gray-600 shadow-md">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4 min-w-0">
            <div class="min-w-0">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 break-words">My Clients</h1>
                <p class="text-gray-600 mt-1">Manage your client relationships</p>
            </div>
            <button onclick="openClientModal()"
                class="inline-flex w-full sm:w-auto items-center justify-center bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:from-blue-700 hover:to-indigo-700 transition-all shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add New Client
            </button>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-semibold text-gray-500 uppercase">Total Clients</span>
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-800">{{ $totalClients }}</p>
            </div>

            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-semibold text-gray-500 uppercase">Active</span>
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-800">{{ $activeClients }}</p>
            </div>

            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-semibold text-gray-500 uppercase">Total Revenue</span>
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xl sm:text-2xl font-bold text-gray-800 break-words">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>

            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-semibold text-gray-500 uppercase">New This Month</span>
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-800">{{ $newThisMonth }}</p>
            </div>
        </div>
    </div>

    <!-- SEARCH & FILTER -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
        <form method="GET" action="{{ route('client.index') }}" class="flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1 min-w-0">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" id="searchInput" name="search" value="{{ request('search') }}"
                        placeholder="Search clients..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>

            <!-- Filter Status -->
            <select id="statusFilter" name="status"
                class="w-full md:w-auto px-4 md:px-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">All Status</option>
                <option value="active" @selected(request('status') === 'active')>Active</option>
                <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
            </select>

            <!-- Sort By -->
            <select id="sortBy" name="sort"
                class="w-full md:w-auto px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="latest" @selected(request('sort', 'latest') === 'latest')>Sort by: Recent</option>
                <option value="name_asc" @selected(request('sort') === 'name_asc')>Name (A-Z)</option>
                <option value="name_desc" @selected(request('sort') === 'name_desc')>Name (Z-A)</option>
            </select>

            <button type="submit"
                class="w-full md:w-auto px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700">Filter</button>
            <a href="{{ route('client.index') }}"
                class="w-full md:w-auto px-4 py-2 border border-gray-300 rounded-lg font-medium text-gray-600 hover:bg-gray-50 text-center">Reset</a>

            <!-- View Toggle -->
            <div class="flex items-center justify-center gap-2">
                <button type="button" onclick="switchView('grid')" id="gridViewBtn"
                    class="p-2 rounded-lg bg-blue-100 text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                </button>
                <button type="button" onclick="switchView('list')" id="listViewBtn"
                    class="p-2 rounded-lg text-gray-400 hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </form>
    </div>

    <!-- CLIENTS GRID VIEW -->
    <div id="gridView" class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($clients as $client)
            <!-- Client Card 1 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-start justify-between gap-3 mb-4">
                    <div class="flex items-center gap-3 min-w-0">
                        <div
                            class="w-12 h-12 rounded-full {{ $client->color }} flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                            {{ $client->initial }}
                        </div>
                        <div class="min-w-0">
                            <h3 class="font-semibold text-gray-800 truncate">{{ $client->company_name }}</h3>
                            <p class="text-xs text-gray-500">{{ $client->created_at->format('d M Y') ?? '' }}</p>
                        </div>
                    </div>
                    <span
                        class="px-2 py-1 text-xs font-semibold rounded-full
                        {{ $client->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}
                         ">{{ ucfirst($client->status) }}</span>
                </div>

                <div class="space-y-3 mb-4">
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>{{ $client->name }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span class="truncate min-w-0">{{ $client->alamat_email }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span>{{ $client->formatted_phone }}</span>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-gray-600">Project</span>
                        <span class="text-sm font-semibold text-gray-800">{{ $client->projects_count }}</span>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <span class="text-sm text-gray-600">Total Revenue</span>
                        <span
                            class="text-sm font-semibold text-green-600 break-words text-right">{{ number_format($client->revenue, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-2 mt-4">
                    {{-- <button
                        class="flex-1 px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors text-sm font-medium">
                        View Details
                    </button> --}}
                    <form action="{{ route('client.destroy', $client) }}" method="POST" class="inline delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button"
                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200 delete-btn"
                            title="Delete">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
                    <button type="button"
                        onclick="openClientModalFromButton(this)"
                        data-url="{{ route('client.update', $client) }}"
                        data-company-name="{{ $client->company_name }}"
                        data-name="{{ $client->name }}"
                        data-email="{{ $client->alamat_email }}"
                        data-phone="{{ $client->phone }}"
                        data-status="{{ $client->status }}"
                        data-notes="{{ $client->notes }}"
                        class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </button>
                </div>
            </div>
        @endforeach

        {{-- <!-- Client Card 2 -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div
                        class="w-12 h-12 rounded-full bg-gradient-to-br from-green-500 to-emerald-500 flex items-center justify-center text-white font-bold text-lg">
                        DM
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">Digital Marketing Co.</h3>
                        <p class="text-xs text-gray-500">Since Mar 2024</p>
                    </div>
                </div>
                <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">Active</span>
            </div>

            <div class="space-y-3 mb-4">
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>Sarah Johnson</span>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span class="truncate">sarah@digitalmarketing.co</span>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <span>+1 345 678 9001</span>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-600">Projects</span>
                    <span class="text-sm font-semibold text-gray-800">5 Active</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Total Revenue</span>
                    <span class="text-sm font-semibold text-green-600">$28,900</span>
                </div>
            </div>

            <div class="flex items-center gap-2 mt-4">
                <button
                    class="flex-1 px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors text-sm font-medium">
                    View Details
                </button>
                <button class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </button>
            </div>
        </div> --}}
        {{--
        <!-- Client Card 3 -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div
                        class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold text-lg">
                        EC
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">E-Commerce Plus</h3>
                        <p class="text-xs text-gray-500">Since Feb 2024</p>
                    </div>
                </div>
                <span
                    class="px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-700 rounded-full">Inactive</span>
            </div>

            <div class="space-y-3 mb-4">
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>Michael Chen</span>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span class="truncate">michael@ecommerceplus.com</span>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <span>+1 456 789 0012</span>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-600">Projects</span>
                    <span class="text-sm font-semibold text-gray-800">0 Active</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Total Revenue</span>
                    <span class="text-sm font-semibold text-green-600">$8,200</span>
                </div>
            </div>

            <div class="flex items-center gap-2 mt-4">
                <button
                    class="flex-1 px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors text-sm font-medium">
                    View Details
                </button>
                <button class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Client Card 4 -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div
                        class="w-12 h-12 rounded-full bg-gradient-to-br from-orange-500 to-red-500 flex items-center justify-center text-white font-bold text-lg">
                        FG
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">Fashion Group</h3>
                        <p class="text-xs text-gray-500">Since Apr 2024</p>
                    </div>
                </div>
                <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">Active</span>
            </div>

            <div class="space-y-3 mb-4">
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>Emma Davis</span>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span class="truncate">emma@fashiongroup.com</span>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <span>+1 567 890 1123</span>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-600">Projects</span>
                    <span class="text-sm font-semibold text-gray-800">2 Active</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Total Revenue</span>
                    <span class="text-sm font-semibold text-green-600">$15,700</span>
                </div>
            </div>

            <div class="flex items-center gap-2 mt-4">
                <button
                    class="flex-1 px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors text-sm font-medium">
                    View Details
                </button>
                <button class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </button>
            </div>
        </div> --}}

        <!-- Client Card 5 -->
        {{-- <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div
                        class="w-12 h-12 rounded-full bg-gradient-to-br from-cyan-500 to-blue-500 flex items-center justify-center text-white font-bold text-lg">
                        HS
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">Healthcare Systems</h3>
                        <p class="text-xs text-gray-500">Since May 2024</p>
                    </div>
                </div>
                <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">Active</span>
            </div>

            <div class="space-y-3 mb-4">
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>Dr. James Wilson</span>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span class="truncate">james@healthcaresys.com</span>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <span>+1 678 901 2234</span>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-600">Projects</span>
                    <span class="text-sm font-semibold text-gray-800">4 Active</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Total Revenue</span>
                    <span class="text-sm font-semibold text-green-600">$32,400</span>
                </div>
            </div>

            <div class="flex items-center gap-2 mt-4">
                <button
                    class="flex-1 px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors text-sm font-medium">
                    View Details
                </button>
                <button class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Client Card 6 -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div
                        class="w-12 h-12 rounded-full bg-gradient-to-br from-yellow-500 to-orange-500 flex items-center justify-center text-white font-bold text-lg">
                        RE
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">Real Estate Pro</h3>
                        <p class="text-xs text-gray-500">Since Jun 2024</p>
                    </div>
                </div>
                <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">Active</span>
            </div>

            <div class="space-y-3 mb-4">
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>Lisa Anderson</span>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span class="truncate">lisa@realestatepro.com</span>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <span>+1 789 012 3345</span>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-600">Projects</span>
                    <span class="text-sm font-semibold text-gray-800">1 Active</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Total Revenue</span>
                    <span class="text-sm font-semibold text-green-600">$9,800</span>
                </div>
            </div>

            <div class="flex items-center gap-2 mt-4">
                <button
                    class="flex-1 px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors text-sm font-medium">
                    View Details
                </button>
                <button class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </button>
            </div>
        </div> --}}
    </div>

    <!-- CLIENTS LIST VIEW (Hidden by default) -->
    <div id="listView" class="hidden space-y-4">
        @foreach ($clients as $client)
            <!-- List Item 1 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6 hover:shadow-lg transition-shadow">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-center gap-4 flex-1 min-w-0">
                        <div
                            class="w-16 h-16 rounded-full {{ $client->color }} flex items-center justify-center text-white font-bold text-xl flex-shrink-0">
                            {{ $client->initial }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-gray-800 text-lg">{{ $client->company_name }}</h3>
                            <p class="text-sm text-gray-500">{{ $client->name }} • {{ $client->alamat_email }}</p>
                            <p class="text-sm text-gray-500">{{ $client->phone }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-4 md:gap-6 w-full md:w-auto">
                        <div class="text-center">
                            <p class="text-xs text-gray-500 mb-1">Projects</p>
                            <p class="text-lg font-semibold text-gray-800">{{ $client->projects_count }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-xs text-gray-500 mb-1">Revenue</p>
                            <p class="text-base md:text-lg font-semibold text-green-600 break-words">
                                Rp{{ number_format($client->revenue, 0, ',', '.') }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-xs text-gray-500 mb-1">Status</p>
                            <span
                                class="px-2 py-1 text-xs font-semibold rounded-full
                        {{ $client->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}
                         ">{{ ucfirst($client->status) }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 w-full md:w-auto justify-end">
                        {{-- <button
                            class="px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors text-sm font-medium">
                            View Details
                        </button> --}}
                        <button type="button"
                            onclick="openClientModalFromButton(this)"
                            data-url="{{ route('client.update', $client) }}"
                            data-company-name="{{ $client->company_name }}"
                            data-name="{{ $client->name }}"
                            data-email="{{ $client->alamat_email }}"
                            data-phone="{{ $client->phone }}"
                            data-status="{{ $client->status }}"
                            data-notes="{{ $client->notes }}"
                            class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                        <form action="{{ route('client.destroy', $client) }}" method="POST"
                            class="inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200 delete-btn"
                                title="Delete">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        {{-- <!-- List Item 2 -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-shadow">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-4 flex-1">
                    <div
                        class="w-16 h-16 rounded-full bg-gradient-to-br from-green-500 to-emerald-500 flex items-center justify-center text-white font-bold text-xl flex-shrink-0">
                        DM
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-gray-800 text-lg">Digital Marketing Co.</h3>
                        <p class="text-sm text-gray-500">Sarah Johnson • sarah@digitalmarketing.co</p>
                        <p class="text-sm text-gray-500">+1 345 678 9001</p>
                    </div>
                </div>

                <div class="flex items-center gap-6">
                    <div class="text-center">
                        <p class="text-xs text-gray-500 mb-1">Projects</p>
                        <p class="text-lg font-semibold text-gray-800">5</p>
                    </div>
                    <div class="text-center">
                        <p class="text-xs text-gray-500 mb-1">Revenue</p>
                        <p class="text-lg font-semibold text-green-600">$28.9k</p>
                    </div>
                    <div class="text-center">
                        <p class="text-xs text-gray-500 mb-1">Status</p>
                        <span
                            class="px-3 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">Active</span>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <button
                        class="px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors text-sm font-medium">
                        View Details
                    </button>
                    <button
                        class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div> --}}
    </div>

    @if ($clients->hasPages())
        <div class="mt-6">
            {{ $clients->links() }}
        </div>
    @endif


    <!-- ADD CLIENT MODAL -->
    <div id="addClientModal" class="fixed inset-0 bg-black/50 z-[100] hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white border-b border-gray-200 px-4 sm:px-6 py-4 flex items-center justify-between gap-3">
                <h2 id="clientModalTitle" class="text-xl sm:text-2xl font-bold text-gray-800">Add New Client</h2>
                <button onclick="closeAddClientModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="clientForm" class="p-4 sm:p-6 space-y-6" method="POST" action="{{ route('client.store') }}">
                @csrf
                <input type="hidden" name="_method" id="clientMethod" value="POST">
                <!-- Company Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Company Information</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Company Name *</label>
                            <input type="text" name="company_name" id="clientCompanyName"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter company name">
                        </div>
                    </div>
                </div>

                <!-- Contact Person -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Contact Person</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                            <input type="text" name="name" id="clientName"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter contact name">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="alamat_email" id="clientEmail"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="contact@company.com">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                            <input type="tel" name="phone" id="clientPhone"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="+1 234 567 8900">
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Additional Information</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" id="clientStatus"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="active" {{ old('status' == 'active' ? 'selected' : '') }}>Active
                                </option>
                                <option value="inactive" {{ old('status' == 'inactive' ? 'selected' : '') }}>Inactive
                                </option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                            <textarea rows="4" name="notes" id="clientNotes"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Add any notes about this client..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="button" onclick="closeAddClientModal()"
                        class="w-full sm:w-auto px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                        Cancel
                    </button>
                    <button type="submit"
                        class="w-full sm:w-auto px-6 py-2 bg-blue-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all shadow-lg font-medium">
                        Add Client
                    </button>
                </div>
            </form>
        </div>
    </div>
    @push('scripts')
        <script>
            function openClientModal(client = null) {
                const modal = document.getElementById('addClientModal');
                const form = document.getElementById('clientForm');

                document.getElementById('clientModalTitle').textContent = client ? 'Edit Client' : 'Add New Client';
                form.action = client ? client.url : '{{ route('client.store') }}';
                document.getElementById('clientMethod').value = client ? 'PUT' : 'POST';
                document.getElementById('clientCompanyName').value = client?.company_name ?? '';
                document.getElementById('clientName').value = client?.name ?? '';
                document.getElementById('clientEmail').value = client?.alamat_email ?? '';
                document.getElementById('clientPhone').value = client?.phone ?? '';
                document.getElementById('clientStatus').value = client?.status ?? 'active';
                document.getElementById('clientNotes').value = client?.notes ?? '';

                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            function openAddClientModal() {
                openClientModal();
            }

            function openClientModalFromButton(button) {
                openClientModal({
                    url: button.dataset.url,
                    company_name: button.dataset.companyName,
                    name: button.dataset.name,
                    alamat_email: button.dataset.email,
                    phone: button.dataset.phone,
                    status: button.dataset.status,
                    notes: button.dataset.notes,
                });
            }

            function closeAddClientModal() {
                const modal = document.getElementById('addClientModal');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.getElementById('clientForm').reset();
            }

            document.getElementById('addClientModal')?.addEventListener('click', function(e) {
                if (e.target === this) closeAddClientModal();
            });

            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');
                    Swal.fire({
                        title: 'Delete data?',
                        text: 'Data will be deleted permanently.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Yes, delete',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>
