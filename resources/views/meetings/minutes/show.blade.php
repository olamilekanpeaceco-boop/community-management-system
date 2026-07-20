@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <div class="flex justify-between items-start">
        <h1 class="text-2xl font-semibold">Minutes — {{ $meeting->title }}</h1>
        <div class="space-x-2">
            @can('update', $minute)
            <a href="{{ route('meetings.minutes.edit', [$meeting, $minute]) }}" class="px-3 py-1 bg-yellow-500 text-white rounded">Edit</a>
            @endcan
            @can('delete', $minute)
            <form action="{{ route('meetings.minutes.destroy', [$meeting, $minute]) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete minutes?')">
                @csrf
                @method('DELETE')
                <button class="px-3 py-1 bg-red-600 text-white rounded">Delete</button>
            </form>
            @endcan
            <a href="{{ route('meetings.minutes.downloadPdf', [$meeting, $minute]) }}" class="px-3 py-1 bg-indigo-600 text-white rounded">Download PDF</a>
        </div>
    </div>

    <div class="mt-4 bg-white p-4 border rounded">
        <h2 class="font-semibold">Summary</h2>
        <p class="mt-2">{!! nl2br(e($minute->summary)) !!}</p>

        <h2 class="font-semibold mt-4">Discussion Notes</h2>
        <div class="prose mt-2">{!! is_array($minute->discussion_notes) ? implode('', $minute->discussion_notes) : $minute->discussion_notes !!}</div>

        <h2 class="font-semibold mt-4">Resolutions</h2>
        <ul class="list-disc pl-5 mt-2">
            @foreach($minute->resolutions ?? [] as $res)
                <li>{{ $res['text'] ?? $res }}</li>
            @endforeach
        </ul>

        <h2 class="font-semibold mt-4">Action Items</h2>
        <ul class="list-disc pl-5 mt-2">
            @foreach($minute->action_items ?? [] as $ai)
                <li>{{ $ai['text'] ?? $ai }}</li>
            @endforeach
        </ul>

        <h2 class="font-semibold mt-4">Attachments</h2>
        <ul class="list-disc pl-5 mt-2">
            @foreach($minute->attachments as $att)
                <li><a href="{{ Storage::url($att->file_path) }}" class="text-indigo-600">{{ basename($att->file_path) }}</a></li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
