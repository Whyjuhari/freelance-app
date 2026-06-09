<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- Dashboard Custom --}}
    <!-- BANNER HEADER -->
    <div class="bg-blue-600 rounded-md p-4 md:p-6 mb-6 text-white shadow-lg">
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4 min-w-0">
            <div class="flex items-center gap-3 md:gap-4 min-w-0">
                <div class="min-w-0">
                    <h1 class="text-lg sm:text-xl md:text-2xl font-bold break-words">Welcome!</h1>
                    <p class="text-white text-opacity-90 text-xs md:text-base">Check today's
                        progress</p>
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-2 md:gap-3 w-full lg:w-auto">
                <div
                    class="bg-white bg-opacity-20 backdrop-blur-custom px-2 md:px-3 py-1 md:py-1.5 rounded-lg text-xs flex items-center gap-1.5">
                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                    <span class="font-semibold">All Systems Operational</span>
                </div>
                <div
                    class="bg-white bg-opacity-20 backdrop-blur-custom px-2 md:px-4 py-1 md:py-2 rounded-lg flex items-center gap-1 md:gap-2">
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="font-semibold text-xs">{{ now()->format('d M Y') }}</span>
                </div>
                <div class="bg-white bg-opacity-20 backdrop-blur-custom px-2 md:px-4 py-1 md:py-2 rounded-lg">
                    <span class="font-semibold text-xs" id="currentTime">21:50:10</span>
                </div>
            </div>
        </div>
    </div>

    <!-- KARTU RINGKASAN -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6">
        <div
            class="bg-white p-4 md:p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 border border-gray-100">
            <div class="flex items-center justify-between gap-2 mb-3 md:mb-4">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-blue-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                </div>
                <span
                    class="text-xl md:text-2xl text-blue-600 bg-blue-50 px-2 py-1 rounded font-semibold">{{ $stats['total'] }}</span>
            </div>
            <p class="text-xs md:text-sm text-gray-500 mt-1">Total Projects</p>
        </div>

        <div
            class="bg-white p-4 md:p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 border border-gray-100">
            <div class="flex items-center justify-between gap-2 mb-3 md:mb-4">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-amber-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span
                    class="text-xl md:text-2xl text-amber-600 bg-amber-50 px-2 py-1 rounded font-semibold">{{ $stats['active'] }}</span>
            </div>
            <p class="text-xs md:text-sm text-gray-500 mt-1">In Progress</p>
        </div>

        <div
            class="bg-white p-4 md:p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 border border-gray-100">
            <div class="flex items-center justify-between gap-2 mb-3 md:mb-4">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-green-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span
                    class="text-xl md:text-2xl text-green-600 bg-green-50 px-2 py-1 rounded font-semibold">{{ $stats['completed'] }}</span>
            </div>
            <p class="text-xs md:text-sm text-gray-500 mt-1">Completed Projects</p>
        </div>

        <div
            class="bg-white p-4 md:p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 border border-gray-100">
            <div class="flex items-center justify-between gap-2 mb-3 md:mb-4">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-red-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <span
                    class="text-xl md:text-2xl text-red-600 bg-red-50 px-2 py-1 rounded font-semibold">{{ $stats['urgent'] }}</span>
            </div>
            <p class="text-xs md:text-sm text-gray-500 mt-1">Near Deadline</p>
        </div>
    </div>

    <!-- BARIS GRAFIK & PENDAPATAN -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Grafik Pendapatan -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-green-400 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base md:text-lg font-semibold text-gray-800">Revenue Overview
                        </h2>
                        <p class="text-xs text-gray-500">Monthly revenue trend</p>
                    </div>
                </div>
                <select
                    class="w-full sm:w-auto text-xs md:text-sm border border-gray-300 rounded-lg px-4 sm:px-5 py-3 text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>Last 7 Days</option>
                    <option>Last 30 Days</option>
                    <option>Last 3 Months</option>
                </select>
            </div>
            <canvas id="revenueChart" height="80"></canvas>
        </div>

        <!-- Ringkasan Pendapatan -->
        <div class="bg-white rounded-xl shadow-lg p-4 md:p-6 text-gray-600 min-w-0">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">This Month</h3>
                <div
                    class="w-10 h-10 bg-green-400 bg-opacity-20 rounded-lg flex items-center justify-center backdrop-blur-custom">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
            </div>
            <p class="text-2xl md:text-3xl font-bold mb-2 break-words">Rp {{ number_format($financeSummary['income'], 0, ',', '.') }}</p>
            <p class="text-gray-500 text-opacity-80 text-sm mb-6">Total Revenue</p>

            <div class="space-y-3">
                <div class="flex items-center justify-between gap-3 pb-3 border-b border-gray-500 border-opacity-20">
                    <span class="text-sm text-gray-500 text-opacity-90">Expense</span>
                    <span class="font-semibold text-red-600">Rp
                        {{ number_format($financeSummary['expense'], 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between gap-3 pb-3 border-b border-gray-500 border-opacity-20">
                    <span class="text-sm text-gray-500 text-opacity-90">Net Profit</span>
                    <span class="font-semibold text-blue-600">Rp
                        {{ number_format($financeSummary['net'], 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between gap-3">
                    <span class="text-sm text-gray-500 text-opacity-90">Growth</span>
                    <span
                        class="font-semibold {{ $financeSummary['growth'] >= 0 ? 'text-yellow-500' : 'text-red-500' }} flex items-center gap-1">
                        {{ $financeSummary['growth'] >= 0 ? '+' : '' }}{{ $financeSummary['growth'] }}%
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- TABEL PROYEK -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-4 md:p-6 border-b flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br bg-blue-500 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-base md:text-lg font-semibold text-gray-800">Recent Projects</h2>
                    <p class="text-xs text-gray-500">Track your active work</p>
                </div>
            </div>
            <a href="{{ route('projects.index') }}"
                class="text-xs md:text-sm text-blue-600 hover:text-blue-700 font-medium flex items-center gap-1 hover:gap-2 transition-all duration-200">
                View All Projects
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <div class="p-4 md:p-6 overflow-x-auto">
            <table class="w-full min-w-[720px] text-xs md:text-sm">
                <thead>
                    <tr class="text-left text-gray-500 border-b">
                        <th class="pb-3 font-medium whitespace-nowrap">PROJECT</th>
                        <th class="pb-3 font-medium whitespace-nowrap">CLIENT</th>
                        <th class="pb-3 font-medium whitespace-nowrap">DEADLINE</th>
                        <th class="pb-3 font-medium whitespace-nowrap">PROGRES</th>
                        <th class="pb-3 font-medium whitespace-nowrap">STATUS</th>
                        <th class="pb-3 font-medium text-right whitespace-nowrap">BUDGET</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">

                    @foreach ($recentProjects as $project)
                        {{-- {{ dd($project->progress_color) }} --}}
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="py-4">
                                <div class="flex items-center gap-3">

                                    <div>
                                        <p class="font-medium text-gray-800">{{ $project->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $project->type }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 text-gray-600">{{ $project->client?->name ?? '_' }}</td>
                            <td class="py-4 text-gray-600">{{ $project->deadline?->format('d M Y') ?? '_' }}</td>
                            <td class="py-4">
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full transition-all duration-300 {{ $project->progress_color }}"
                                            style="width: {{ $project->progress }}%"></div>
                                    </div>
                                    <span class="text-xs font-medium text-gray-600">{{ $project->progress }}%</span>
                                </div>
                                {{-- <p class="text-xs text-gray-500">{{ $project->progress_label }}</p> --}}
                            </td>
                            <td class="py-4">
                                @if ($project->is_urgent)
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-600">
                                        Urgent
                                    </span>
                                @else
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-semibold {{ $project->status_color }}">
                                        {{ ucfirst($project->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 text-right font-semibold text-gray-800">Rp
                                {{ number_format($project->budget) }}</td>
                        </tr>
                    @endforeach
                    {{-- <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="py-4">
                            <div class="flex items-center gap-3">

                                <div>
                                    <p class="font-medium text-gray-800">Pengembangan Aplikasi Mobile</p>
                                    <p class="text-xs text-gray-500">React Native</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 text-gray-600">StartUp XYZ</td>
                        <td class="py-4">
                            <span class="text-red-600 font-medium flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                28 Des 2025
                            </span>
                        </td>
                        <td class="py-4">
                            <div class="flex items-center gap-2">
                                <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-purple-500 to-pink-500 rounded-full"
                                        style="width: 45%"></div>
                                </div>
                                <span class="text-xs font-medium text-gray-600">45%</span>
                            </div>
                        </td>
                        <td class="py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                Urgent
                            </span>
                        </td>
                        <td class="py-4 text-right font-semibold text-gray-800">$4,200</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="py-4">
                            <div class="flex items-center gap-3">

                                <div>
                                    <p class="font-medium text-gray-800">Platform E-Commerce</p>
                                    <p class="text-xs text-gray-500">Full Stack</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 text-gray-600">Digital Store Co.</td>
                        <td class="py-4 text-gray-600">15 Jan 2026</td>
                        <td class="py-4">
                            <div class="flex items-center gap-2">
                                <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-green-500 to-emerald-500 rounded-full"
                                        style="width: 90%"></div>
                                </div>
                                <span class="text-xs font-medium text-gray-600">90%</span>
                            </div>
                        </td>
                        <td class="py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                Almost Done
                            </span>
                        </td>
                        <td class="py-4 text-right font-semibold text-gray-800">$5,800</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="py-4">
                            <div class="flex items-center gap-3">

                                <div>
                                    <p class="font-medium text-gray-800">Desain Identitas Merek</p>
                                    <p class="text-xs text-gray-500">Desain Grafis</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 text-gray-600">Creative Agency</td>
                        <td class="py-4 text-gray-600">10 Jan 2026</td>
                        <td class="py-4">
                            <div class="flex items-center gap-2">
                                <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-orange-500 to-red-500 rounded-full"
                                        style="width: 30%"></div>
                                </div>
                                <span class="text-xs font-medium text-gray-600">30%</span>
                            </div>
                        </td>
                        <td class="py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                Aktif
                            </span>
                        </td>
                        <td class="py-4 text-right font-semibold text-gray-800">$1,500</td>
                    </tr> --}}
                </tbody>
            </table>
        </div>
    </div>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const revenueCtx = document.getElementById('revenueChart');
            if (revenueCtx) {
                new Chart(revenueCtx.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: @json($chartLabels),
                        datasets: [{
                                label: 'Income',
                                data: @json($chartIncome),
                                borderColor: '#10b981',
                                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                fill: true,
                                tension: 0.4,
                                pointBackgroundColor: '#10b981',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointRadius: 4
                            },
                            {
                                label: 'Expense',
                                data: @json($chartExpense),
                                borderColor: '#ef4444',
                                backgroundColor: 'rgba(239, 68, 68, 0.08)',
                                fill: true,
                                tension: 0.4,
                                pointBackgroundColor: '#ef4444',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointRadius: 4
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom'
                            },
                            tooltip: {
                                callbacks: {
                                    label: context =>
                                        `${context.dataset.label}: Rp ${Number(context.parsed.y).toLocaleString('id-ID')}`
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: value => `Rp ${Number(value).toLocaleString('id-ID')}`
                                },
                                grid: {
                                    drawBorder: false,
                                    color: 'rgba(0, 0, 0, 0.05)'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }
        </script>
    @endpush
</x-app-layout>
