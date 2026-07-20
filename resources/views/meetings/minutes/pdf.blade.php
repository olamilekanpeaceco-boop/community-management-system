@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-xl font-bold">{{ $meeting->title }} — Minutes</h1>
    <div class="mt-4">
        <h2 class="font-semibold">Summary</h2>
        <p>{!! nl2br(e($minute->summary)) !!}</p>

        <h2 class="font-semibold mt-4">Discussion Notes</h2>
        <div class="prose">{!! is_array($minute->discussion_notes) ? implode('', $minute->discussion_notes) : $minute->discussion_notes !!}</div>

        <!-- Other sections identical to show view above -->
    </div>
</div>
@endsection
