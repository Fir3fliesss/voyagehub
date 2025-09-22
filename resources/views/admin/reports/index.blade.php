@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Reports</h1>

    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-xl font-semibold mb-4">Filter Reports</h2>
        <form action="{{ route('admin.reports.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="start_date" class="block text-gray-700 text-sm font-bold mb-2">Start Date:</label>
                <input type="date" name="start_date" id="start_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ request('start_date', \Carbon\Carbon::now()->subMonths(6)->format('Y-m-d')) }}">
            </div>
            <div>
                <label for="end_date" class="block text-gray-700 text-sm font-bold mb-2">End Date:</label>
                <input type="date" name="end_date" id="end_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ request('end_date', \Carbon\Carbon::now()->format('Y-m-d')) }}">
            </div>
            <div class="md:col-span-2">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Apply Filter
                </button>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Trips and Expenses Over Time</h2>
            <div id="tripsExpensesChart"></div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">User Registration Growth</h2>
            <div id="userRegistrationChart"></div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Top 10 Users by Trips</h2>
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">User</th>
                        <th class="py-2 px-4 border-b">Total Trips</th>
                        <th class="py-2 px-4 border-b">Total Expenses</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topUsers as $user)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                        <td class="py-2 px-4 border-b">{{ $user->trips_count }}</td>
                        <td class="py-2 px-4 border-b">{{ number_format($user->trips_sum_cost, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Trip Status Distribution</h2>
            <div id="tripStatusChart"></div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Trips and Expenses Over Time Chart
        var tripsExpensesOptions = {
            series: [{
                name: 'Total Trips',
                data: @json($tripsOverTime->pluck('total_trips'))
            }, {
                name: 'Total Expenses',
                data: @json($tripsOverTime->pluck('total_expenses'))
            }],
            chart: {
                height: 350,
                type: 'area'
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            xaxis: {
                categories: @json($tripsOverTime->pluck('date'))
            },
            tooltip: {
                x: {
                    format: 'dd/MM/yy'
                },
            },
        };
        var tripsExpensesChart = new ApexCharts(document.querySelector("#tripsExpensesChart"), tripsExpensesOptions);
        tripsExpensesChart.render();

        // User Registration Growth Chart
        var userRegistrationOptions = {
            series: [{
                name: 'New Users',
                data: @json($userRegistrations->pluck('total_users'))
            }],
            chart: {
                height: 350,
                type: 'bar'
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: @json($userRegistrations->pluck('date'))
            },
            yaxis: {
                title: {
                    text: '# of Users'
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " users"
                    }
                }
            }
        };
        var userRegistrationChart = new ApexCharts(document.querySelector("#userRegistrationChart"), userRegistrationOptions);
        userRegistrationChart.render();

        // Trip Status Distribution Chart
        var tripStatusOptions = {
            series: @json($tripStatus->pluck('count')),
            chart: {
                width: 380,
                type: 'pie',
            },
            labels: @json($tripStatus->pluck('status')),
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };
        var tripStatusChart = new ApexCharts(document.querySelector("#tripStatusChart"), tripStatusOptions);
        tripStatusChart.render();
    });
</script>
@endpush