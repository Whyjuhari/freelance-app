<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Project') }}
        </h2>
    </x-slot>
    <!-- PROJECT DETAIL MAIN CONTENT -->
    <div class="p-0 sm:p-4 md:p-6 min-w-0">
        <!-- HEADER -->
        <div class="mb-6">
            <!-- Breadcrumb -->
            <nav class="flex flex-wrap items-center gap-2 text-sm text-gray-600 mb-4">
                <a href="{{ route('dashboard') }}" class="hover:text-blue-600">Dashboard</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <a href="{{ route('projects.index') }}" class="hover:text-blue-600">Projects</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-gray-800 font-medium">{{ $project->name }}</span>
            </nav>

            <!-- Project Header -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
                @if (session('success'))
                    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
                    <div class="flex items-start gap-4 min-w-0">
                        <div
                            class="w-16 h-16 bg-blue-500 rounded-xl flex items-center justify-center text-white font-bold text-2xl flex-shrink-0">
                            {{ $project->initial }}
                        </div>
                        <div class="min-w-0">
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2 break-words">{{ $project->name }}</h1>
                            <div class="flex flex-wrap items-center gap-3">
                                <span
                                    class="px-3 py-1 text-xs font-semibold {{ $project->status_color }} rounded-full">{{ ucfirst($project->status) }}</span>
                                @if ($project->is_urgent)
                                    <span
                                        class="px-3 py-1 text-xs font-semibold bg-red-100 text-red-700 rounded-full">High
                                        Priority</span>
                                @endif
                                <span class="text-sm text-gray-600">Created :
                                    {{ $project->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:flex-wrap items-stretch sm:items-center gap-3 w-full lg:w-auto">
                        <a href="{{ route('projects.edit', $project) }}"
                            class="inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Project
                        </a>
                        @if ($project->status !== 'completed')
                            <button id="completeProjectBtn"
                                class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all shadow-lg">

                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Mark as Complete
                            </button>
                        @else
                            <!-- Tombol/status jika sudah completed -->
                            <span
                                class="inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-lg shadow-lg cursor-default">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Completed
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg p-4 shadow-lg">
                        <div class="flex items-center gap-2 text-blue-600 mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-xs font-semibold uppercase">Progress</span>
                        </div>
                        <p class="text-2xl font-bold text-gray-800">{{ $project->progress }}%</p>
                    </div>

                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg p-4 shadow-lg">
                        <div class="flex items-center gap-2 text-green-600 mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-xs font-semibold uppercase">Budget</span>
                        </div>
                        <p class="text-xl md:text-2xl font-bold text-gray-800 break-words">Rp {{ number_format($project->budget) }}</p>
                    </div>

                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-lg p-4 shadow-lg">
                        <div class="flex items-center gap-2 text-purple-600 mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            <span class="text-xs font-semibold uppercase">Tasks</span>
                        </div>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ $project->completed_tasks }}/{{ $project->total_task }}</p>
                    </div>

                    <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-lg p-4 shadow-lg">
                        <div class="flex items-center gap-2 text-amber-600 mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-xs font-semibold uppercase">Deadline</span>
                        </div>
                        <p class="text-lg font-bold text-gray-800">
                            {{ $project->deadline?->format('d M Y') ?? '_' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- MAIN CONTENT GRID -->
        <div class="grid lg:grid-cols-3 gap-6">

            <!-- LEFT COLUMN (2/3) -->
            <div class="lg:col-span-2 space-y-6">

                <!-- PROJECT OVERVIEW -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Project Description
                    </h2>
                    <div class="prose max-w-none text-gray-600">
                        <p class="mb-4">
                            {{ $project->description }}
                        </p>
                        {{-- <h3 class="text-lg font-semibold text-gray-800 mb-2">Key Deliverables:</h3>
                        <ul class="list-disc list-inside space-y-2">
                            <li>Homepage design with hero section and key features</li>
                            <li>Services page with detailed descriptions</li>
                            <li>Portfolio/Case studies section</li>
                            <li>About us and team page</li>
                            <li>Contact form with map integration</li>
                            <li>Responsive design for all devices</li>
                        </ul> --}}
                    </div>
                </div>

                <!-- TASKS LIST -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
                    <div class="flex items-center justify-between gap-3 mb-4">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                            Tasks ({{ $project->completed_tasks }}/{{ $project->total_task }})
                        </h2>
                        {{-- <a href="#"
                            class="text-sm text-blue-600 hover:text-blue-700 font-medium flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Add Task
                        </a> --}}
                    </div>

                    <div class="space-y-3">
                        @foreach ($project->tasks as $task)
                            <!-- Task Item 1 - Completed -->
                            <div
                                class="flex items-start gap-3 p-3 rounded-lg {{ $task->status === 'done' ? ' bg-gray-50' : 'border-2 border-blue-200 bg-blue-50' }}">
                                <input type="checkbox"
                                    class="task-checkbox w-5 h-5 mt-0.5 {{ $task->status === 'done' ? 'text-green-600 border-gray-300 rounded focus:ring-green-500' : 'text-blue-600 border-gray-300 rounded focus:ring-blue-500' }}"
                                    data-id="{{ $task->id }}" {{ $task->status === 'done' ? 'checked' : '' }}>


                                <div class="flex-1">
                                    <p
                                        class="{{ $task->status === 'done' ? 'text-gray-500 line-through' : 'text-gray-800 font-medium' }}">
                                        {{ $task->title }}</p>
                                    <div class="flex items-center gap-3 mt-1 text-xs text-gray-500">
                                        @if ($task->status === 'done' && $task->completed_at)
                                            <span>{{ $task->completed_at ? $task->completed_at->format('d M Y') : '_' }}</span>
                                        @elseif($task->status === 'in_progress')
                                            <span
                                                class="px-2 py-0.5 bg-amber-100 text-amber-700 rounded font-semibold">{{ $task->status }}</span>
                                        @elseif($task->due_date)
                                            <span>
                                                Due: {{ $task->due_date->format('M d') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>

                    <a href="{{ route('tasks.index') }}"
                        class="mt-6 text-sm text-gray-600 hover:text-blue-600 py-2 border-t">
                        View All Tasks ({{ $project->total_task }})
                    </a>
                </div>


            </div>

            <!-- RIGHT COLUMN (1/3) -->
            <div class="space-y-6">

                <!-- CLIENT INFO -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Client Information
                    </h3>
                    <div class="flex items-center gap-3 mb-4 p-3 bg-gray-50 rounded-lg">
                        <div
                            class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-indigo-500 flex items-center justify-center text-white font-bold">
                            {{ $project->client?->initial ?? '?' }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">User Biasa</p>
                            <p class="text-sm text-gray-500">{{ $project->client?->name ?? '_' }}</p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>{{ $project->client?->alamat_email ?? '_' }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span>{{ $project->client?->formatted_phone ?? '_' }}</span>
                        </div>
                    </div>
                    <button
                        class="w-full mt-4 px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors text-sm font-medium">
                        Contact Client
                    </button>
                </div>

                <!-- PROJECT DETAILS -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Project Details
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase">Start Date</label>
                            <p class="text-sm text-gray-800 mt-1">{{ $project->created_at->format('F d, Y') }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase">End Date</label>
                            <p class="text-sm text-gray-800 mt-1"> {{ $project->deadline?->format('F d, Y') ?? '-' }}
                            </p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase">Duration</label>
                            <p class="text-sm text-gray-800 mt-1">{{ $project->duration }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase">Category</label>
                            <p class="text-sm text-gray-800 mt-1">{{ $project->category }}</p>
                        </div>

                    </div>
                </div>


            </div>

        </div>

        <!-- Confirm Complete Modal -->
        <div id="confirmCompleteModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">

            <div class="bg-white rounded-xl w-full max-w-md p-6 shadow-xl">
                <h2 class="text-xl font-bold text-gray-800 mb-2">
                    Mark project as completed?
                </h2>

                <p class="text-gray-600 mb-6">
                    This action will set project status to <b>completed</b> and progress to 100%.
                </p>

                <div class="flex justify-end gap-3">
                    <button id="cancelComplete"
                        class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">
                        Cancel
                    </button>

                    <button id="confirmComplete"
                        class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                        Yes, Complete
                    </button>
                </div>
            </div>
        </div>
    </div>


    {{-- @push('script')
    @endpush --}}
    <!-- SCRIPTS (Optional - for interactions) -->
    <script>
        // Toggle task completion
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const taskText = this.nextElementSibling.querySelector('p');
                if (this.checked) {
                    taskText.classList.add('line-through', 'text-gray-500');
                    taskText.classList.remove('text-gray-800');
                } else {
                    taskText.classList.remove('line-through', 'text-gray-500');
                    taskText.classList.add('text-gray-800');
                }
            });
        });

        // update tabel task
        document.querySelectorAll('.task-checkbox').forEach(st => {
            st.addEventListener('change', function() {
                fetch(`/tasks/${this.dataset.id}/toggle`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                }).then(() => location.reload())
            })
        })

        // untuk mark as comleted
        document.getElementById('completeProjectBtn')?.addEventListener('click', () => {
            document.getElementById('confirmCompleteModal').classList.remove('hidden')
            document.getElementById('confirmCompleteModal').classList.add('flex')
        })

        document.getElementById('cancelComplete')?.addEventListener('click', () => {
            document.getElementById('confirmCompleteModal').classList.add('hidden')
        })

        document.getElementById('confirmComplete')?.addEventListener('click', () => {
            fetch('{{ route('projects.complete', $project) }}', {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(() => location.reload())
        })
    </script>
</x-app-layout>
