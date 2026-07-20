@extends('layouts.guest')
@section('title', 'Forgot Password')
@section('content')
<div class="mb-4 text-sm text-gray-600">Forgot your password? Let us know your email and we'll send you a reset link.</div>
@if (session('status'))
<div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">{{ session('status') }}</div>
@endif
<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror">
        @error('email')
        <span class="mt-1 text-sm text-red-600">{{ $message }}</span>
        @enderror
    </div>
    <div class="flex items-center justify-between">
        <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:text-blue-700">Back to login</a>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Send Reset Link</button>
    </div>
</form>
@endsection
