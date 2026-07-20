@extends('layouts.app')
@section('title', 'Edit Meeting')
@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-900">Edit Meeting</h1>
        </div>
        <form method="POST" action="{{ route('meetings.update', $meeting) }}" class="px-6 py-4 space-y-6">
            @csrf
            @method('PATCH')
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Title *</label>
                <input type="text" id="title" name="title" value="{{ old('title', $meeting->title) }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror">
                @error('title')
                <span class="mt-1 text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description', $meeting->description) }}</textarea>
                @error('description')
                <span class="mt-1 text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="scheduled_at" class="block text-sm font-medium text-gray-700">Date & Time *</label>
                    <input type="datetime-local" id="scheduled_at" name="scheduled_at" value="{{ old('scheduled_at', $meeting->scheduled_at->format('Y-m-d\TH:i')) }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('scheduled_at') border-red-500 @enderror">
                    @error('scheduled_at')
                    <span class="mt-1 text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="duration_minutes" class="block text-sm font-medium text-gray-700">Duration (minutes) *</label>
                    <input type="number" id="duration_minutes" name="duration_minutes" value="{{ old('duration_minutes', $meeting->duration_minutes) }}" min="15" max="480" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    @error('duration_minutes')
                    <span class="mt-1 text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="location_type" class="block text-sm font-medium text-gray-700">Location Type *</label>
                    <select id="location_type" name="location_type" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="physical" {{ old('location_type', $meeting->location_type) === 'physical' ? 'selected' : '' }}>Physical</option>
                        <option value="virtual" {{ old('location_type', $meeting->location_type) === 'virtual' ? 'selected' : '' }}>Virtual</option>
                        <option value="hybrid" {{ old('location_type', $meeting->location_type) === 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                    <input type="text" id="location" name="location" value="{{ old('location', $meeting->location) }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="room_number" class="block text-sm font-medium text-gray-700">Room Number</label>
                    <input type="text" id="room_number" name="room_number" value="{{ old('room_number', $meeting->room_number) }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div>
                <label for="meeting_link" class="block text-sm font-medium text-gray-700">Meeting Link</label>
                <input type="url" id="meeting_link" name="meeting_link" value="{{ old('meeting_link', $meeting->meeting_link) }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md font-medium hover:bg-blue-700">Update Meeting</button>
                <a href="{{ route('meetings.show', $meeting) }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md font-medium hover:bg-gray-400">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
