<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FreelanceApp Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #111827;
            margin: 32px;
        }

        h1,
        h2 {
            margin: 0;
        }

        .muted {
            color: #6b7280;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin: 24px 0;
        }

        .card {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 14px;
        }

        .label {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .value {
            font-size: 18px;
            font-weight: 700;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
            margin-bottom: 24px;
            font-size: 13px;
        }

        th,
        td {
            border-bottom: 1px solid #e5e7eb;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #f9fafb;
            color: #4b5563;
            font-size: 12px;
            text-transform: uppercase;
        }

        .right {
            text-align: right;
        }

        @media print {
            body {
                margin: 18mm;
            }

            button {
                display: none;
            }
        }
    </style>
</head>

<body>
    <button onclick="window.print()" style="float:right;padding:8px 12px">Print / Save PDF</button>
    <h1>FreelanceApp Report</h1>
    <p class="muted">Period {{ $filters['start_date'] }} to {{ $filters['end_date'] }}</p>

    <div class="grid">
        <div class="card">
            <div class="label">Income</div>
            <div class="value">Rp {{ number_format($summary['income'], 0, ',', '.') }}</div>
        </div>
        <div class="card">
            <div class="label">Expense</div>
            <div class="value">Rp {{ number_format($summary['expense'], 0, ',', '.') }}</div>
        </div>
        <div class="card">
            <div class="label">Net Profit</div>
            <div class="value">Rp {{ number_format($summary['net'], 0, ',', '.') }}</div>
        </div>
        <div class="card">
            <div class="label">Tracked Hours</div>
            <div class="value">{{ number_format($summary['hours'], 1) }}h</div>
        </div>
    </div>

    <h2>Productivity</h2>
    <table>
        <tr>
            <th>Metric</th>
            <th class="right">Value</th>
        </tr>
        <tr>
            <td>Billable Hours</td>
            <td class="right">{{ number_format($summary['billable_hours'], 1) }}h</td>
        </tr>
        <tr>
            <td>Completed Tasks</td>
            <td class="right">{{ $summary['completed_tasks'] }}/{{ $summary['total_tasks'] }}</td>
        </tr>
        <tr>
            <td>Completion Rate</td>
            <td class="right">{{ $summary['completion_rate'] }}%</td>
        </tr>
    </table>

    <h2>Revenue by Project</h2>
    <table>
        <thead>
            <tr>
                <th>Project</th>
                <th class="right">Income</th>
                <th class="right">Expense</th>
                <th class="right">Net</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($projectRevenue as $row)
                <tr>
                    <td>{{ $row['name'] }}</td>
                    <td class="right">Rp {{ number_format($row['income'], 0, ',', '.') }}</td>
                    <td class="right">Rp {{ number_format($row['expense'], 0, ',', '.') }}</td>
                    <td class="right">Rp {{ number_format($row['net'], 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No project data yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h2>Revenue by Client</h2>
    <table>
        <thead>
            <tr>
                <th>Client</th>
                <th class="right">Income</th>
                <th class="right">Expense</th>
                <th class="right">Net</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($clientRevenue as $row)
                <tr>
                    <td>{{ $row['name'] }}</td>
                    <td class="right">Rp {{ number_format($row['income'], 0, ',', '.') }}</td>
                    <td class="right">Rp {{ number_format($row['expense'], 0, ',', '.') }}</td>
                    <td class="right">Rp {{ number_format($row['net'], 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No client data yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
