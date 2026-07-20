@extends('layouts.guest')
@section('title', 'Login')
@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror">
        @error('email')
        <span class="mt-1 text-sm text-red-600">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input type="password" id="password" name="password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror">
        @error('password')
        <span class="mt-1 text-sm text-red-600">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-6 flex items-center">
        <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
        <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
    </div>
    <div class="flex items-center justify-between">
        <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-700">Forgot password?</a>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Sign in</button>
    </div>
    <div class="mt-6 text-center">
        <p class="text-sm text-gray-600">Don't have an account? <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 font-medium">Register here</a></p>
    </div>
</form>
@endsection
