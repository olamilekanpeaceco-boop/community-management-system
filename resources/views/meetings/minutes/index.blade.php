@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">Minutes for: {{ $meeting->title }}</h1>
        <div class="space-x-2">
            <a href="{{ route('meetings.minutes.create', $meeting) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded">New Minutes</a>
            <form action="{{ route('meetings.minutes.search', $meeting) }}" method="GET" class="inline-block">
                <input type="text" name="q" placeholder="Search minutes" value="{{ $q ?? '' }}" class="px-3 py-2 border rounded" />
            </form>
        </div>
    </div>

    <div class="space-y-4">
        @foreach($minutes as $minute)
            <div class="p-4 border rounded bg-white shadow-sm">
                <div class="flex justify-between">
                    <div>
                        <h2 class="font-medium">{{ Str::limit($minute->summary, 120) }}</h2>
                        <p class="text-sm text-gray-500">By {{ $minute->createdBy?->name ?? 'Unknown' }} — {{ $minute->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="space-x-2">
                        <a href="{{ route('meetings.minutes.show', [$meeting, $minute]) }}" class="text-indigo-600">View</a>
                        <a href="{{ route('meetings.minutes.downloadPdf', [$meeting, $minute]) }}" class="text-indigo-600">PDF</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">{{ $minutes->links() }}</div>
</div>
@endsection
