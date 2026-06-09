<!-- Task Card -->
<div
    class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow cursor-pointer border-l-4

    {{ $task->status === 'pending' ? 'border-gray-500' : '' }}
    {{ $task->status === 'in_progress' ? 'border-yellow-500' : '' }}
    {{ $task->status === 'done' ? 'border-green-500 opacity-75' : '' }}

    ">
    <div class="flex items-start justify-between mb-2">
        <h4
            class="{{ $task->status === 'done' ? 'font-semibold text-gray-800 text-sm line-through' : 'font-semibold text-gray-800 text-sm' }}">
            {{ $task->title }}</h4>

        @if ($task->status === 'done')
            <span
                class="px-2 py-0.5 bg-green-100 text-green-700 text-xs font-semibold rounded">{{ $task->status === 'done' ? 'Comleted' : '' }}</span>
        @endif
    </div>
    <p class="text-xs text-gray-600 mb-3">{{ $task->project->name }}</p>
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2 text-xs text-gray-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            {{ $task->due_date?->format('M d') }}
        </div>
        <div class="flex items-center gap-2">
            @if ($task->status === 'done')
                <div class="flex items-center gap-2 text-xs text-green-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Completed
                </div>
            @endif
            <button type="button"
                onclick="openTaskModalFromButton(this)"
                data-url="{{ route('tasks.update', $task) }}"
                data-title="{{ $task->title }}"
                data-description="{{ $task->description }}"
                data-project-id="{{ $task->project_id }}"
                data-status="{{ $task->status }}"
                data-due-date="{{ $task->due_date?->format('Y-m-d') }}"
                class="text-blue-600 hover:text-blue-800">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </button>
            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline delete-task-form">
                @csrf
                @method('DELETE')
                <button type="button" class="delete-task-btn text-red-600 hover:text-red-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </form>
        </div>
        {{-- <div class="flex items-center gap-1">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
            </svg>
            <span class="text-xs text-gray-500">3</span>
        </div> --}}
    </div>
</div>
