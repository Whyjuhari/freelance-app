<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProjekController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function complete(Projects $project, Request $request)
    {
        abort_if($project->user_id !== Auth::id(), 403);

        // cek apakah masih ada task belum selesai
        $unfinishedTasks = $project->tasks()
            ->where('status', '!=', 'done')
            ->count();

        if ($unfinishedTasks > 0) {

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Masih ada task yang belum selesai!'
                ], 422);
            }
            return redirect()->back()
                ->with('error', 'Masih ada task yang belum selesai!');
        }

        // jika semua task selesai
        $project->update([
            'status' => 'completed',
            'progress' => 100,
            'completed_at' => now(),
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Project marked as completed successfully!',
                'project' => $project
            ]);
        }

        return redirect()->route('projects.show', $project)
            ->with('success', 'Project marked as completed successfully!');
    }


    public function index(Request $request)
    {
        $sort = $request->input('sort', 'latest');

        $projects = Projects::where('user_id', auth()->id())
            ->with('client')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%")
                        ->orWhereHas('client', fn($clientQuery) => $clientQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('company_name', 'like', "%{$search}%"));
                });
            })
            ->when($request->filled('client_id'), fn($query) => $query->where('client_id', $request->input('client_id')))
            ->when($request->filled('status') && $request->input('status') !== 'urgent', fn($query) => $query->where('status', $request->input('status')))
            ->when($request->input('status') === 'urgent', function ($query) {
                $query->whereNotIn('status', ['completed', 'canceled'])
                    ->whereDate('deadline', '<=', now()->addDays(3));
            })
            ->when($sort === 'deadline', fn($query) => $query->orderBy('deadline'))
            ->when($sort === 'budget_desc', fn($query) => $query->orderByDesc('budget'))
            ->when($sort === 'progress_desc', fn($query) => $query->orderByDesc('progress'))
            ->when(!in_array($sort, ['deadline', 'budget_desc', 'progress_desc'], true), fn($query) => $query->latest())
            ->paginate(10)
            ->withQueryString();

        $clients = Clients::where('user_id', auth()->id())->get();
        return view('projects.index', compact('projects', 'clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'client_id' => [
                'required',
                Rule::exists('clients', 'id')->where(fn($query) => $query->where('user_id', auth()->id())),
            ],
            'deadline' => 'nullable|date',
            'budget' => 'nullable|numeric|min:0',
        ]);

        Projects::create([
            'user_id' => auth()->id(),
            'client_id' => $validated['client_id'],
            'name' => $validated['name'],
            'category' => $validated['category'] ?? null,
            'description' => $validated['description'] ?? null,
            'deadline' => $validated['deadline'] ?? null,
            'budget' => $validated['budget'] ?? 0,
            'status' => ($validated['progress'] ?? 0) >= 100
                ? 'completed'
                : 'planning',
        ]);

        return redirect()->route('projects.index')->with('success', 'Project Created Successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Projects $project)
    {

        abort_if($project->user_id !== Auth::id(), 403);

        $project->load([
            'tasks' => function ($q) {
                $q->orderBy('due_date');
            }
        ])->loadCount([
            'tasks',
            'tasks as completed_tasks_count' => function ($q) {
                $q->where('status', 'done');
            },
        ]);
        return view('projects.detail', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Projects $project)
    {
        abort_if($project->user_id !== Auth::id(), 403);

        $clients = Clients::where('user_id', auth()->id())->get();

        return view('projects.edit', compact('project', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Projects $project)
    {
        abort_if($project->user_id !== Auth::id(), 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:planning,active,completed,on_hold,canceled',
            'progress' => 'nullable|integer|min:0|max:100',
            'client_id' => [
                'required',
                Rule::exists('clients', 'id')->where(fn($query) => $query->where('user_id', auth()->id())),
            ],
            'deadline' => 'nullable|date',
            'budget' => 'nullable|numeric|min:0',
        ]);

        $status = $validated['status'] ?? $project->status;
        $progress = $validated['progress'] ?? $project->progress;

        if ($progress === 100 || $status === 'completed') {
            $status = 'completed';
            $progress = 100;
            $validated['completed_at'] = now();
        } elseif ($progress === 100) {
            $status = 'completed';
        }
        // 2. progress 100 → status completed
        elseif ($progress === 100 && $status !== 'completed') {
            $status = 'completed';
            $validated['completed_at'] = now();
        }

        // 3. planning + progress > 0 → active
        elseif ($status === 'planning' && $progress > 0 && $progress < 100) {
            $status = 'active';
        }

        // 4. on_hold / canceled → progress freeze
        elseif (in_array($status, ['on_hold', 'canceled'])) {
            if ($progress > 0 && $progress < 100) {
                $progress = 0;
            }
            $validated['completed_at'] = null;
        }

        // 5. cleanup completed_at
        else {
            $validated['completed_at'] = null;
        }

        $validated['status'] = $status;
        $validated['progress'] = $progress;

        $project->update($validated);

        return redirect()->route('projects.index')->with('success', 'Project Update Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Projects $project)
    {
        abort_if($project->user_id !== Auth::id(), 403);

        $project->delete();

        return redirect()
            ->route('projects.index')
            ->with('success', 'Proyek berhasil dihapus');
    }
}
