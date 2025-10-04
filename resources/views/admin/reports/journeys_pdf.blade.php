<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Journeys Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 15px;
        }

        .header h1 {
            margin: 0 0 10px 0;
            color: #2563eb;
            font-size: 24px;
        }

        .header .subtitle {
            color: #666;
            font-size: 14px;
        }

        .filters {
            background: #f8fafc;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .filters h3 {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #374151;
        }

        .filter-item {
            display: inline-block;
            margin-right: 20px;
            margin-bottom: 5px;
        }

        .filter-label {
            font-weight: bold;
            color: #6b7280;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .table th,
        .table td {
            border: 1px solid #d1d5db;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f3f4f6;
            font-weight: bold;
            color: #374151;
        }

        .table tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .budget {
            text-align: right;
            font-weight: bold;
            color: #059669;
        }

        .date {
            white-space: nowrap;
        }

        .summary {
            margin-top: 20px;
            background: #ecfdf5;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #10b981;
        }

        .summary h3 {
            margin: 0 0 10px 0;
            color: #065f46;
        }

        .summary-item {
            margin-bottom: 5px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            color: #9ca3af;
            font-size: 10px;
            border-top: 1px solid #e5e7eb;
            padding-top: 15px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Journeys Report</h1>
        <div class="subtitle">VoyageHub Travel Management System</div>
        <div class="subtitle">Generated on {{ now()->format('F d, Y \a\t H:i') }}</div>
    </div>

    @if(!empty($filters) && array_filter($filters))
        <div class="filters">
            <h3>Applied Filters:</h3>
            @if(isset($filters['start_date']) && $filters['start_date'])
                <div class="filter-item">
                    <span class="filter-label">From:</span> {{ \Carbon\Carbon::parse($filters['start_date'])->format('M d, Y') }}
                </div>
            @endif
            @if(isset($filters['end_date']) && $filters['end_date'])
                <div class="filter-item">
                    <span class="filter-label">To:</span> {{ \Carbon\Carbon::parse($filters['end_date'])->format('M d, Y') }}
                </div>
            @endif
            @if(isset($filters['user_id']) && $filters['user_id'])
                <div class="filter-item">
                    <span class="filter-label">User:</span> {{ $journeys->first()?->user->name ?? 'N/A' }}
                </div>
            @endif
            @if(isset($filters['destination']) && $filters['destination'])
                <div class="filter-item">
                    <span class="filter-label">Destination:</span> {{ $filters['destination'] }}
                </div>
            @endif
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">User</th>
                <th width="20%">Title</th>
                <th width="15%">Destination</th>
                <th width="15%">Travel Dates</th>
                <th width="10%">Transport</th>
                <th width="12%">Budget (IDR)</th>
                <th width="8%">Days</th>
            </tr>
        </thead>
        <tbody>
            @foreach($journeys as $index => $journey)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $journey->user->name }}</strong><br>
                        <small>{{ $journey->user->nik }}</small>
                    </td>
                    <td>{{ $journey->title }}</td>
                    <td>{{ $journey->destination }}</td>
                    <td class="date">
                        {{ $journey->start_date->format('M d, Y') }}<br>
                        <small>to {{ $journey->end_date ? $journey->end_date->format('M d, Y') : 'Open' }}</small>
                    </td>
                    <td>{{ $journey->transport ?: '-' }}</td>
                    <td class="budget">{{ number_format($journey->budget, 0, ',', '.') }}</td>
                    <td>{{ $journey->end_date ? $journey->start_date->diffInDays($journey->end_date) + 1 : 'Ongoing' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <h3>Summary</h3>
        <div class="summary-item">
            <strong>Total Journeys:</strong> {{ $journeys->count() }}
        </div>
        <div class="summary-item">
            <strong>Total Budget:</strong> Rp {{ number_format($journeys->sum('budget'), 0, ',', '.') }}
        </div>
        <div class="summary-item">
            <strong>Average Budget:</strong> Rp {{ number_format($journeys->avg('budget'), 0, ',', '.') }}
        </div>
        <div class="summary-item">
            <strong>Total Days:</strong> {{ $journeys->sum(function($journey) { return $journey->end_date ? $journey->start_date->diffInDays($journey->end_date) + 1 : 0; }) }} days
        </div>
    </div>

    <div class="footer">
        <div>© {{ date('Y') }} VoyageHub Travel Management System</div>
        <div>This report is generated automatically and contains confidential information</div>
    </div>
</body>
</html>