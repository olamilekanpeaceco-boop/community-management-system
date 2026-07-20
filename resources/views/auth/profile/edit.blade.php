@extends('layouts.app')
@section('title', 'Edit Profile')
@section('content')
<div class="max-w-2xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-900">Edit Profile</h1>
        </div>
        <div class="px-6 py-4">
            <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                @csrf
                @method('PATCH')
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror">
                    @error('name')
                    <span class="mt-1 text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror">
                    @error('email')
                    <span class="mt-1 text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @enderror">
                    @error('phone')
                    <span class="mt-1 text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
                    <textarea id="bio" name="bio" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('bio') border-red-500 @enderror">{{ old('bio', Auth::user()->bio) }}</textarea>
                    @error('bio')
                    <span class="mt-1 text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex space-x-4">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md font-medium hover:bg-blue-700">Save Changes</button>
                    <a href="{{ route('profile.show') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md font-medium hover:bg-gray-400">Cancel</a>
                </div>
            </form>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow mt-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900">Profile Picture</h2>
        </div>
        <div class="px-6 py-4">
            <div class="flex items-center space-x-6">
                <div>
                    <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="h-24 w-24 rounded-full object-cover border-4 border-blue-500">
                </div>
                <div class="flex-1">
                    <form method="POST" action="{{ route('profile.avatar') }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label for="avatar" class="block text-sm font-medium text-gray-700">Upload New Picture</label>
                            <input type="file" id="avatar" name="avatar" accept="image/*" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('avatar') border-red-500 @enderror">
                            @error('avatar')
                            <span class="mt-1 text-sm text-red-600">{{ $message }}</span>
                            @enderror
                            <p class="mt-2 text-xs text-gray-500">Max 5MB, JPG/PNG/GIF/WebP</p>
                        </div>
                        <div class="flex space-x-4">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md font-medium hover:bg-blue-700">Upload</button>
                            @if (Auth::user()->avatar_url && !str_contains(Auth::user()->avatar_url, 'ui-avatars.com'))
                            <form method="POST" action="{{ route('profile.avatar.delete') }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md font-medium hover:bg-red-700" onclick="return confirm('Are you sure?')">Remove</button>
                            </form>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
