<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Time Tracking') }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        <!-- Active Timer Banner -->
        @if ($activeTimer)
            <div class="bg-gradient-to-r from-green-500 to-emerald-500 rounded-xl shadow-lg p-4 sm:p-6 text-white">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    <div class="flex items-center gap-4 min-w-0">
                        <div
                            class="w-14 h-14 bg-white bg-opacity-20 rounded-xl flex items-center justify-center animate-pulse">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-xl font-bold mb-1">Timer Running</h3>
                            <p class="text-white text-opacity-90 break-words">{{ $activeTimer->project->name }}</p>
                            @if ($activeTimer->task)
                                <p class="text-sm text-white text-opacity-75">{{ $activeTimer->task->name }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-4 w-full md:w-auto">
                        <div class="text-left sm:text-right">
                            <p class="text-3xl font-bold" id="timer-display">00:00:00</p>
                            <p class="text-sm text-white text-opacity-75">Started
                                {{ $activeTimer->start_time->diffForHumans() }}</p>
                        </div>
                        <button onclick="stopTimer({{ $activeTimer->id }})"
                            class="w-full sm:w-auto px-6 py-3 bg-white text-green-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors duration-200 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Stop Timer
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white p-4 sm:p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['today_hours'], 1) }}h</p>
                <p class="text-sm text-gray-500 mt-1">Today</p>
            </div>

            <div class="bg-white p-4 sm:p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['week_hours'], 1) }}h</p>
                <p class="text-sm text-gray-500 mt-1">This Week</p>
            </div>

            <div class="bg-white p-4 sm:p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_hours'], 1) }}h</p>
                <p class="text-sm text-gray-500 mt-1">Selected Period</p>
            </div>

            <div class="bg-white p-4 sm:p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['billable_hours'], 1) }}h</p>
                <p class="text-sm text-gray-500 mt-1">Billable</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
            <div class="flex flex-col md:flex-row gap-4">
                <!-- Start Timer -->
                @if (!$activeTimer)
                    <div class="flex-1">
                        <form id="start-timer-form" class="flex flex-col sm:flex-row gap-3">
                            @csrf
                            <select name="project_id" id="timer-project" required
                                class="w-full sm:flex-1 min-w-0 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Select Project</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>

                            <select name="task_id" id="timer-task"
                                class="w-full sm:flex-1 min-w-0 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent hidden">
                                <option value="">No specific task (optional)</option>
                            </select>
                            <button type="submit"
                                class="w-full sm:w-auto px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Start Timer
                            </button>
                        </form>
                    </div>
                @endif

                <!-- Add Manual Entry -->
                <button onclick="openManualEntryModal()"
                    class="w-full sm:w-auto px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Manual Entry
                </button>

                <!-- Filter -->
                <button onclick="openFilterModal()"
                    class="w-full sm:w-auto px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filter
                </button>
            </div>
        </div>

        <!-- Time Logs Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold text-gray-800">Time Logs</h3>
                <p class="text-sm text-gray-500 mt-1">{{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} -
                    {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[760px] text-sm">
                    <thead>
                        <tr class="text-left text-gray-500 border-b bg-gray-50">
                            <th class="p-4 font-medium">PROJECT</th>
                            <th class="p-4 font-medium">TASK</th>
                            <th class="p-4 font-medium">START TIME</th>
                            <th class="p-4 font-medium">END TIME</th>
                            <th class="p-4 font-medium">DURATION</th>
                            <th class="p-4 font-medium">NOTES</th>
                            <th class="p-4 font-medium text-right">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($timeLogs as $log)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="p-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full"
                                            style="background-color: {{ $log->project->color }}"></div>
                                        <span class="font-medium text-gray-800">{{ $log->project->name }}</span>
                                    </div>
                                </td>
                                <td class="p-4 text-gray-600">
                                    {{ $log->task?->name ?? '-' }}
                                </td>
                                <td class="p-4 text-gray-600">
                                    {{ $log->start_time->format('d M Y, H:i') }}
                                </td>
                                <td class="p-4 text-gray-600">
                                    @if ($log->end_time)
                                        {{ $log->end_time->format('d M Y, H:i') }}
                                    @else
                                        <span class="text-green-600 font-medium">Running...</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <span class="font-semibold text-gray-800">
                                        {{ gmdate('H:i:s', $log->duration) }}
                                    </span>
                                </td>
                                <td class="p-4 text-gray-600 max-w-xs truncate">
                                    {{ $log->notes ?? '-' }}
                                </td>
                                <td class="p-4">
                                    <div class="flex items-center justify-end gap-2">
                                        @if ($log->end_time)
                                            <button type="button" onclick="editTimeLogFromButton(this)"
                                                data-url="{{ route('time-tracking.update', $log) }}"
                                                data-start-time="{{ $log->start_time->format('Y-m-d\TH:i') }}"
                                                data-end-time="{{ $log->end_time->format('Y-m-d\TH:i') }}"
                                                data-notes="{{ $log->notes }}"
                                                class="p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                        @endif
                                        <form action="{{ route('time-tracking.destroy', $log) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="p-2 text-gray-600 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors duration-200 delete-btn">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-12 text-center">
                                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-2">No time logs found</h3>
                                    <p class="text-gray-500">Start tracking your time on projects</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($timeLogs->hasPages())
                <div class="p-4 border-t">
                    {{ $timeLogs->links() }}
                </div>
            @endif
        </div>

        <!-- MODAL Manual Entry -->
        <div id="manualEntryModal"
            class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50">
            <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full mx-3 sm:mx-4 max-h-[90vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="p-4 sm:p-6 border-b bg-gradient-to-r from-blue-50 to-indigo-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800">Add Manual Time Entry</h3>
                            <p class="text-sm text-gray-600 mt-1">Record time spent on a project or task</p>
                        </div>
                        <button onclick="closeManualEntryModal()"
                            class="p-2 hover:bg-white rounded-lg transition-colors duration-200">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <form id="manualEntryForm" action="{{ route('time-tracking.store') }}" method="POST"
                    class="p-4 sm:p-6 space-y-6">
                    @csrf

                    <!-- Project Selection -->
                    <div>
                        <label for="manual-project" class="block text-sm font-medium text-gray-700 mb-2">
                            Project <span class="text-red-500">*</span>
                        </label>
                        <select name="project_id" id="manual-project" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Select Project</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Task Selection (Optional) -->
                    <div id="manual-task-wrapper" class="hidden">
                        <label for="manual-task" class="block text-sm font-medium text-gray-700 mb-2">
                            Task <span class="text-gray-400">(Optional)</span>
                        </label>
                        <select name="task_id" id="manual-task"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">No specific task</option>
                        </select>
                    </div>

                    <!-- Date & Time Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Start Time -->
                        <div>
                            <label for="manual-start" class="block text-sm font-medium text-gray-700 mb-2">
                                Start Time <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local" name="start_time" id="manual-start" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <!-- End Time -->
                        <div>
                            <label for="manual-end" class="block text-sm font-medium text-gray-700 mb-2">
                                End Time <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local" name="end_time" id="manual-end" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>

                    <!-- Duration Preview -->
                    <div id="duration-preview" class="hidden bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Total Duration</p>
                                <p class="text-xl font-bold text-gray-800" id="duration-text">0h 0m</p>
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="manual-notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Notes <span class="text-gray-400">(Optional)</span>
                        </label>
                        <textarea name="notes" id="manual-notes" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="What did you work on?"></textarea>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-end gap-3 pt-4 border-t">
                        <button type="button" onclick="closeManualEntryModal()"
                            class="w-full sm:w-auto px-6 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            Cancel
                        </button>
                        <button type="submit"
                            class="w-full sm:w-auto px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-sm">
                            Add Entry
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div id="filterModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50">
            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4">
                <div class="p-6 border-b">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold text-gray-800">Filter Time Logs</h3>
                        <button type="button" onclick="closeFilterModal()" class="p-2 hover:bg-gray-100 rounded-lg">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
                <form method="GET" action="{{ route('time-tracking.index') }}" class="p-4 sm:p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                        <input type="date" name="start_date" value="{{ $startDate }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                        <input type="date" name="end_date" value="{{ $endDate }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4 border-t">
                        <button type="button" onclick="closeFilterModal()"
                            class="w-full sm:w-auto px-5 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Cancel</button>
                        <button type="submit"
                            class="w-full sm:w-auto px-5 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700">Apply</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="editTimeLogModal"
            class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50">
            <div class="bg-white rounded-xl shadow-2xl max-w-xl w-full mx-4">
                <div class="p-6 border-b">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold text-gray-800">Edit Time Log</h3>
                        <button type="button" onclick="closeEditTimeLogModal()"
                            class="p-2 hover:bg-gray-100 rounded-lg">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
                <form id="editTimeLogForm" method="POST" class="p-4 sm:p-6 space-y-5">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Start Time</label>
                            <input type="datetime-local" name="start_time" id="edit-log-start" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">End Time</label>
                            <input type="datetime-local" name="end_time" id="edit-log-end" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                        <textarea name="notes" id="edit-log-notes" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                    </div>
                    <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4 border-t">
                        <button type="button" onclick="closeEditTimeLogModal()"
                            class="w-full sm:w-auto px-5 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Cancel</button>
                        <button type="submit"
                            class="w-full sm:w-auto px-5 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('form');
                Swal.fire({
                    title: 'Delete data?',
                    text: 'Data will be permanently deleted.',
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
        // ===== MODAL FUNCTIONS =====
        function openManualEntryModal() {
            const modal = document.getElementById('manualEntryModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            // Set default start time to now
            const now = new Date();
            const startInput = document.getElementById('manual-start');
            startInput.value = formatDateTimeLocal(now);

            // Set default end time to 1 hour from now
            const oneHourLater = new Date(now.getTime() + 60 * 60 * 1000);
            const endInput = document.getElementById('manual-end');
            endInput.value = formatDateTimeLocal(oneHourLater);

            // Trigger duration calculation
            calculateDuration();
        }

        function closeManualEntryModal() {
            const modal = document.getElementById('manualEntryModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');

            // Reset form
            document.getElementById('manualEntryForm').reset();
            document.getElementById('manual-task-wrapper').classList.add('hidden');
            document.getElementById('duration-preview').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('manualEntryModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeManualEntryModal();
            }
        });

        // Format date for datetime-local input
        function formatDateTimeLocal(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            return `${year}-${month}-${day}T${hours}:${minutes}`;
        }

        // Calculate duration between start and end time
        function calculateDuration() {
            const startInput = document.getElementById('manual-start');
            const endInput = document.getElementById('manual-end');
            const durationPreview = document.getElementById('duration-preview');
            const durationText = document.getElementById('duration-text');

            if (!startInput.value || !endInput.value) {
                durationPreview.classList.add('hidden');
                return;
            }

            const start = new Date(startInput.value);
            const end = new Date(endInput.value);

            if (end <= start) {
                durationPreview.classList.add('hidden');
                return;
            }

            const diff = end - start;
            const hours = Math.floor(diff / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));

            durationText.textContent = `${hours}h ${minutes}m`;
            durationPreview.classList.remove('hidden');
        }

        // Load tasks for manual entry
        const manualProjectSelect = document.getElementById('manual-project');
        if (manualProjectSelect) {
            manualProjectSelect.addEventListener('change', async (e) => {
                const projectId = e.target.value;
                const taskWrapper = document.getElementById('manual-task-wrapper');
                const taskSelect = document.getElementById('manual-task');

                if (!projectId) {
                    taskWrapper.classList.add('hidden');
                    taskSelect.innerHTML = '<option value="">No specific task</option>';
                    return;
                }

                try {
                    const response = await fetch(`/time-tracking/projects/${projectId}/tasks`);
                    const data = await response.json();

                    if (data.success && data.tasks.length > 0) {
                        taskSelect.innerHTML = '<option value="">No specific task</option>';
                        data.tasks.forEach(task => {
                            const option = document.createElement('option');
                            option.value = task.id;
                            option.textContent = task.name;
                            taskSelect.appendChild(option);
                        });
                        taskWrapper.classList.remove('hidden');
                    } else {
                        taskWrapper.classList.add('hidden');
                    }
                } catch (error) {
                    console.error('Failed to load tasks:', error);
                    taskWrapper.classList.add('hidden');
                }
            });
        }

        // Listen to time changes for duration calculation
        document.getElementById('manual-start')?.addEventListener('change', calculateDuration);
        document.getElementById('manual-end')?.addEventListener('change', calculateDuration);

        // ===== EXISTING CODE (tetap pakai yang sebelumnya) =====

        // Load tasks for timer
        const projectSelect = document.getElementById('timer-project');
        const taskSelect = document.getElementById('timer-task');

        if (projectSelect) {
            projectSelect.addEventListener('change', async (e) => {
                const projectId = e.target.value;

                if (!projectId) {
                    taskSelect.classList.add('hidden');
                    taskSelect.innerHTML = '<option value="">No specific task (optional)</option>';
                    return;
                }

                try {
                    const response = await fetch(`/time-tracking/projects/${projectId}/tasks`);
                    const data = await response.json();

                    if (data.success && data.tasks.length > 0) {
                        taskSelect.innerHTML = '<option value="">No specific task (optional)</option>';
                        data.tasks.forEach(task => {
                            const option = document.createElement('option');
                            option.value = task.id;
                            option.textContent = task.name;
                            taskSelect.appendChild(option);
                        });
                        taskSelect.classList.remove('hidden');
                    } else {
                        taskSelect.classList.add('hidden');
                    }
                } catch (error) {
                    console.error('Failed to load tasks:', error);
                    taskSelect.classList.add('hidden');
                }
            });
        }

        // Timer display
        @if ($activeTimer)
            const startTime = new Date('{{ $activeTimer->start_time }}').getTime();

            function updateTimer() {
                const now = new Date().getTime();
                const diff = now - startTime;

                const hours = Math.floor(diff / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                document.getElementById('timer-display').textContent =
                    String(hours).padStart(2, '0') + ':' +
                    String(minutes).padStart(2, '0') + ':' +
                    String(seconds).padStart(2, '0');
            }

            updateTimer();
            setInterval(updateTimer, 1000);
        @endif

        // Start timer
        document.getElementById('start-timer-form')?.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);

            try {
                const response = await fetch('{{ route('time-tracking.start') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.message);
                }
            } catch (error) {
                alert('Failed to start timer');
            }
        });

        // Stop timer
        async function stopTimer(id) {
            if (!confirm('Stop this timer?')) return;

            try {
                const response = await fetch(`/time-tracking/${id}/stop`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    }
                });

                const data = await response.json();

                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.message);
                }
            } catch (error) {
                alert('Failed to stop timer');
            }
        }

        function openFilterModal() {
            const modal = document.getElementById('filterModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeFilterModal() {
            const modal = document.getElementById('filterModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function editTimeLog(log) {
            const modal = document.getElementById('editTimeLogModal');
            document.getElementById('editTimeLogForm').action = log.url;
            document.getElementById('edit-log-start').value = log.start_time;
            document.getElementById('edit-log-end').value = log.end_time;
            document.getElementById('edit-log-notes').value = log.notes ?? '';
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function editTimeLogFromButton(button) {
            editTimeLog({
                url: button.dataset.url,
                start_time: button.dataset.startTime,
                end_time: button.dataset.endTime,
                notes: button.dataset.notes
            });
        }

        function closeEditTimeLogModal() {
            const modal = document.getElementById('editTimeLogModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</x-app-layout>
