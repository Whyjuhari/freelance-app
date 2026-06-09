<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reports') }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white rounded-lg p-4 md:p-6 text-gray-600 shadow-md">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 min-w-0">
                <div class="min-w-0">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 break-words">Business Reports</h1>
                    <p class="text-gray-600 mt-1">A summary of project, time, task, and finance performance.</p>
                </div>
                <div class="flex flex-col sm:flex-row sm:flex-wrap gap-2 w-full lg:w-auto">
                    <a href="{{ route('laporan.export.csv', request()->query()) }}"
                        class="w-full sm:w-auto px-4 py-2 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 text-center">Export CSV</a>
                    <a href="{{ route('laporan.print', request()->query()) }}" target="_blank"
                        class="w-full sm:w-auto px-4 py-2 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 text-center">Print / PDF</a>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
            <form method="GET" action="{{ route('laporan.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <input type="date" name="start_date" value="{{ $filters['start_date'] }}"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <input type="date" name="end_date" value="{{ $filters['end_date'] }}"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700">Apply</button>
                <a href="{{ route('laporan.index') }}"
                    class="px-4 py-2 border border-gray-300 rounded-lg font-medium text-center text-gray-600 hover:bg-gray-50">Reset</a>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500">Income</p>
                <p class="text-xl sm:text-2xl font-bold text-green-600 mt-2 break-words">Rp {{ number_format($summary['income'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500">Expense</p>
                <p class="text-xl sm:text-2xl font-bold text-red-600 mt-2 break-words">Rp {{ number_format($summary['expense'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500">Net Profit</p>
                <p class="text-xl sm:text-2xl font-bold {{ $summary['net'] >= 0 ? 'text-blue-600' : 'text-red-600' }} mt-2 break-words">
                    Rp {{ number_format($summary['net'], 0, ',', '.') }}
                </p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500">Tracked Hours</p>
                <p class="text-2xl font-bold text-gray-800 mt-2">{{ number_format($summary['hours'], 1) }}h</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">Finance Trend</h2>
                        <p class="text-sm text-gray-500">Monthly income and expenses.</p>
                    </div>
                </div>
                <canvas id="reportChart" height="100"></canvas>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6 space-y-4">
                <h2 class="text-lg font-semibold text-gray-800">Productivity</h2>
                <div>
                    <p class="text-sm text-gray-500">Billable Hours</p>
                    <p class="text-xl font-bold text-amber-600">{{ number_format($summary['billable_hours'], 1) }}h</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Completed Tasks</p>
                    <p class="text-xl font-bold text-green-600">
                        {{ $summary['completed_tasks'] }}/{{ $summary['total_tasks'] }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-2">Completion Rate</p>
                    <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-blue-600 rounded-full" style="width: {{ $summary['completion_rate'] }}%"></div>
                    </div>
                    <p class="text-sm font-semibold text-gray-700 mt-2">{{ $summary['completion_rate'] }}%</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b">
                    <h2 class="text-lg font-semibold text-gray-800">Revenue by Project</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[640px] text-sm">
                        <thead class="bg-gray-50 text-gray-500">
                            <tr>
                                <th class="p-4 text-left font-medium">Project</th>
                                <th class="p-4 text-right font-medium">Income</th>
                                <th class="p-4 text-right font-medium">Expense</th>
                                <th class="p-4 text-right font-medium">Net</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($projectRevenue as $row)
                                <tr>
                                    <td class="p-4 text-gray-700">{{ $row['name'] }}</td>
                                    <td class="p-4 text-right text-green-600">Rp {{ number_format($row['income'], 0, ',', '.') }}</td>
                                    <td class="p-4 text-right text-red-600">Rp {{ number_format($row['expense'], 0, ',', '.') }}</td>
                                    <td class="p-4 text-right font-semibold">Rp {{ number_format($row['net'], 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-8 text-center text-gray-500">No project data yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b">
                    <h2 class="text-lg font-semibold text-gray-800">Revenue by Client</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[640px] text-sm">
                        <thead class="bg-gray-50 text-gray-500">
                            <tr>
                                <th class="p-4 text-left font-medium">Client</th>
                                <th class="p-4 text-right font-medium">Income</th>
                                <th class="p-4 text-right font-medium">Expense</th>
                                <th class="p-4 text-right font-medium">Net</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($clientRevenue as $row)
                                <tr>
                                    <td class="p-4 text-gray-700">{{ $row['name'] }}</td>
                                    <td class="p-4 text-right text-green-600">Rp {{ number_format($row['income'], 0, ',', '.') }}</td>
                                    <td class="p-4 text-right text-red-600">Rp {{ number_format($row['expense'], 0, ',', '.') }}</td>
                                    <td class="p-4 text-right font-semibold">Rp {{ number_format($row['net'], 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-8 text-center text-gray-500">No client data yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const reportCtx = document.getElementById('reportChart');
            if (reportCtx) {
                new Chart(reportCtx.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: @json($chart['labels']),
                        datasets: [{
                                label: 'Income',
                                data: @json($chart['income']),
                                borderColor: '#16a34a',
                                backgroundColor: 'rgba(22, 163, 74, 0.1)',
                                fill: true,
                                tension: 0.35
                            },
                            {
                                label: 'Expense',
                                data: @json($chart['expense']),
                                borderColor: '#dc2626',
                                backgroundColor: 'rgba(220, 38, 38, 0.08)',
                                fill: true,
                                tension: 0.35
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: value => 'Rp ' + Number(value).toLocaleString('id-ID')
                                }
                            }
                        }
                    }
                });
            }
        </script>
    @endpush
</x-app-layout>
