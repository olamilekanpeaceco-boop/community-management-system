@extends('layouts.app')
@section('title', 'Create Meeting')
@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-900">Create Meeting</h1>
        </div>
        <form method="POST" action="{{ route('meetings.store') }}" class="px-6 py-4 space-y-6">
            @csrf
            <div>
                <label for="committee_id" class="block text-sm font-medium text-gray-700">Committee *</label>
                <select id="committee_id" name="committee_id" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('committee_id') border-red-500 @enderror">
                    <option value="">Select Committee</option>
                </select>
                @error('committee_id')
                <span class="mt-1 text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Title *</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror">
                @error('title')
                <span class="mt-1 text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                <span class="mt-1 text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="meeting_type" class="block text-sm font-medium text-gray-700">Meeting Type *</label>
                    <select id="meeting_type" name="meeting_type" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="regular">Regular</option>
                        <option value="special">Special</option>
                        <option value="emergency">Emergency</option>
                        <option value="annual">Annual</option>
                    </select>
                </div>
                <div>
                    <label for="scheduled_at" class="block text-sm font-medium text-gray-700">Date & Time *</label>
                    <input type="datetime-local" id="scheduled_at" name="scheduled_at" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('scheduled_at') border-red-500 @enderror">
                    @error('scheduled_at')
                    <span class="mt-1 text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="duration_minutes" class="block text-sm font-medium text-gray-700">Duration (minutes) *</label>
                    <input type="number" id="duration_minutes" name="duration_minutes" value="{{ old('duration_minutes', 60) }}" min="15" max="480" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    @error('duration_minutes')
                    <span class="mt-1 text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="location_type" class="block text-sm font-medium text-gray-700">Location Type *</label>
                    <select id="location_type" name="location_type" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="physical">Physical</option>
                        <option value="virtual">Virtual</option>
                        <option value="hybrid">Hybrid</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                    <input type="text" id="location" name="location" value="{{ old('location') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="room_number" class="block text-sm font-medium text-gray-700">Room Number</label>
                    <input type="text" id="room_number" name="room_number" value="{{ old('room_number') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div>
                <label for="meeting_link" class="block text-sm font-medium text-gray-700">Meeting Link (for virtual/hybrid)</label>
                <input type="url" id="meeting_link" name="meeting_link" value="{{ old('meeting_link') }}" placeholder="https://zoom.us/j/..." class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                @error('meeting_link')
                <span class="mt-1 text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md font-medium hover:bg-blue-700">Create Meeting</button>
                <a href="{{ route('meetings.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md font-medium hover:bg-gray-400">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
