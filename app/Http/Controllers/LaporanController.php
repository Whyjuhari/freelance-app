<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\Finances;
use App\Models\Projects;
use App\Models\Task;
use App\Models\TimeLogs;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $data = $this->reportData($request);

        return view('laporan.index', $data);
    }

    public function print(Request $request)
    {
        $data = $this->reportData($request);

        return view('laporan.print', $data);
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        $data = $this->reportData($request);
        $filename = 'laporan-' . $data['filters']['start_date'] . '-' . $data['filters']['end_date'] . '.csv';

        return response()->streamDownload(function () use ($data) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['FreelanceApp Report']);
            fputcsv($handle, ['Period', $data['filters']['start_date'] . ' - ' . $data['filters']['end_date']]);
            fputcsv($handle, []);
            fputcsv($handle, ['Metric', 'Value']);
            fputcsv($handle, ['Income', $data['summary']['income']]);
            fputcsv($handle, ['Expense', $data['summary']['expense']]);
            fputcsv($handle, ['Net Profit', $data['summary']['net']]);
            fputcsv($handle, ['Tracked Hours', round($data['summary']['hours'], 2)]);
            fputcsv($handle, ['Billable Hours', round($data['summary']['billable_hours'], 2)]);
            fputcsv($handle, ['Completed Tasks', $data['summary']['completed_tasks']]);
            fputcsv($handle, ['Total Tasks', $data['summary']['total_tasks']]);
            fputcsv($handle, []);

            fputcsv($handle, ['Project Revenue']);
            fputcsv($handle, ['Project', 'Income', 'Expense', 'Net']);
            foreach ($data['projectRevenue'] as $row) {
                fputcsv($handle, [$row['name'], $row['income'], $row['expense'], $row['net']]);
            }

            fputcsv($handle, []);
            fputcsv($handle, ['Client Revenue']);
            fputcsv($handle, ['Client', 'Income', 'Expense', 'Net']);
            foreach ($data['clientRevenue'] as $row) {
                fputcsv($handle, [$row['name'], $row['income'], $row['expense'], $row['net']]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    private function reportData(Request $request): array
    {
        $filters = [
            'start_date' => $request->input('start_date', now()->startOfMonth()->format('Y-m-d')),
            'end_date' => $request->input('end_date', now()->endOfMonth()->format('Y-m-d')),
        ];

        $start = Carbon::parse($filters['start_date'])->startOfDay();
        $end = Carbon::parse($filters['end_date'])->endOfDay();
        $userId = Auth::id();

        $financeQuery = Finances::where('user_id', $userId)
            ->whereBetween('created_at', [$start, $end]);

        $income = (clone $financeQuery)->where('type', 'income')->sum('amount');
        $expense = (clone $financeQuery)->where('type', 'expense')->sum('amount');

        $hours = TimeLogs::where('user_id', $userId)
            ->whereBetween('start_time', [$start, $end])
            ->sum('duration') / 3600;

        $billableHours = TimeLogs::where('user_id', $userId)
            ->whereBetween('start_time', [$start, $end])
            ->whereHas('project', fn($query) => $query->where('status', 'active'))
            ->sum('duration') / 3600;

        $totalTasks = Task::where('user_id', $userId)
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $completedTasks = Task::where('user_id', $userId)
            ->where('status', 'done')
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $projectRevenue = Projects::where('user_id', $userId)
            ->orderBy('name')
            ->get()
            ->map(function (Projects $project) use ($start, $end) {
                $query = $project->finances()->whereBetween('created_at', [$start, $end]);
                $income = (clone $query)->where('type', 'income')->sum('amount');
                $expense = (clone $query)->where('type', 'expense')->sum('amount');

                return [
                    'name' => $project->name,
                    'income' => $income,
                    'expense' => $expense,
                    'net' => $income - $expense,
                ];
            })
            ->filter(fn($row) => $row['income'] > 0 || $row['expense'] > 0)
            ->values();

        $clientRevenue = Clients::where('user_id', $userId)
            ->with('projects.finances')
            ->orderBy('company_name')
            ->get()
            ->map(function (Clients $client) use ($start, $end) {
                $finances = $client->projects
                    ->flatMap->finances
                    ->filter(fn($finance) => $finance->created_at->gte($start) && $finance->created_at->lte($end));

                $income = $finances->where('type', 'income')->sum('amount');
                $expense = $finances->where('type', 'expense')->sum('amount');

                return [
                    'name' => $client->company_name ?: $client->name,
                    'income' => $income,
                    'expense' => $expense,
                    'net' => $income - $expense,
                ];
            })
            ->filter(fn($row) => $row['income'] > 0 || $row['expense'] > 0)
            ->values();

        $chart = $this->monthlyChart($start, $end, $userId);

        return [
            'filters' => $filters,
            'summary' => [
                'income' => $income,
                'expense' => $expense,
                'net' => $income - $expense,
                'hours' => $hours,
                'billable_hours' => $billableHours,
                'total_tasks' => $totalTasks,
                'completed_tasks' => $completedTasks,
                'completion_rate' => $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0,
            ],
            'projectRevenue' => $projectRevenue,
            'clientRevenue' => $clientRevenue,
            'chart' => $chart,
        ];
    }

    private function monthlyChart(Carbon $start, Carbon $end, int $userId): array
    {
        $labels = [];
        $income = [];
        $expense = [];
        $cursor = $start->copy()->startOfMonth();
        $last = $end->copy()->startOfMonth();

        while ($cursor->lte($last)) {
            $monthStart = $cursor->copy()->startOfMonth();
            $monthEnd = $cursor->copy()->endOfMonth();
            $labels[] = $cursor->format('M Y');

            $query = Finances::where('user_id', $userId)
                ->whereBetween('created_at', [$monthStart, $monthEnd]);

            $income[] = (float) (clone $query)->where('type', 'income')->sum('amount');
            $expense[] = (float) (clone $query)->where('type', 'expense')->sum('amount');

            $cursor->addMonth();
        }

        return compact('labels', 'income', 'expense');
    }
}
