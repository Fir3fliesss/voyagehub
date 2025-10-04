<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'General Report' }}</title>
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

        .content {
            margin: 20px 0;
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

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .fw-bold { font-weight: bold; }
        .text-primary { color: #2563eb; }
        .text-success { color: #059669; }
        .text-danger { color: #dc2626; }
        .text-warning { color: #f59e0b; }
        .text-muted { color: #6b7280; }

        .badge {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            color: white;
        }

        .badge-primary { background-color: #2563eb; }
        .badge-success { background-color: #10b981; }
        .badge-danger { background-color: #ef4444; }
        .badge-warning { background-color: #f59e0b; }
        .badge-info { background-color: #06b6d4; }

        .mb-1 { margin-bottom: 0.25rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-3 { margin-bottom: 1rem; }
        .mt-3 { margin-top: 1rem; }
        .p-3 { padding: 1rem; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title ?? 'General Report' }}</h1>
        <div class="subtitle">VoyageHub Travel Management System</div>
        <div class="subtitle">Generated on {{ now()->format('F d, Y \a\t H:i') }}</div>
    </div>

    @if(!empty($filters))
        <div class="filters">
            <h3>Applied Filters:</h3>
            @foreach($filters as $key => $value)
                @if($value)
                    <div class="filter-item">
                        <span class="filter-label">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                        @if($key === 'start_date' || $key === 'end_date')
                            {{ \Carbon\Carbon::parse($value)->format('M d, Y') }}
                        @else
                            {{ is_array($value) ? implode(', ', $value) : $value }}
                        @endif
                    </div>
                @endif
            @endforeach
        </div>
    @endif

    <div class="content">
        @if(isset($reportType) && isset($data))
            @if($reportType === 'summary')
                <!-- Summary Report -->
                <div class="summary mb-3">
                    <h3>Summary Statistics</h3>
                    <div class="summary-item">
                        <strong>Total Journeys:</strong> {{ $data['stats']['total_journeys'] ?? 0 }}
                    </div>
                    <div class="summary-item">
                        <strong>Total Budget:</strong> Rp {{ number_format($data['stats']['total_budget'] ?? 0, 0, ',', '.') }}
                    </div>
                    <div class="summary-item">
                        <strong>Pending Requests:</strong> {{ $data['stats']['pending_requests'] ?? 0 }}
                    </div>
                    <div class="summary-item">
                        <strong>Approved Requests:</strong> {{ $data['stats']['approved_requests'] ?? 0 }}
                    </div>
                    <div class="summary-item">
                        <strong>Rejected Requests:</strong> {{ $data['stats']['rejected_requests'] ?? 0 }}
                    </div>
                </div>

                @if(isset($data['journeys']) && $data['journeys']->count() > 0)
                    <h3 class="mt-3">Recent Journeys</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Traveler</th>
                                <th>Title</th>
                                <th>Destination</th>
                                <th>Date</th>
                                <th>Budget</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['journeys']->take(10) as $journey)
                                <tr>
                                    <td>{{ $journey->user->name ?? 'N/A' }}</td>
                                    <td>{{ $journey->title }}</td>
                                    <td>{{ $journey->destination }}</td>
                                    <td>{{ $journey->start_date instanceof \Carbon\Carbon ? $journey->start_date->format('M d, Y') : $journey->start_date }}</td>
                                    <td class="text-right">Rp {{ number_format($journey->budget, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

            @elseif($reportType === 'detailed')
                <!-- Detailed Report -->
                @if(isset($data['journeys']) && $data['journeys']->count() > 0)
                    <h3>All Journeys ({{ $data['journeys']->count() }} total)</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th width="15%">Traveler</th>
                                <th width="20%">Title</th>
                                <th width="15%">Destination</th>
                                <th width="12%">Start Date</th>
                                <th width="12%">End Date</th>
                                <th width="12%">Transport</th>
                                <th width="9%">Budget</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['journeys'] as $journey)
                                <tr>
                                    <td>{{ $journey->id }}</td>
                                    <td>{{ $journey->user->name ?? 'N/A' }}</td>
                                    <td>{{ $journey->title }}</td>
                                    <td>{{ $journey->destination }}</td>
                                    <td>{{ $journey->start_date instanceof \Carbon\Carbon ? $journey->start_date->format('M d') : $journey->start_date }}</td>
                                    <td>{{ $journey->end_date ? ($journey->end_date instanceof \Carbon\Carbon ? $journey->end_date->format('M d') : $journey->end_date) : 'Open' }}</td>
                                    <td>{{ $journey->transport ?: '-' }}</td>
                                    <td class="text-right">{{ number_format($journey->budget / 1000000, 1) }}M</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                @if(isset($data['requests']) && $data['requests']->count() > 0)
                    <div class="page-break"></div>
                    <h3>All Travel Requests ({{ $data['requests']->count() }} total)</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th width="15%">Requester</th>
                                <th width="20%">Title</th>
                                <th width="15%">Destination</th>
                                <th width="10%">Status</th>
                                <th width="12%">Budget</th>
                                <th width="12%">Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['requests'] as $request)
                                <tr>
                                    <td>{{ $request->id }}</td>
                                    <td>{{ $request->user->name ?? 'N/A' }}</td>
                                    <td>{{ $request->title }}</td>
                                    <td>{{ $request->destination }}</td>
                                    <td>
                                        <span class="badge badge-{{ $request->status === 'approved' ? 'success' : ($request->status === 'rejected' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </td>
                                    <td class="text-right">{{ number_format($request->budget / 1000000, 1) }}M</td>
                                    <td>{{ $request->created_at instanceof \Carbon\Carbon ? $request->created_at->format('M d') : $request->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

            @elseif($reportType === 'budget_analysis')
                <!-- Budget Analysis Report -->
                @if(isset($data['budget_by_user']) && !empty($data['budget_by_user']))
                    <h3>Budget Analysis by User</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th class="text-center">Total Trips</th>
                                <th class="text-right">Total Budget</th>
                                <th class="text-right">Average Budget</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['budget_by_user'] as $userName => $userBudget)
                                <tr>
                                    <td>{{ $userName }}</td>
                                    <td class="text-center">{{ $userBudget['trip_count'] }}</td>
                                    <td class="text-right">Rp {{ number_format($userBudget['total_budget'], 0, ',', '.') }}</td>
                                    <td class="text-right">Rp {{ number_format($userBudget['avg_budget'], 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                @if(isset($data['budget_by_destination']) && !empty($data['budget_by_destination']))
                    <h3 class="mt-3">Budget Analysis by Destination</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Destination</th>
                                <th class="text-center">Total Trips</th>
                                <th class="text-right">Total Budget</th>
                                <th class="text-right">Average Budget</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['budget_by_destination'] as $destination => $destBudget)
                                <tr>
                                    <td>{{ $destination }}</td>
                                    <td class="text-center">{{ $destBudget['trip_count'] }}</td>
                                    <td class="text-right">Rp {{ number_format($destBudget['total_budget'], 0, ',', '.') }}</td>
                                    <td class="text-right">Rp {{ number_format($destBudget['total_budget'] / $destBudget['trip_count'], 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            @endif
        @elseif(isset($content))
            {!! $content !!}
        @else
            <p>No content available for this report.</p>
        @endif
    </div>

    @if(isset($summary) && !empty($summary))
        <div class="summary">
            <h3>Summary</h3>
            @foreach($summary as $key => $value)
                <div class="summary-item">
                    <strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> {{ $value }}
                </div>
            @endforeach
        </div>
    @endif

    <div class="footer">
        <div>© {{ date('Y') }} VoyageHub Travel Management System</div>
        <div>This report is generated automatically and contains confidential information</div>
    </div>
</body>
</html>