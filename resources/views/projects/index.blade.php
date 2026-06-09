<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Projects') }}
        </h2>
    </x-slot>

    <!-- HEADER BANNER -->
    <div class="bg-white rounded-lg p-4 md:p-6 mb-6 text-gray-600 shadow-xl">
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4 min-w-0">
            <div class="flex items-center gap-3 md:gap-4 min-w-0">
                <div
                    class="w-12 h-12 md:w-14 md:h-14 bg-blue-600 bg-opacity-20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <h1 class="text-xl md:text-2xl font-bold break-words">Manage Your Projects</h1>
                    <p class="text-gray-500 text-opacity-90 text-xs md:text-base">Manage all your freelance projects in
                        one place</p>
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-2 md:gap-3 w-full lg:w-auto">
                <button onclick="showAddProjectModal()"
                    class="w-full sm:w-auto bg-gray-300 text-blue-600 hover:bg-gray-400 px-3 md:px-4 py-2 md:py-2.5 rounded-md font-semibold text-xs md:text-sm flex items-center justify-center gap-2 transition-colors duration-200">
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Project
                </button>
                <div
                    class="bg-blue-600 bg-opacity-20 px-2 md:px-4 py-1 md:py-2 rounded-md flex items-center gap-1 md:gap-2">
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="font-semibold text-xs">{{ now()->format('d M Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- FILTER & SEARCH -->
    <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 mb-6 border border-gray-200">
        <form method="GET" action="{{ route('projects.index') }}" class="flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1 min-w-0">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search projects, clients, or keywords..."
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>

            <!-- Filters -->
            <div class="flex flex-col sm:flex-row sm:flex-wrap gap-3 w-full md:w-auto">
                <select name="status"
                    class="w-full sm:w-auto text-sm border border-gray-300 rounded-lg px-4 sm:px-8 py-3 text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-none cursor-pointer">
                    <option value="">All Statuses</option>
                    <option value="planning" @selected(request('status') === 'planning')>Planning</option>
                    <option value="active" @selected(request('status') === 'active')>Active</option>
                    <option value="completed" @selected(request('status') === 'completed')>Completed</option>
                    <option value="on_hold" @selected(request('status') === 'on_hold')>On Hold</option>
                    <option value="canceled" @selected(request('status') === 'canceled')>Canceled</option>
                    <option value="urgent" @selected(request('status') === 'urgent')>Urgent</option>
                </select>

                <select name="client_id"
                    class="w-full sm:w-auto text-sm border border-gray-300 rounded-lg px-4 sm:px-9 py-3 text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-none cursor-pointer">

                    <option value="">All Clients</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}" @selected((string) request('client_id') === (string) $client->id)>
                            {{ $client->name }}
                        </option>
                    @endforeach
                </select>

                <select name="sort"
                    class="w-full sm:w-auto text-sm border border-gray-300 rounded-lg px-4 py-3 text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-none cursor-pointer">
                    <option value="latest" @selected(request('sort', 'latest') === 'latest')>Latest</option>
                    <option value="deadline" @selected(request('sort') === 'deadline')>Deadline</option>
                    <option value="budget_desc" @selected(request('sort') === 'budget_desc')>Highest Budget</option>
                    <option value="progress_desc" @selected(request('sort') === 'progress_desc')>Highest Progress</option>
                </select>

                <button type="submit"
                    class="w-full sm:w-auto px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium flex items-center justify-center gap-2 transition-colors duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filter
                </button>

                <a href="{{ route('projects.index') }}"
                    class="w-full sm:w-auto px-4 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 font-medium flex items-center justify-center gap-2 transition-colors duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Reset
                </a>
            </div>
        </form>
    </div>


    <!-- PROJECTS TABLE -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-4 md:p-6 border-b flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center">
                    <svg class="w-10 h-10 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-base md:text-lg font-semibold text-gray-800">Project List</h2>
                    <p class="text-xs text-gray-500">All your freelance projects</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <div class="text-xs text-gray-500">
                    Showing <span class="font-semibold">{{ $projects->count() }}</span> of
                    <span class="font-semibold">{{ $projects->total() }}</span> projects
                </div>
            </div>
        </div>

        {{-- <div class="p-4 md:p-6 overflow-x-auto">
            <table class="w-full min-w-full overflow-x-scroll text-xs md:text-sm">
                <thead>
                    <tr class="text-left text-gray-500 border-b">
                        <th class="pb-3 font-medium whitespace-nowrap">PROYEK</th>
                        <th class="pb-3 font-medium whitespace-nowrap">KLIEN</th>
                        <th class="pb-3 font-medium whitespace-nowrap">TENGGAT</th>
                        <th class="pb-3 font-medium whitespace-nowrap">PROGRES</th>
                        <th class="pb-3 font-medium whitespace-nowrap">STATUS</th>
                        <th class="pb-3 font-medium text-right whitespace-nowrap">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($projects as $project)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="py-4">
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" class="rounded border-gray-300">
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $project->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $project->type }} •
                                            {{ number_format($project->value) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 text-gray-600">
                                <div class="flex items-center gap-2">
                                    {{ $project->client?->name ?? '_' }}
                                </div>
                            </td>
                            <td class="py-4 text-gray-600">{{ $project->deadline?->format('d M Y') ?? '_' }}</td>
                            <td class="py-4">
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full transition-all duration-300 {{ $project->progress_color }}"
                                            style="width: {{ $project->progress }}%"></div>
                                    </div>
                                    <span class="text-xs font-medium text-gray-600">{{ $project->progress }}%</span>
                                </div>
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
                            <td class="py-4">
                                <div class="flex justify-end gap-2">
                                    <button
                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200"
                                        title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <button
                                        class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors duration-200"
                                        title="View Details">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                    <button
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200"
                                        title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div> --}}
        <div class="p-4 md:p-6">
            <!-- Desktop View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full min-w-full text-sm">
                    <!-- Tabel untuk desktop (sama seperti sebelumnya) -->
                    <table class="w-full min-w-[720px] overflow-x-scroll text-xs md:text-sm">
                        <thead>
                            <tr class="text-left text-gray-500 border-b">
                                <th class="pb-3 font-medium whitespace-nowrap">PROYEK</th>
                                <th class="pb-3 font-medium whitespace-nowrap">KLIEN</th>
                                <th class="pb-3 font-medium whitespace-nowrap">TENGGAT</th>
                                <th class="pb-3 font-medium whitespace-nowrap">PROGRES</th>
                                <th class="pb-3 font-medium whitespace-nowrap">STATUS</th>
                                <th class="pb-3 font-medium text-right whitespace-nowrap">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($projects as $project)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="py-4">
                                        <div class="flex items-center gap-3">
                                            <input type="checkbox" class="rounded border-gray-300">
                                            <div>
                                                <p class="font-medium text-gray-800">{{ $project->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $project->category }} •
                                                    {{ number_format($project->budget) }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 text-gray-600">
                                        <div class="flex items-center gap-2">
                                            {{ $project->client?->name ?? '_' }}
                                        </div>
                                    </td>
                                    <td class="py-4 text-gray-600">{{ $project->deadline?->format('d M Y') ?? '_' }}
                                    </td>
                                    <td class="py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                                <div class="h-full rounded-full transition-all duration-300 {{ $project->progress_color }}"
                                                    style="width: {{ $project->progress }}%"></div>
                                            </div>
                                            <span
                                                class="text-xs font-medium text-gray-600">{{ $project->progress }}%</span>
                                        </div>
                                    </td>
                                    <td class="py-4">
                                        @if ($project->is_urgent)
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-600">
                                                Urgent
                                            </span>
                                        @else
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-semibold {{ $project->status_color }}">
                                                {{ ucfirst($project->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4">
                                        <div class="flex justify-end gap-2">
                                            {{-- <a href="{{ route('projects.edit', $project) }}"
                                                class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200"
                                                title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a> --}}
                                            <a href="{{ route('projects.show', $project) }}"
                                                class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors duration-200"
                                                title="View Details">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>

                                            <form action="{{ route('projects.destroy', $project) }}" method="POST"
                                                class="inline delete-form">
                                                @csrf
                                                @method('DELETE')

                                                <button type="button"
                                                    class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200 delete-btn"
                                                    title="Delete">
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
                            @endforeach
                        </tbody>
                    </table>
                </table>
            </div>

            <!-- Mobile View -->
            <div class="md:hidden space-y-4">
                @foreach ($projects as $project)
                    <div class="bg-white rounded-lg border p-4 shadow-sm">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" class="rounded border-gray-300">
                                <div>
                                    <p class="font-medium text-gray-800">{{ $project->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $project->category }} •
                                        {{ number_format($project->budget) }}</p>
                                </div>
                            </div>
                            <div class="flex gap-1">
                                <!-- Tombol aksi -->
                                <a href="{{ route('projects.edit', $project) }}"
                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200"
                                    title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <a href="{{ route('projects.show', $project) }}"
                                    class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors duration-200"
                                    title="View Details">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <form action="{{ route('projects.destroy', $project) }}" method="POST"
                                    class="inline delete-form">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button"
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200 delete-btn"
                                        title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                            <div>
                                <p class="text-gray-500 text-xs">Client</p>
                                <p class="font-medium">{{ $project->client?->name ?? '_' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 text-xs">Deadline</p>
                                <p class="font-medium">{{ $project->deadline?->format('d M Y') ?? '_' }}</p>
                            </div>
                                <div class="sm:col-span-2">
                                <p class="text-gray-500 text-xs mb-1">Progress</p>
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full {{ $project->progress_color }}"
                                            style="width: {{ $project->progress }}%"></div>
                                    </div>
                                    <span class="text-xs font-medium">{{ $project->progress }}%</span>
                                </div>
                            </div>
                                <div class="sm:col-span-2">
                                <p class="text-gray-500 text-xs mb-1">Status</p>
                                @if ($project->is_urgent)
                                    <span
                                        class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-600">
                                        Urgent
                                    </span>
                                @else
                                    <span
                                        class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $project->status_color }}">
                                        {{ $project->status_label ? ucfirst($project->status) : ucfirst($project->status) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Pagination -->
        @if ($projects->hasPages())
            <div class="p-4 md:p-6 border-t">
                {{ $projects->links() }}
            </div>
        @endif
    </div>

    <!-- Add Project Modal -->
    <div id="addProjectModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">Add New Project</h3>
                        <button onclick="hideAddProjectModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('projects.store') }}">
                        @csrf
                        <div class="space-y-5">
                            <!-- Project Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Project Name
                                </label>
                                <input type="text" name="name" required
                                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Example: Village Information System">
                            </div>

                            <!-- Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Project Category
                                </label>
                                <input type="text" name="category" required
                                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Example: Mobile App">
                            </div>

                            <!-- Client -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Client
                                </label>
                                <select name="client_id" required
                                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Select Client</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">
                                            {{ $client->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Deadline -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Deadline
                                </label>
                                <input type="date" name="deadline"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <!-- Value -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Project Value (Rp)
                                </label>
                                <input type="number" name="budget" required
                                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Example: 50000000">
                            </div>

                            <!-- Description -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Description
                                </label>
                                <textarea name="description" rows="3"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Short project notes (optional)"></textarea>
                            </div>
                        </div>

                        <!-- Action -->
                        <div class="flex gap-3 mt-6">
                            <button type="button" onclick="hideAddProjectModal()"
                                class="flex-1 px-4 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 font-medium transition-colors duration-300">
                                Cancel
                            </button>
                            <button type="submit"
                                class="flex-1 px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition-colors duration-300">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');

                    Swal.fire({
                        title: 'Delete project?',
                        text: 'Project data and related tasks will be permanently deleted.',
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
