<?php

namespace App\Http\Controllers;

use App\Models\Finances;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        $previousStart = now()->subMonthNoOverflow()->startOfMonth();
        $previousEnd = now()->subMonthNoOverflow()->endOfMonth();

        $stats = [
            'total' => $user->projects()->count(),
            'active' => $user->projects()->where('status', 'active')->count(),
            'completed' => $user->projects()->where('status', 'completed')->count(),
            'urgent' => $user->projects()
                ->whereNotIn('status', ['completed', 'canceled'])
                ->whereDate('deadline', '<=', now()->addDays(3))
                ->count()
        ];

        $monthIncome = $user->finances()
            ->where('type', 'income')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $monthExpense = $user->finances()
            ->where('type', 'expense')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $previousIncome = $user->finances()
            ->where('type', 'income')
            ->whereBetween('created_at', [$previousStart, $previousEnd])
            ->sum('amount');

        $financeSummary = [
            'income' => $monthIncome,
            'expense' => $monthExpense,
            'net' => $monthIncome - $monthExpense,
            'growth' => $previousIncome > 0
                ? round((($monthIncome - $previousIncome) / $previousIncome) * 100, 1)
                : ($monthIncome > 0 ? 100 : 0),
        ];

        $chartLabels = [];
        $chartIncome = [];
        $chartExpense = [];
        $cursor = Carbon::now()->subDays(6)->startOfDay();

        while ($cursor->lte(now()->startOfDay())) {
            $dayStart = $cursor->copy()->startOfDay();
            $dayEnd = $cursor->copy()->endOfDay();
            $chartLabels[] = $cursor->translatedFormat('d M');

            $query = Finances::where('user_id', $user->id)
                ->whereBetween('created_at', [$dayStart, $dayEnd]);

            $chartIncome[] = (float) (clone $query)->where('type', 'income')->sum('amount');
            $chartExpense[] = (float) (clone $query)->where('type', 'expense')->sum('amount');

            $cursor->addDay();
        }

        $recentProjects = $user->projects()
            ->with('client')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'stats',
            'recentProjects',
            'financeSummary',
            'chartLabels',
            'chartIncome',
            'chartExpense'
        ));
    }
}
