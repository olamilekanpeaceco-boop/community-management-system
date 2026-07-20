@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
<script src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
@endsection

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-4">Edit Memo</h1>

    <form action="{{ route('memos.update', $memo) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        @include('memos._form')

        <div>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Update Memo</button>
            <a href="{{ route('memos.show', $memo) }}" class="ml-2 text-gray-600">Cancel</a>
        </div>
    </form>
</div>
@endsection
