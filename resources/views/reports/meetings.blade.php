@extends('layouts.app')

@section('head')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Meeting Report</h1>
        <div class="space-x-2">
            <a href="{{ route('reports.export', ['type' => 'meetings', 'format' => 'excel'] + request()->all()) }}" class="px-3 py-2 bg-green-600 text-white rounded">Export Excel</a>
            <a href="{{ route('reports.export', ['type' => 'meetings', 'format' => 'pdf'] + request()->all()) }}" class="px-3 py-2 bg-blue-600 text-white rounded">Export PDF</a>
        </div>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <canvas id="meetingsChart"></canvas>
    </div>

    <div class="bg-white p-4 rounded shadow mt-6">
        <h2 class="font-semibold mb-2">Raw Data</h2>
        <table class="w-full text-left">
            <thead>
                <tr>
                    <th class="p-2">Day</th>
                    <th class="p-2">Status</th>
                    <th class="p-2">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $row)
                    <tr>
                        <td class="p-2">{{ $row->day }}</td>
                        <td class="p-2">{{ $row->status }}</td>
                        <td class="p-2">{{ $row->total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('meetingsChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chart['labels'] ?? []) !!},
            datasets: [{label: 'Meetings', data: {!! json_encode($chart['counts'] ?? []) !!}, backgroundColor: 'rgba(59,130,246,0.5)', fill: true}]
        },
        options: {responsive: true}
    });
});
</script>
@endsection
