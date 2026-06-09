<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use App\Models\Task;
use App\Models\TimeLogs;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TimeLogController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();
        $rangeStart = Carbon::parse($request->input('start_date', now()->startOfWeek()->format('Y-m-d')))->startOfDay();
        $rangeEnd = Carbon::parse($request->input('end_date', now()->endOfWeek()->format('Y-m-d')))->endOfDay();

        // Get active timer (if any)
        $activeTimer = TimeLogs::where('user_id', $userId)
            ->whereNull('end_time')
            ->with(['project', 'task'])
            ->first();

        // Get projects for dropdown
        $projects = Projects::where('user_id', $userId)
            ->where('status', '!=', 'completed')
            ->orderBy('name')
            ->get();

        // Filter by date range
        $startDate = $rangeStart->toDateString();
        $endDate = $rangeEnd->toDateString();

        // Get time logs
        $timeLogs = TimeLogs::where('user_id', $userId)
            ->with(['project', 'task'])
            ->whereBetween('start_time', [$rangeStart, $rangeEnd])
            ->latest('start_time')
            ->paginate(20)
            ->withQueryString();

        // Calculate stats
        $stats = [
            'total_hours' => TimeLogs::where('user_id', $userId)
                ->whereBetween('start_time', [$rangeStart, $rangeEnd])
                ->sum('duration') / 3600,
            'billable_hours' => TimeLogs::where('user_id', $userId)
                ->whereBetween('start_time', [$rangeStart, $rangeEnd])
                ->whereHas('project', fn($query) => $query->where('status', 'active'))
                ->sum('duration') / 3600,
            'today_hours' => TimeLogs::where('user_id', $userId)
                ->whereDate('start_time', today())
                ->sum('duration') / 3600,
            'week_hours' => TimeLogs::where('user_id', $userId)
                ->whereBetween('start_time', [now()->startOfWeek(), now()->endOfWeek()])
                ->sum('duration') / 3600,
        ];

        return view('time-tracking.index', compact('timeLogs', 'projects', 'activeTimer', 'stats', 'startDate', 'endDate'));
    }

    public function start(Request $request)
    {
        $validated = $request->validate([
            'project_id' => [
                'required',
                Rule::exists('projects', 'id')->where(fn($query) => $query->where('user_id', auth()->id())),
            ],
            'task_id' => [
                'nullable',
                Rule::exists('tasks', 'id')->where(fn($query) => $query->where('user_id', auth()->id())),
            ],
            'notes' => 'nullable|string|max:500',
        ]);

        if (!empty($validated['task_id'])) {
            $task = Task::whereKey($validated['task_id'])->where('user_id', auth()->id())->first();

            if (!$task || $task->project_id !== (int) $validated['project_id']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Task does not belong to the selected project'
                ], 422);
            }
        }

        // Check if there's already an active timer
        $activeTimer = TimeLogs::where('user_id', auth()->id())
            ->whereNull('end_time')
            ->first();

        if ($activeTimer) {
            return response()->json([
                'success' => false,
                'message' => 'Please stop the current timer first'
            ], 400);
        }

        $validated['user_id'] = auth()->id();
        $validated['start_time'] = now();

        $timeLog = TimeLogs::create($validated);

        return response()->json([
            'success' => true,
            'time_log' => $timeLog->load('project', 'task'),
            'message' => 'Timer started'
        ]);
    }

    public function stop(TimeLogs $timeLog)
    {
        abort_if($timeLog->user_id !== auth()->id(), 403);

        if ($timeLog->end_time) {
            return response()->json([
                'success' => false,
                'message' => 'Timer already stopped'
            ], 400);
        }

        $timeLog->update([
            'end_time' => now(),
            'duration' => now()->diffInSeconds($timeLog->start_time)
        ]);

        return response()->json([
            'success' => true,
            'time_log' => $timeLog->fresh(['project', 'task']),
            'message' => 'Timer stopped'
        ]);
    }

    public function getTasks(Projects $project)
    {
        abort_if($project->user_id !== auth()->id(), 403);

        $tasks = $project->tasks()
            ->where('status', '!=', 'done')
            ->orderBy('due_date')
            ->get(['id', 'title', 'status'])
            ->map(fn($task) => [
                'id' => $task->id,
                'name' => $task->title,
                'status' => $task->status,
            ]);

        return response()->json([
            'success' => true,
            'tasks' => $tasks
        ]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => [
                'required',
                Rule::exists('projects', 'id')->where(fn($query) => $query->where('user_id', auth()->id())),
            ],
            'task_id' => [
                'nullable',
                Rule::exists('tasks', 'id')->where(fn($query) => $query->where('user_id', auth()->id())),
            ],
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'notes' => 'nullable|string|max:500',
        ]);

        if (!empty($validated['task_id'])) {
            $task = Task::whereKey($validated['task_id'])->where('user_id', auth()->id())->first();

            if (!$task || $task->project_id !== (int) $validated['project_id']) {
                return redirect()->back()->withErrors([
                    'task_id' => 'Task does not belong to the selected project.',
                ])->withInput();
            }
        }

        $validated['user_id'] = auth()->id();

        $start = Carbon::parse($validated['start_time']);
        $end = Carbon::parse($validated['end_time']);
        $validated['duration'] = $end->diffInSeconds($start);

        $timeLog = TimeLogs::create($validated);

        return redirect()->back()->with('success', 'Time log added successfully');
    }

    public function update(Request $request, TimeLogs $timeLog)
    {
        abort_if($timeLog->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'notes' => 'nullable|string|max:500',
        ]);

        $start = Carbon::parse($validated['start_time']);
        $end = Carbon::parse($validated['end_time']);
        $validated['duration'] = $end->diffInSeconds($start);

        $timeLog->update($validated);

        return redirect()->back()->with('success', 'Time log updated successfully');
    }

    public function destroy(TimeLogs $timeLog)
    {
        abort_if($timeLog->user_id !== auth()->id(), 403);

        $timeLog->delete();

        return redirect()->back()->with('success', 'Time log deleted successfully');
    }
}
