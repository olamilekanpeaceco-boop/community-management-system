@extends('layouts.app')

@section('head')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Reports</h1>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <form method="GET" action="{{ route('reports.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">From</label>
                <input type="date" name="from" value="{{ request('from') }}" class="mt-1 block w-full border rounded px-3 py-2" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">To</label>
                <input type="date" name="to" value="{{ request('to') }}" class="mt-1 block w-full border rounded px-3 py-2" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Committee</label>
                <input type="text" name="committee_id" value="{{ request('committee_id') }}" placeholder="Committee ID" class="mt-1 block w-full border rounded px-3 py-2" />
            </div>
            <div class="flex items-end">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Apply</button>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        <a href="{{ route('reports.attendance', request()->all()) }}" class="block bg-white p-4 rounded shadow">Attendance Report</a>
        <a href="{{ route('reports.meetings', request()->all()) }}" class="block bg-white p-4 rounded shadow">Meeting Report</a>
        <a href="{{ route('reports.committees', request()->all()) }}" class="block bg-white p-4 rounded shadow">Committee Report</a>
        <a href="{{ route('reports.members', request()->all()) }}" class="block bg-white p-4 rounded shadow">Member Report</a>
    </div>
</div>
@endsection
