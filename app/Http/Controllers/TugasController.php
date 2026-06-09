<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function toggle(Task $task)
    {
        abort_if($task->user_id !== auth()->id(), 403);

        if ($task->status == 'done') {
            $task->update([
                'status' => 'in_progress',
                'completed_at' => null,
            ]);
        } else {
            $task->update([
                'status' => 'done',
                'completed_at' => now(),
            ]);
        }

        return response()->json([
            'status' => $task->status,
            'completed_at' => $task->completed_at,
        ]);
    }
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'due_date');

        $baseQuery = Task::with('project')
            ->where('user_id', auth()->id())
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhereHas('project', fn($projectQuery) => $projectQuery->where('name', 'like', "%{$search}%"));
                });
            })
            ->when($request->filled('project_id'), fn($query) => $query->where('project_id', $request->input('project_id')))
            ->when($request->filled('status') && $request->input('status') !== 'overdue', fn($query) => $query->where('status', $request->input('status')))
            ->when($request->input('status') === 'overdue', fn($query) => $query->where('due_date', '<', now())->where('status', '!=', 'done'));

        $taskCollection = (clone $baseQuery)->get();
        $tasks = (clone $baseQuery)
            ->when($sort === 'title', fn($query) => $query->orderBy('title'))
            ->when($sort === 'status', fn($query) => $query->orderBy('status'))
            ->when($sort === 'created_at', fn($query) => $query->latest())
            ->when(!in_array($sort, ['title', 'status', 'created_at'], true), fn($query) => $query->orderBy('due_date'))
            ->paginate(10)
            ->withQueryString();

        $stats = [
            'all' => $taskCollection->count(),
            'in_progress' => $taskCollection->where('status', 'in_progress')->count(),
            'done' => $taskCollection->where('status', 'done')->count(),
            'overdue' => $taskCollection->where('due_date', '<', now())
                ->where('status', '!=', 'done')
                ->count(),
        ];

        // Group untuk Kanban
        $kanban = [
            'pending' => $taskCollection->where('status', 'pending'),
            'in_progress' => $taskCollection->where('status', 'in_progress'),
            'done' => $taskCollection->where('status', 'done'),
            'overdue' => $taskCollection->where('due_date', '<', now())
                ->where('status', '!=', 'done'),
        ];

        // $overdue = $tasks->where('due_date', '<', now())->where('status', '!=', 'done');
        $projects = Projects::where('user_id', auth()->id())->get();



        return view('tasks.index', compact('tasks', 'stats', 'kanban', 'projects'));
        // return redirect()->route('tasks.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "title" => "required|max:255",
            "description" => "nullable|string|max:255",
            "project_id" => [
                "required",
                Rule::exists('projects', 'id')->where(fn($query) => $query->where('user_id', auth()->id())),
            ],
            "status" => "required|in:pending,in_progress,done",
            "due_date" => "required|date",
        ]);

        $data['user_id'] = auth()->id();
        Task::create($data);
        return redirect()->route('tasks.index')->with('success', 'Task Created Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::where('user_id', auth()->id())->findOrFail($id);

        return redirect()
            ->route('tasks.index')
            ->with('success', "Task {$task->title} berstatus {$task->status}.");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::findOrFail($id);
        abort_if($task->user_id !== auth()->id(), 403);

        $data = $request->validate([
            "title" => "required|max:255",
            "description" => "nullable|string|max:255",
            "project_id" => [
                "required",
                Rule::exists('projects', 'id')->where(fn($query) => $query->where('user_id', auth()->id())),
            ],
            "status" => "required|in:pending,in_progress,done",
            "due_date" => "required|date",
        ]);

        $data['completed_at'] = $data['status'] === 'done'
            ? ($task->completed_at ?? now())
            : null;

        $task->update($data);

        return redirect()->route('tasks.index')->with('success', 'Task Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);
        abort_if($task->user_id !== auth()->id(), 403);

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task Deleted Successfully!');
    }
}
