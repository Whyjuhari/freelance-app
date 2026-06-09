<?php

use Livewire\Component;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public string $search = '';
    public string $status = 'all';

    public function render()
    {
        $tasks = Task::whereHas('project', function ($q) {
            $q->where('user_id', Auth::id());
        })
            ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->when($this->status !== 'all', fn($q) => $q->where('status', $this->status))
            ->get();

        return view('components.task-board', [
            'tasks' => $tasks,
        ]);
    }
};
?>

<div>
    <input type="text" wire:model.debounce.500ms="search" placeholder="Search task..."
        class="border p-2 rounded w-full mb-4" />

    <select wire:model="status" class="border p-2 mb-4">
        <option value="all">All</option>
        <option value="pending">Pending</option>
        <option value="in_progress">In Progress</option>
        <option value="done">Done</option>
    </select>

    <ul>
        @foreach ($tasks as $task)
            <li class="p-2 border-b">{{ $task->title }}</li>
        @endforeach
    </ul>
</div>
