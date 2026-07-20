@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <div class="flex justify-between items-start">
        <h1 class="text-2xl font-semibold">{{ $memo->title }}</h1>
        <div class="space-x-2">
            @can('update', $memo)
            <a href="{{ route('memos.edit', $memo) }}" class="px-3 py-1 bg-yellow-500 text-white rounded">Edit</a>
            @endcan
            @can('delete', $memo)
            <form action="{{ route('memos.destroy', $memo) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete memo?')">
                @csrf
                @method('DELETE')
                <button class="px-3 py-1 bg-red-600 text-white rounded">Delete</button>
            </form>
            @endcan
        </div>
    </div>

    <div class="mt-4 bg-white p-4 border rounded">
        <h2 class="font-semibold">Message</h2>
        <div class="prose mt-2">{!! $memo->body !!}</div>

        <h2 class="font-semibold mt-4">Attachments</h2>
        <ul class="list-disc pl-5 mt-2">
            @foreach($memo->attachments as $att)
                <li><a href="{{ Storage::url($att->file_path) }}" class="text-indigo-600">{{ basename($att->file_path) }}</a></li>
            @endforeach
        </ul>

        <h2 class="font-semibold mt-4">Recipients</h2>
        <ul class="list-disc pl-5 mt-2">
            @foreach($memo->recipients as $r)
                <li>{{ ucfirst($r->recipient_type) }} @if($r->recipient_id) - {{ $r->recipient_id }} @endif</li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
