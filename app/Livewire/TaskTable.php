<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Task;
use App\Models\Projects;

class TaskTable extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $projectFilter = '';
    public $priorityFilter = '';
    public $sortBy = 'due_date';
    public $sortDirection = 'asc';
    public $perPage = 10;
    public $viewMode = 'kanban';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'projectFilter' => ['except' => ''],
        'priorityFilter' => ['except' => ''],
        'sortBy' => ['except' => 'due_date'],
        'sortDirection' => ['except' => 'asc'],
        'perPage' => ['except' => 10],
        'viewMode' => ['except' => 'kanban'],
    ];

    public function mount()
    {
        // Optional: Load initial data
    }

    public function updated($property)
    {
        if (in_array($property, ['search', 'statusFilter', 'projectFilter', 'priorityFilter', 'perPage'])) {
            $this->resetPage();
        }
    }

    public function getStatsProperty()
    {
        $query = Task::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->projectFilter) {
            $query->where('project_id', $this->projectFilter);
        }

        if ($this->priorityFilter) {
            $query->where('priority', $this->priorityFilter);
        }

        return [
            'all' => $query->count(),
            'in_progress' => (clone $query)->where('status', 'in_progress')->count(),
            'done' => (clone $query)->where('status', 'done')->count(),
            'overdue' => (clone $query)->where('due_date', '<', now())
                ->where('status', '!=', 'done')
                ->count(),
        ];
    }

    public function getKanbanTasksProperty()
    {
        $query = $this->getTasksQuery();
        $tasks = $query->get();

        return [
            'pending' => $tasks->where('status', 'pending'),
            'in_progress' => $tasks->where('status', 'in_progress'),
            'done' => $tasks->where('status', 'done'),
            'overdue' => $tasks->filter(function ($task) {
                return $task->due_date && $task->due_date < now() && $task->status !== 'done';
            }),
        ];
    }

    private function getTasksQuery()
    {
        $query = Task::with('project');

        // Search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Status filter
        if ($this->statusFilter && $this->statusFilter !== 'overdue') {
            $query->where('status', $this->statusFilter);
        }

        // Project filter
        if ($this->projectFilter) {
            $query->where('project_id', $this->projectFilter);
        }

        // Priority filter
        if ($this->priorityFilter) {
            $query->where('priority', $this->priorityFilter);
        }

        // Overdue filter
        if ($this->statusFilter === 'overdue') {
            $query->where('due_date', '<', now())
                ->where('status', '!=', 'done');
        }

        // Sorting
        $query->orderBy($this->sortBy, $this->sortDirection);

        return $query;
    }

    public function getTasksProperty()
    {
        return $this->getTasksQuery()->paginate($this->perPage);
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function switchView($mode)
    {
        $this->viewMode = $mode;
    }


    public function render()
    {
        return view('livewire.task-table', [
            'projects' => Projects::all(),
            'kanbanTasks' => $this->getKanbanTasksProperty(),
            'tasks' => $this->getTasksQuery()->paginate($this->perPage),
            'stats' => $this->getStatsProperty(),
        ]);
    }
}
