<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>

    <!-- HEADER -->
    <div class="bg-white rounded-lg p-4 md:p-6 mb-6 text-gray-600 shadow-md">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">Tasks Management</h1>
                <p class="text-gray-600">Organize and track all your tasks in one place</p>
            </div>
            <button onclick="openTaskModal()"
                class="inline-flex w-full sm:w-auto items-center justify-center bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:from-blue-700 hover:to-indigo-700 transition-all shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add New Task
            </button>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-600">All Tasks</span>
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['all'] }}</p>
            </div>

            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-600">In Progress</span>
                    <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['in_progress'] }}</p>
            </div>

            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-600">Completed</span>
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['done'] }}</p>
            </div>

            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-600">Overdue</span>
                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['overdue'] }}</p>
            </div>
        </div>
    </div>
    <!-- FILTERS & SEARCH -->
    <div class="bg-white rounded-xl shadow-sm p-4 mb-6 border border-gray-100">
        <form id="taskFilterForm" method="GET" action="{{ route('tasks.index') }}"
            class="flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1 min-w-0">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search tasks..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>

            <!-- Filter by Status -->
            <select name="status"
                class="w-full md:w-auto px-4 py-2 sm:px-5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">All Status</option>
                <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                <option value="in_progress" @selected(request('status') === 'in_progress')>In Progress</option>
                <option value="done" @selected(request('status') === 'done')>Completed</option>
                <option value="overdue" @selected(request('status') === 'overdue')>Overdue</option>
            </select>
            <!-- Filter by Project -->
            <select name="project_id"
                class="w-full md:w-auto px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">All Projects</option>
                @foreach ($projects as $project)
                    <option value="{{ $project->id }}" @selected((string) request('project_id') === (string) $project->id)>
                        {{ $project->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit"
                class="w-full md:w-auto px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700">Filter</button>
            <a href="{{ route('tasks.index') }}"
                class="w-full md:w-auto px-4 py-2 border border-gray-300 rounded-lg text-gray-600 font-medium hover:bg-gray-50 text-center">Reset</a>
        </form>
    </div>

    <!-- VIEW TOGGLE -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <div class="flex items-center gap-2 bg-white rounded-lg p-1 shadow-sm border border-gray-100">
            <button onclick="switchView('kanban')" id="kanbanBtn"
                class="px-4 py-2 rounded-md bg-gradient-to-r from-blue-600 to-blue-600 text-white font-medium transition-all">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" />
                    </svg>
                    Kanban
                </span>
            </button>
            <button onclick="switchView('list')" id="listBtn"
                class="px-4 py-2 rounded-md text-gray-600 hover:bg-gray-100 font-medium transition-all">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    List
                </span>
            </button>
        </div>

        <div class="flex items-center gap-2 text-sm text-gray-600 w-full sm:w-auto">
            <span>Sort by:</span>
            <select name="sort" form="taskFilterForm"
                onchange="document.getElementById('taskFilterForm').submit()"
                class="w-full sm:w-auto px-3 py-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                <option value="due_date" @selected(request('sort', 'due_date') === 'due_date')>Due Date</option>
                <option value="status" @selected(request('sort') === 'status')>Status</option>
                <option value="title" @selected(request('sort') === 'title')>Name</option>
                <option value="created_at" @selected(request('sort') === 'created_at')>Created Date</option>
            </select>
        </div>
    </div>

    <!-- KANBAN VIEW -->
    <div id="kanbanView" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
        <!-- PENDING Column -->
        <div class="bg-gray-100 rounded-xl p-4">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-800 flex items-center gap-2">
                    <span class="w-3 h-3 bg-gray-400 rounded-full"></span>
                    Pending
                    <span
                        class="text-xs bg-gray-200 px-2 py-0.5 rounded-full">{{ $kanban['pending']->count() }}</span>
                </h3>
                <button class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                    </svg>
                </button>
            </div>
            <div class="space-y-3">
                @foreach ($kanban['pending'] as $task)
                    <!-- Task Card -->
                    @include('tasks.partials.card', ['task' => $task])
                @endforeach
                {{--
                <div
                    class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow cursor-pointer border-l-4 border-yellow-500">
                    <div class="flex items-start justify-between mb-2">
                        <h4 class="font-semibold text-gray-800 text-sm">Research competitors</h4>
                        <span
                            class="px-2 py-0.5 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded">Medium</span>
                    </div>
                    <p class="text-xs text-gray-600 mb-3">Mobile App Project</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" <path stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Dec 30
                        </div>
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                            </svg>
                            <span class="text-xs text-gray-500">1</span>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow cursor-pointer border-l-4 border-green-500">
                    <div class="flex items-start justify-between mb-2">
                        <h4 class="font-semibold text-gray-800 text-sm">Write project proposal</h4>
                        <span class="px-2 py-0.5 bg-green-100 text-green-700 text-xs font-semibold rounded">Low</span>
                    </div>
                    <p class="text-xs text-gray-600 mb-3">E-Commerce Project</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Jan 05
                        </div>
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                            </svg>
                            <span class="text-xs text-gray-500">0</span>
                        </div>
                    </div>
                </div> --}}
            </div>
            {{-- <button
                class="w-full mt-4 py-2 text-gray-500 hover:text-gray-700 hover:bg-gray-200 rounded-lg transition-colors text-sm flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Task
            </button> --}}
        </div>

        <!-- IN PROGRESS Column -->
        <div class="bg-gray-100 rounded-xl p-4">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-800 flex items-center gap-2">
                    <span class="w-3 h-3 bg-amber-400 rounded-full"></span>
                    In Progress
                    <span
                        class="text-xs bg-gray-200 px-2 py-0.5 rounded-full">{{ $kanban['in_progress']->count() }}</span>
                </h3>
                <button class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                    </svg>
                </button>
            </div>
            <div class="space-y-3">
                @foreach ($kanban['in_progress'] as $task)
                    <!-- Task Card -->
                    @include('tasks.partials.card', ['task' => $task])
                @endforeach
                {{--
                <div
                    class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow cursor-pointer border-l-4 border-yellow-500">
                    <div class="flex items-start justify-between mb-2">
                        <h4 class="font-semibold text-gray-800 text-sm">Design mobile app UI</h4>
                        <span
                            class="px-2 py-0.5 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded">Medium</span>
                    </div>
                    <p class="text-xs text-gray-600 mb-3">Mobile App Project</p>
                    <div class="flex items-center gap-2 mb-3">
                        <div class="flex -space-x-2">
                            <div class="w-6 h-6 rounded-full bg-blue-500 border-2 border-white"></div>
                            <div class="w-6 h-6 rounded-full bg-green-500 border-2 border-white"></div>
                            <div
                                class="w-6 h-6 rounded-full bg-purple-500 border-2 border-white flex items-center justify-center text-white text-xs">
                                +1</div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Jan 02
                        </div>
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                            </svg>
                            <span class="text-xs text-gray-500">8</span>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>

        <!-- COMPLETED Column -->
        <div class="bg-gray-100 rounded-xl p-4">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-800 flex items-center gap-2">
                    <span class="w-3 h-3 bg-green-400 rounded-full"></span>
                    Completed
                    <span class="text-xs bg-gray-200 px-2 py-0.5 rounded-full">{{ $kanban['done']->count() }}</span>
                </h3>
                <button class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                    </svg>
                </button>
            </div>
            <div class="space-y-3">
                @foreach ($kanban['done'] as $task)
                    <!-- Task Card -->
                    @include('tasks.partials.card', ['task' => $task])
                @endforeach
            </div>
        </div>

        <!-- OVERDUE Column -->
        <div class="bg-gray-100 rounded-xl p-4">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-800 flex items-center gap-2">
                    <span class="w-3 h-3 bg-red-400 rounded-full"></span>
                    Overdue
                    <span
                        class="text-xs bg-gray-200 px-2 py-0.5 rounded-full">{{ $kanban['overdue']->count() }}</span>
                </h3>
                <button class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                    </svg>
                </button>
            </div>
            <div class="space-y-3">
                @foreach ($kanban['overdue'] as $task)
                    <!-- Task Card -->
                    {{-- @include('tasks.partials.card', ['task' => $task]) --}}
                    <div
                        class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow cursor-pointer border-l-4 border-red-500">
                        <div class="flex items-start justify-between mb-2">
                            <h4 class="font-semibold text-gray-800 text-sm">{{ $task->title }}</h4>
                            <span
                                class="px-2 py-0.5 bg-red-100 text-red-700 text-xs font-semibold rounded">Overdue</span>
                        </div>
                        <p class="text-xs text-gray-600 mb-3">{{ $task->project->name }}</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2 text-xs text-red-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $task->due_date?->format('M d') }}
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

    <!-- LIST VIEW (hidden by default) -->
    <div id="listView" class="hidden">
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
            <table class="w-full min-w-[700px]">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Task</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Project</th>
                        {{-- <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Priority</th> --}}
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Due Date</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($tasks as $task)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <input type="checkbox" class="rounded border-gray-300 text-blue-600 mr-3">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">{{ $task->title }}
                                        </h4>
                                        <p class="text-xs text-gray-600 mt-1">{{ $task->description }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold">{{ $task->project->name }}</span>
                            </td>
                            {{-- <td class="px-6 py-4">
                                <span
                                    class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">High</span>
                            </td> --}}
                            <td class="px-6 py-4 text-gray-700">{{ $task->due_date?->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-3 py-1
                                    {{ $task->status === 'pending' ? 'bg-gray-100 text-gray-700' : '' }}
                                    {{ $task->status === 'in_progress' ? 'bg-amber-100 text-amber-700' : '' }}
                                    {{ $task->status === 'done' ? 'bg-green-100 text-green-700' : '' }}
                                    rounded-full text-xs font-semibold">{{ $task->status }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <button type="button" onclick="openTaskModalFromButton(this)"
                                        data-url="{{ route('tasks.update', $task) }}"
                                        data-title="{{ $task->title }}" data-description="{{ $task->description }}"
                                        data-project-id="{{ $task->project_id }}" data-status="{{ $task->status }}"
                                        data-due-date="{{ $task->due_date?->format('Y-m-d') }}"
                                        class="text-blue-600 hover:text-blue-800 p-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                                        class="inline delete-task-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="delete-task-btn text-red-600 hover:text-red-800 p-1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                                {{-- <button class="text-gray-400 hover:text-gray-600 p-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                    </svg>
                                </button> --}}
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
    <!-- PAGINATION -->
    @if ($tasks->hasPages())
        <div class="mt-8">
            {{ $tasks->links() }}
        </div>
    @endif

    <div id="addTaskModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b">
                    <div class="flex items-center justify-between">
                        <h3 id="taskModalTitle" class="text-lg font-semibold text-gray-800">Add New Task</h3>
                        <button onclick="closeAddTaskModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div>
                    <form id="taskForm" class="p-6 space-y-2" method="POST" action="{{ route('tasks.store') }}">
                        @csrf
                        <input type="hidden" name="_method" id="taskMethod" value="POST">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Task Title</label>
                            <input type="text" name="title" id="taskTitle"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter task title">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                            <textarea name="description" id="taskDescription"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                rows="3" placeholder="Enter task description"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Project</label>
                            <select name="project_id" id="taskProject"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Select Project</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Priority</label>
                                <select
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option>Low</option>
                                    <option>Medium</option>
                                    <option>High</option>
                                </select>
                            </div>
                        </div> --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Due Date</label>
                                <input type="date" name="due_date" id="taskDueDate"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                                <select name="status" id="taskStatus"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="pending" {{ old('status' == 'pending' ? 'selected' : '') }}>Pending
                                    </option>
                                    <option value="in_progress"
                                        {{ old('status' == 'in_progress' ? 'selected' : '') }}>
                                        In_progress
                                    </option>
                                    <option value="done" {{ old('status' == 'done' ? 'selected' : '') }}>
                                        Done
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div
                            class="p-4 sm:p-6 border-t border-gray-200 flex flex-col sm:flex-row justify-center gap-3">
                            <button type="button" onclick="closeAddTaskModal()"
                                class="w-full sm:w-auto px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50">Cancel</button>
                            <button type="submit"
                                class="w-full sm:w-auto px-6 py-3 bg-blue-600  text-white rounded-lg font-semibold hover:from-blue-700 hover:to-indigo-700">Create
                                Task</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        {{-- <script src="{{ asset('js/tasks.js') }}"></script> --}}
        <script>
            // Sidebar Toggle
            function toggleSidebar() {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('overlay');

                if (sidebar.classList.contains('-translate-x-full')) {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('hidden');
                } else {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                }
            }

            // View Toggle
            function switchView(view) {
                const kanbanView = document.getElementById('kanbanView');
                const listView = document.getElementById('listView');
                const kanbanBtn = document.getElementById('kanbanBtn');
                const listBtn = document.getElementById('listBtn');

                if (view === 'kanban') {
                    kanbanView.classList.remove('hidden');
                    listView.classList.add('hidden');
                    kanbanBtn.classList.add('bg-gradient-to-r', 'from-blue-600', 'to-blue-600', 'text-white');
                    kanbanBtn.classList.remove('text-gray-600', 'hover:bg-gray-100');
                    listBtn.classList.remove('bg-gradient-to-r', 'from-blue-600', 'to-blue-600', 'text-white');
                    listBtn.classList.add('text-gray-600', 'hover:bg-gray-100');
                } else {
                    kanbanView.classList.add('hidden');
                    listView.classList.remove('hidden');
                    listBtn.classList.add('bg-gradient-to-r', 'from-blue-600', 'to-blue-600', 'text-white');
                    listBtn.classList.remove('text-gray-600', 'hover:bg-gray-100');
                    kanbanBtn.classList.remove('bg-gradient-to-r', 'from-blue-600', 'to-blue-600', 'text-white');
                    kanbanBtn.classList.add('text-gray-600', 'hover:bg-gray-100');
                }
            }

            function openTaskModal(task = null) {
                const modal = document.getElementById('addTaskModal');
                const form = document.getElementById('taskForm');

                document.getElementById('taskModalTitle').textContent = task ? 'Edit Task' : 'Add New Task';
                form.action = task ? task.url : '{{ route('tasks.store') }}';
                document.getElementById('taskMethod').value = task ? 'PUT' : 'POST';
                document.getElementById('taskTitle').value = task?.title ?? '';
                document.getElementById('taskDescription').value = task?.description ?? '';
                document.getElementById('taskProject').value = task?.project_id ?? '';
                document.getElementById('taskDueDate').value = task?.due_date ?? '';
                document.getElementById('taskStatus').value = task?.status ?? 'pending';

                modal.classList.remove('hidden');
            }

            function openAddTaskModal() {
                openTaskModal();
            }

            function openTaskModalFromButton(button) {
                openTaskModal({
                    url: button.dataset.url,
                    title: button.dataset.title,
                    description: button.dataset.description,
                    project_id: button.dataset.projectId,
                    status: button.dataset.status,
                    due_date: button.dataset.dueDate,
                });
            }

            function closeAddTaskModal() {
                document.getElementById('addTaskModal').classList.add('hidden');
                document.getElementById('taskForm').reset();
            }

            // Close modal when clicking outside
            document.getElementById('addTaskModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeAddTaskModal();
                }
            });

            // Initialize kanban as default view
            document.addEventListener('DOMContentLoaded', function() {
                switchView('kanban');
            });

            document.querySelectorAll('.delete-task-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');
                    Swal.fire({
                        title: 'Delete task?',
                        text: 'This task will be permanently deleted.',
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
