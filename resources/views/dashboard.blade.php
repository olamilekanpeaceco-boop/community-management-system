@extends('layouts.app')

@section('head')
    @livewireStyles
@endsection

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <div class="col-span-1">
                @livewire('member-count')
            </div>

            <div class="col-span-2 md:col-span-1">
                @livewire('upcoming-meetings')
            </div>

            <div class="col-span-1 md:col-span-2 lg:col-span-1">
                @livewire('unread-memos')
            </div>

            <div class="col-span-1">
                @livewire('notifications-widget')
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
            <div class="lg:col-span-2 space-y-6">
                @livewire('latest-minutes')
                @livewire('recent-activities')
            </div>

            <div class="space-y-6">
                @livewire('committee-info')
                @livewire('attendance-stats')
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @livewireScripts
@endsection
