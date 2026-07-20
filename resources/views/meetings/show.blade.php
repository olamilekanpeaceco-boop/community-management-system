@extends('layouts.app')
@section('title', $meeting->title)
@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $meeting->title }}</h1>
                <p class="text-gray-600 text-sm mt-1">{{ $meeting->meeting_type }} Meeting</p>
            </div>
            <div>
                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $meeting->status === 'completed' ? 'bg-green-100 text-green-800' : ($meeting->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">{{ ucfirst($meeting->status) }}</span>
            </div>
        </div>

        <div class="px-6 py-4 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Committee</label>
                    <p class="mt-1 text-gray-900">{{ $meeting->committee?->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Organizer</label>
                    <p class="mt-1 text-gray-900">{{ $meeting->organizer?->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Date & Time</label>
                    <p class="mt-1 text-gray-900">{{ $meeting->scheduled_at->format('M d, Y H:i') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Duration</label>
                    <p class="mt-1 text-gray-900">{{ $meeting->duration_minutes }} minutes</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Location Type</label>
                    <p class="mt-1 text-gray-900">{{ ucfirst($meeting->location_type) }}</p>
                </div>
                @if($meeting->location)
                <div>
                    <label class="block text-sm font-medium text-gray-700">Location</label>
                    <p class="mt-1 text-gray-900">{{ $meeting->location }}</p>
                </div>
                @endif
                @if($meeting->room_number)
                <div>
                    <label class="block text-sm font-medium text-gray-700">Room Number</label>
                    <p class="mt-1 text-gray-900">{{ $meeting->room_number }}</p>
                </div>
                @endif
                @if($meeting->meeting_link)
                <div>
                    <label class="block text-sm font-medium text-gray-700">Meeting Link</label>
                    <a href="{{ $meeting->meeting_link }}" target="_blank" class="mt-1 text-blue-600 hover:text-blue-900">{{ $meeting->meeting_link }}</a>
                </div>
                @endif
            </div>

            @if($meeting->description)
            <div>
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <p class="mt-1 text-gray-900">{{ $meeting->description }}</p>
            </div>
            @endif

            <div class="flex space-x-4 border-t pt-4">
                @can('update', $meeting)
                <a href="{{ route('meetings.edit', $meeting) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-md font-medium hover:bg-yellow-700">Edit</a>
                @endcan
                <a href="{{ route('meetings.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md font-medium hover:bg-gray-400">Back to Meetings</a>
            </div>
        </div>
    </div>
</div>
@endsection
