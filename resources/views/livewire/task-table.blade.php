{{-- resources/views/livewire/tasks/task-list.blade.php --}}
<div>
    <!-- HEADER -->
    <div class="bg-white rounded-lg p-4 md:p-6 mb-6 text-gray-600 shadow-md">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">Tasks Management</h1>
                <p class="text-gray-600">Organize and track all your tasks in one place</p>
            </div>
            <a href="{{ route('tasks.create') }}"
                class="inline-flex items-center justify-center bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-all shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add New Task
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <!-- Stat cards tetap sama -->
            <!-- ... -->
        </div>
    </div>

    <!-- FILTERS & SEARCH -->
    <div class="bg-white rounded-xl shadow-sm p-4 mb-6 border border-gray-100">
        <div class="flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input wire:model="search" type="text" placeholder="Search tasks..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>

            <!-- Filter by Status -->
            <select wire:model="statusFilter"
                class="px-4 py-2 sm:px-5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">All Status</option>
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="done">Completed</option>
                <option value="overdue">Overdue</option>
            </select>

            <!-- Filter by Project -->
            <select wire:model="projectFilter"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">All Projects</option>
                @foreach ($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endforeach
            </select>

            <!-- Filter by Priority -->
            <select wire:model="priorityFilter"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">All Priority</option>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>
        </div>

        <!-- Per Page Selector -->
        <div class="mt-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-600">Show:</span>
                <select wire:model="perPage" class="px-7 py-1 border border-gray-300 rounded text-sm">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                <span class="text-sm text-gray-600">per page</span>
            </div>
        </div>
    </div>

    <!-- VIEW TOGGLE -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-2 bg-white rounded-lg p-1 shadow-sm border border-gray-100">
            <button wire:click="switchView('kanban')"
                class="px-4 py-2 rounded-md {{ $viewMode === 'kanban' ? 'bg-gradient-to-r from-blue-600 to-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }} font-medium transition-all">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" />
                    </svg>
                    Kanban
                </span>
            </button>
            <button wire:click="switchView('list')"
                class="px-4 py-2 rounded-md {{ $viewMode === 'list' ? 'bg-gradient-to-r from-blue-600 to-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }} font-medium transition-all">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    List
                </span>
            </button>
        </div>

        <div class="flex items-center gap-2 text-sm text-gray-600">
            <span>Sort by:</span>
            <select wire:model="sortBy"
                class="px-3 py-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                <option value="due_date">Due Date</option>
                <option value="priority">Priority</option>
                <option value="title">Name</option>
                <option value="created_at">Created Date</option>
            </select>
            <button wire:click="$refresh" class="text-gray-400 hover:text-gray-600" title="Refresh">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
            </button>
        </div>
    </div>
    <!-- KANBAN VIEW -->
    @if ($viewMode === 'kanban')
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach (['pending', 'in_progress', 'done', 'overdue'] as $status)
                @php
                    $kanbanData = $this->kanbanTasks; // Akses computed property
                    $statusData = [
                        'pending' => [
                            'title' => 'Pending',
                            'color' => 'gray',
                            'count' => count($kanbanData['pending']),
                        ],
                        'in_progress' => [
                            'title' => 'In Progress',
                            'color' => 'amber',
                            'count' => count($kanbanData['in_progress']),
                        ],
                        'done' => ['title' => 'Completed', 'color' => 'green', 'count' => count($kanbanData['done'])],
                        'overdue' => ['title' => 'Overdue', 'color' => 'red', 'count' => count($kanbanData['overdue'])],
                    ];
                @endphp

                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-800 flex items-center gap-2">
                            <span class="w-3 h-3 bg-{{ $statusData[$status]['color'] }}-400 rounded-full"></span>
                            {{ $statusData[$status]['title'] }}
                            <span class="text-xs bg-gray-200 px-2 py-0.5 rounded-full">
                                {{ $statusData[$status]['count'] }}
                            </span>
                        </h3>
                    </div>

                    <div class="space-y-3">
                        @foreach ($kanbanData[$status] as $task)
                            <div
                                class="bg-white p-4 rounded-none shadow-sm hover:shadow-md transition-shadow cursor-pointer border-l-4 border-{{ $statusData[$status]['color'] }}-500">
                                <div class="flex items-start justify-between mb-2">
                                    <h4 class="font-semibold text-gray-800 text-sm">{{ $task->title }}</h4>
                                    <span
                                        class="px-2 py-0.5 bg-{{ $statusData[$status]['color'] }}-100 text-{{ $statusData[$status]['color'] }}-700 text-xs font-semibold rounded">
                                        {{ $status === 'overdue' ? 'Overdue' : ucfirst($task->priority) }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-600 mb-2">{{ $task->project->name ?? 'No Project' }}</p>
                                <div class="flex items-center justify-between text-xs text-gray-500">
                                    <span>{{ $task->due_date?->format('M d') ?? 'No due date' }}</span>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('tasks.edit', $task) }}"
                                            class="text-blue-600 hover:text-blue-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- LIST VIEW -->
    @if ($viewMode === 'list')
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <button wire:click="sortBy('title')" class="flex items-center gap-1">
                                Task
                            </button>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Project
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <button wire:click="sortBy('priority')" class="flex items-center gap-1">
                                Priority
                            </button>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <button wire:click="sortBy('due_date')" class="flex items-center gap-1">
                                Due Date
                            </button>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($tasks as $task)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">{{ $task->title }}</h4>
                                        <p class="text-xs text-gray-600 mt-1">{{ Str::limit($task->description, 50) }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold">{{ $task->project->name ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-3 py-1 text-xs font-semibold rounded-full
                                    {{ $task->priority === 'high' ? 'bg-red-100 text-red-700' : '' }}
                                    {{ $task->priority === 'medium' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ $task->priority === 'low' ? 'bg-green-100 text-green-700' : '' }}">
                                    {{ ucfirst($task->priority) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-700">
                                {{ $task->due_date?->format('M d, Y') ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-3 py-1 text-xs font-semibold rounded-full
                                    {{ $task->status === 'pending' ? 'bg-gray-100 text-gray-700' : '' }}
                                    {{ $task->status === 'in_progress' ? 'bg-amber-100 text-amber-700' : '' }}
                                    {{ $task->status === 'done' ? 'bg-green-100 text-green-700' : '' }}">
                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('tasks.edit', $task) }}"
                                        class="text-blue-600 hover:text-blue-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure?')"
                                            class="text-red-600 hover:text-red-800">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
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
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                No tasks found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        @if ($tasks->hasPages())
            <div class="mt-8">
                {{ $tasks->links() }}
            </div>
        @endif
    @endif
</div>
