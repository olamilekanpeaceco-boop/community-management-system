@extends('layouts.guest')
@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="text-center">
        <h1 class="text-5xl font-bold text-gray-900 mb-4">Community Management System</h1>
        <p class="text-xl text-gray-600 mb-8">Manage your community organization efficiently</p>
        <div class="space-x-4">
            @auth
            <a href="{{ route('dashboard') }}" class="inline-block px-8 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition">Go to Dashboard</a>
            @else
            <a href="{{ route('login') }}" class="inline-block px-8 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition">Login</a>
            <a href="{{ route('register') }}" class="inline-block px-8 py-3 bg-gray-300 text-gray-900 rounded-lg font-medium hover:bg-gray-400 transition">Register</a>
            @endauth
        </div>
    </div>
</div>
@endsection
