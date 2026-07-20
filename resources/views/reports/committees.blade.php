@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Committee Report</h1>
        <div class="space-x-2">
            <a href="{{ route('reports.export', ['type' => 'committees', 'format' => 'excel'] + request()->all()) }}" class="px-3 py-2 bg-green-600 text-white rounded">Export Excel</a>
            <a href="{{ route('reports.export', ['type' => 'committees', 'format' => 'pdf'] + request()->all()) }}" class="px-3 py-2 bg-blue-600 text-white rounded">Export PDF</a>
        </div>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <canvas id="committeeChart"></canvas>
    </div>

    <div class="bg-white p-4 rounded shadow mt-6">
        <h2 class="font-semibold mb-2">Committees</h2>
        <table class="w-full text-left">
            <thead>
                <tr>
                    <th class="p-2">Name</th>
                    <th class="p-2">Member Count</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $row)
                    <tr>
                        <td class="p-2">{{ $row->name }}</td>
                        <td class="p-2">{{ $row->member_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('committeeChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chart['labels'] ?? []) !!},
            datasets: [{label: 'Members', data: {!! json_encode($chart['counts'] ?? []) !!}, backgroundColor: 'rgba(99,102,241,0.7)'}]
        },
        options: {responsive: true}
    });
});
</script>
@endsection
