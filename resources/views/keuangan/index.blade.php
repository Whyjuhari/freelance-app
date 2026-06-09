<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Finance') }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white rounded-lg p-4 md:p-6 text-gray-600 shadow-md">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 min-w-0">
                <div class="min-w-0">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 break-words">Finance</h1>
                    <p class="text-gray-600 mt-1">Track your freelance income and expenses.</p>
                </div>
                <button type="button" onclick="openFinanceModal()"
                    class="inline-flex w-full sm:w-auto items-center justify-center bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-all shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Record
                </button>
            </div>
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
                <p class="text-sm text-gray-500">Transactions</p>
                <p class="text-2xl font-bold text-gray-800 mt-2">{{ $summary['count'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border border-gray-100">
            <form method="GET" action="{{ route('keuangan.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-3">
                <input type="date" name="start_date" value="{{ $filters['start_date'] }}"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <input type="date" name="end_date" value="{{ $filters['end_date'] }}"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <select name="type"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">All Types</option>
                    <option value="income" @selected($filters['type'] === 'income')>Income</option>
                    <option value="expense" @selected($filters['type'] === 'expense')>Expense</option>
                </select>
                <select name="project_id"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">All Projects</option>
                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}" @selected((string) $filters['project_id'] === (string) $project->id)>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
                <div class="flex gap-2">
                    <button type="submit"
                        class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700">Filter</button>
                    <a href="{{ route('keuangan.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-lg font-medium text-gray-600 hover:bg-gray-50">Reset</a>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[760px] text-sm">
                    <thead class="bg-gray-50 border-b text-left text-gray-500">
                        <tr>
                            <th class="p-4 font-medium">Date</th>
                            <th class="p-4 font-medium">Type</th>
                            <th class="p-4 font-medium">Project</th>
                            <th class="p-4 font-medium">Note</th>
                            <th class="p-4 font-medium text-right">Amount</th>
                            <th class="p-4 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($finances as $finance)
                            <tr class="hover:bg-gray-50">
                                <td class="p-4 text-gray-700">{{ $finance->created_at->format('d M Y') }}</td>
                                <td class="p-4">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-semibold {{ $finance->type === 'income' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $finance->type === 'income' ? 'Income' : 'Expense' }}
                                    </span>
                                </td>
                                <td class="p-4 text-gray-700">{{ $finance->project?->name ?? '-' }}</td>
                                <td class="p-4 text-gray-600 max-w-xs truncate">{{ $finance->note ?? '-' }}</td>
                                <td class="p-4 text-right font-semibold {{ $finance->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                    Rp {{ number_format($finance->amount, 0, ',', '.') }}
                                </td>
                                <td class="p-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button"
                                            onclick="openFinanceModalFromButton(this)"
                                            data-url="{{ route('keuangan.update', $finance) }}"
                                            data-amount="{{ $finance->amount }}"
                                            data-type="{{ $finance->type }}"
                                            data-project-id="{{ $finance->project_id }}"
                                            data-note="{{ $finance->note }}"
                                            data-date="{{ $finance->created_at->format('Y-m-d') }}"
                                            class="p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <form action="{{ route('keuangan.destroy', $finance) }}" method="POST" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="delete-btn p-2 text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-10 text-center text-gray-500">
                                    No finance records found for this period.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($finances->hasPages())
                <div class="p-4 border-t">
                    {{ $finances->links() }}
                </div>
            @endif
        </div>
    </div>

    <div id="financeModal" class="fixed inset-0 bg-black/50 z-[100] hidden items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-xl w-full max-h-[90vh] overflow-y-auto">
            <div class="px-4 sm:px-6 py-4 border-b flex items-center justify-between gap-3">
                <h2 id="financeModalTitle" class="text-lg sm:text-xl font-bold text-gray-800">Add Finance Record</h2>
                <button type="button" onclick="closeFinanceModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="financeForm" method="POST" action="{{ route('keuangan.store') }}" class="p-4 sm:p-6 space-y-4">
                @csrf
                <input type="hidden" name="_method" id="financeMethod" value="POST">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                        <input type="date" name="date" id="financeDate"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                        <select name="type" id="financeType" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="income">Income</option>
                            <option value="expense">Expense</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Amount</label>
                    <input type="number" name="amount" id="financeAmount" min="0" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Example: 1500000">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Project</label>
                    <select name="project_id" id="financeProject"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">No project</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Note</label>
                    <textarea name="note" id="financeNote" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Example: First milestone payment"></textarea>
                </div>

                <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4 border-t">
                    <button type="button" onclick="closeFinanceModal()"
                        class="w-full sm:w-auto px-5 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Cancel</button>
                    <button type="submit"
                        class="w-full sm:w-auto px-5 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700">Save</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function openFinanceModal(finance = null) {
                const modal = document.getElementById('financeModal');
                const form = document.getElementById('financeForm');
                const method = document.getElementById('financeMethod');

                document.getElementById('financeModalTitle').textContent = finance ?
                    'Edit Finance Record' :
                    'Add Finance Record';
                form.action = finance ? finance.url : '{{ route('keuangan.store') }}';
                method.value = finance ? 'PUT' : 'POST';

                document.getElementById('financeDate').value = finance?.date ?? new Date().toISOString().slice(0, 10);
                document.getElementById('financeType').value = finance?.type ?? 'income';
                document.getElementById('financeAmount').value = finance?.amount ?? '';
                document.getElementById('financeProject').value = finance?.project_id ?? '';
                document.getElementById('financeNote').value = finance?.note ?? '';

                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            function closeFinanceModal() {
                const modal = document.getElementById('financeModal');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.getElementById('financeForm').reset();
            }

            function openFinanceModalFromButton(button) {
                openFinanceModal({
                    url: button.dataset.url,
                    amount: button.dataset.amount,
                    type: button.dataset.type,
                    project_id: button.dataset.projectId,
                    note: button.dataset.note,
                    date: button.dataset.date,
                });
            }

            document.getElementById('financeModal')?.addEventListener('click', function(e) {
                if (e.target === this) closeFinanceModal();
            });

            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');
                    Swal.fire({
                        title: 'Delete record?',
                        text: 'Finance data will be permanently deleted.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Yes, delete',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) form.submit();
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>
