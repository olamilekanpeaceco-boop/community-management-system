@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">Memos</h1>
        @can('create', App\Features\Memos\Models\Memo::class)
        <a href="{{ route('memos.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded">New Memo</a>
        @endcan
    </div>

    <div class="space-y-4">
        @foreach($memos as $memo)
            <div class="p-4 border rounded bg-white shadow-sm">
                <div class="flex justify-between">
                    <div>
                        <h2 class="font-medium">{{ $memo->title }}</h2>
                        <p class="text-sm text-gray-500">By {{ $memo->creator?->name ?? 'Unknown' }} — {{ $memo->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="space-x-2">
                        <a href="{{ route('memos.show', $memo) }}" class="text-indigo-600">View</a>
                        @can('update', $memo)
                        <a href="{{ route('memos.edit', $memo) }}" class="text-yellow-600">Edit</a>
                        @endcan
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">{{ $memos->links() }}</div>
</div>
@endsection
