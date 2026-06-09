<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Project') }}
        </h2>
    </x-slot>

    <div class="bg-white rounded-lg p-4 md:p-6 mb-3 text-gray-600 shadow-xl">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm text-gray-600 mb-4">
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
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
            <div class="flex items-center gap-3 md:gap-4">
                <div
                    class="w-12 h-12 md:w-14 md:h-14 bg-blue-600 bg-opacity-20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold">Manage Your Projects</h1>
                    <p class="text-gray-500 text-opacity-90 text-xs md:text-base">Manage all your freelance projects in
                        one place</p>
                </div>
            </div>
        </div>
    </div>
    <div class="min-h-screen p-4">
        <div class="bg-slate-100 rounded-xl shadow-xl border-gray-600">
            <div class="p-6 border-b">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800">Edit Project</h3>
                </div>
            </div>
            <form class="p-6" method="POST" action="{{ route('projects.update', $project->id) }}">
                @csrf
                @method('put')
                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="grid lg:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Project Name
                        </label>
                        <input type="text" name="name" value="{{ old('name', $project->name) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Project Category
                        </label>
                        <input type="text" name="category" value="{{ old('category', $project->category) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Client
                        </label>
                        <select name="client_id"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent cursor-pointer">
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}" @selected(old('client_id', $project->client_id) == $client->id)>
                                    {{ $client->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Deadline
                        </label>
                        <input type="date" name="deadline"
                            value="{{ old('deadline', $project->deadline?->format('Y-m-d')) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent cursor-pointer">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Project Budget
                        </label>
                        <input type="number" name="budget" value="{{ old('budget', $project->budget) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Example: 50000000">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Progress
                        </label>
                        <input id="progressSlider" type="range" name="progress" min="0" max="100"
                            value="{{ old('progress', $project->progress) }}" class="w-full accent-blue-600"
                            oninput="this.nextElementSibling.innerText = this.value + '%'">
                        <p class="text-sm text-gray-500 mt-1">{{ old('progress', $project->progress) }}%</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Description
                        </label>
                        <textarea name="description" rows="3"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Short project notes (optional)">{{ $project->description }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Status
                        </label>
                        <select name="status"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent cursor-pointer">
                            <option value="planning"
                                {{ old('status', $project->status) == 'planning' ? 'selected' : '' }}>Planning</option>
                            <option value="active" {{ old('status', $project->status) == 'active' ? 'selected' : '' }}>
                                Active</option>
                            <option value="on_hold"
                                {{ old('status', $project->status) == 'on_hold' ? 'selected' : '' }}>On Hold</option>
                            <option value="completed"
                                {{ old('status', $project->status) == 'completed' ? 'selected' : '' }}>Completed
                            </option>
                            <option value="canceled"
                                {{ old('status', $project->status) == 'canceled' ? 'selected' : '' }}>Canceled</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">
                            <strong>Note:</strong> Progress 100% will automatically change the status to "Completed"
                        </p>
                    </div>
                </div>

                <!-- Action -->
                <div class="mt-6">
                    <a href="{{ route('projects.index') }}"
                        class="flex-1 mr-3 px-4 py-3 border border-gray-300 rounded-lg hover:bg-gray-300 font-medium transition-colors duration-300">
                        Cancel
                    </a>
                    <button type="submit"
                        class="flex-1 px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition-colors duration-300">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const progressSlider = document.getElementById('progressSlider');
            const statusSelect = document.querySelector('select[name="status"]');

            if (progressSlider && statusSelect) {
                progressSlider.addEventListener('input', function() {
                    const value = parseInt(this.value);

                    // Jika progress 100, otomatis set status ke completed
                    if (value === 100) {
                        statusSelect.value = 'completed';
                    }
                });
            }
        });
    </script>
</x-app-layout>
