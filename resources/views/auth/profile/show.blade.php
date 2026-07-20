@extends('layouts.app')
@section('title', 'My Profile')
@section('content')
<div class="max-w-2xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-900">My Profile</h1>
        </div>
        <div class="px-6 py-4">
            <div class="flex items-center mb-6">
                <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="h-24 w-24 rounded-full object-cover border-4 border-blue-500">
                <div class="ml-6">
                    <h2 class="text-2xl font-bold text-gray-900">{{ Auth::user()->name }}</h2>
                    <p class="text-gray-600">{{ Auth::user()->email }}</p>
                    @if (Auth::user()->phone)
                    <p class="text-gray-600">{{ Auth::user()->phone }}</p>
                    @endif
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <p class="mt-1 text-gray-900">{{ Auth::user()->name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <p class="mt-1 text-gray-900">{{ Auth::user()->email }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Phone</label>
                    <p class="mt-1 text-gray-900">{{ Auth::user()->phone ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Member Since</label>
                    <p class="mt-1 text-gray-900">{{ Auth::user()->created_at->format('M d, Y') }}</p>
                </div>
            </div>
            @if (Auth::user()->bio)
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Bio</label>
                <p class="mt-1 text-gray-900">{{ Auth::user()->bio }}</p>
            </div>
            @endif
            <div class="flex space-x-4">
                <a href="{{ route('profile.edit') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md font-medium hover:bg-blue-700">Edit Profile</a>
                <a href="{{ route('password.change') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md font-medium hover:bg-gray-700">Change Password</a>
            </div>
        </div>
    </div>
</div>
@endsection
