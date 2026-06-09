<?php

namespace App\Http\Controllers;

use App\Models\Finances;
use App\Models\Projects;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        $filters = $this->filters($request);
        $query = $this->filteredQuery($filters)->with('project');

        $finances = (clone $query)
            ->latest('created_at')
            ->paginate(12)
            ->withQueryString();

        $summaryQuery = $this->filteredQuery($filters);
        $income = (clone $summaryQuery)->where('type', 'income')->sum('amount');
        $expense = (clone $summaryQuery)->where('type', 'expense')->sum('amount');

        $summary = [
            'income' => $income,
            'expense' => $expense,
            'net' => $income - $expense,
            'count' => (clone $summaryQuery)->count(),
        ];

        $projects = Projects::where('user_id', Auth::id())
            ->orderBy('name')
            ->get();

        return view('keuangan.index', compact('finances', 'summary', 'projects', 'filters'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateFinance($request);
        $validated['user_id'] = Auth::id();

        if (!empty($validated['date'])) {
            $validated['created_at'] = Carbon::parse($validated['date'])->startOfDay();
        }

        unset($validated['date']);

        Finances::create($validated);

        return redirect()
            ->route('keuangan.index')
            ->with('success', 'Data keuangan berhasil ditambahkan.');
    }

    public function update(Request $request, Finances $keuangan)
    {
        abort_if($keuangan->user_id !== Auth::id(), 403);

        $validated = $this->validateFinance($request);

        if (!empty($validated['date'])) {
            $validated['created_at'] = Carbon::parse($validated['date'])->startOfDay();
        }

        unset($validated['date']);

        $keuangan->update($validated);

        return redirect()
            ->route('keuangan.index', $request->only(['start_date', 'end_date', 'type', 'project_id']))
            ->with('success', 'Data keuangan berhasil diperbarui.');
    }

    public function destroy(Finances $keuangan)
    {
        abort_if($keuangan->user_id !== Auth::id(), 403);

        $keuangan->delete();

        return redirect()
            ->route('keuangan.index')
            ->with('success', 'Data keuangan berhasil dihapus.');
    }

    private function validateFinance(Request $request): array
    {
        return $request->validate([
            'amount' => ['required', 'numeric', 'min:0'],
            'type' => ['required', Rule::in(['income', 'expense'])],
            'project_id' => [
                'nullable',
                Rule::exists('projects', 'id')->where(fn($query) => $query->where('user_id', Auth::id())),
            ],
            'note' => ['nullable', 'string', 'max:500'],
            'date' => ['nullable', 'date'],
        ]);
    }

    private function filters(Request $request): array
    {
        return [
            'start_date' => $request->input('start_date', now()->startOfMonth()->format('Y-m-d')),
            'end_date' => $request->input('end_date', now()->endOfMonth()->format('Y-m-d')),
            'type' => $request->input('type'),
            'project_id' => $request->input('project_id'),
        ];
    }

    private function filteredQuery(array $filters)
    {
        $start = Carbon::parse($filters['start_date'])->startOfDay();
        $end = Carbon::parse($filters['end_date'])->endOfDay();

        return Finances::where('user_id', Auth::id())
            ->whereBetween('created_at', [$start, $end])
            ->when($filters['type'], fn($query, $type) => $query->where('type', $type))
            ->when($filters['project_id'], fn($query, $projectId) => $query->where('project_id', $projectId));
    }
}
