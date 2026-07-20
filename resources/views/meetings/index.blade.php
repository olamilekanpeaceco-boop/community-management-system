@extends('layouts.app')
@section('title', 'Meetings')
@section('content')
<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Meetings</h1>
        @can('create', App\Features\Meetings\Models\Meeting::class)
        <a href="{{ route('meetings.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md font-medium hover:bg-blue-700">New Meeting</a>
        @endcan
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Committee</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($meetings as $meeting)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $meeting->title }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $meeting->committee?->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $meeting->scheduled_at->format('M d, Y H:i') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $meeting->status === 'completed' ? 'bg-green-100 text-green-800' : ($meeting->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">{{ ucfirst($meeting->status) }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                        <a href="{{ route('meetings.show', $meeting) }}" class="text-blue-600 hover:text-blue-900">View</a>
                        @can('update', $meeting)
                        <a href="{{ route('meetings.edit', $meeting) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-600">No meetings found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $meetings->links() }}
    </div>
</div>
@endsection
