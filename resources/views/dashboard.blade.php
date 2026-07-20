@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="px-6 py-4">
                <h1 class="text-3xl font-bold text-gray-900">Welcome, {{ Auth::user()->name }}</h1>
                <p class="text-gray-600 mt-2">You are logged in to the Community Management System.</p>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="text-gray-500 text-sm font-medium">Total Members</div>
                <div class="mt-2 text-3xl font-bold text-gray-900">0</div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="text-gray-500 text-sm font-medium">Active Committees</div>
                <div class="mt-2 text-3xl font-bold text-gray-900">0</div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="text-gray-500 text-sm font-medium">Upcoming Meetings</div>
                <div class="mt-2 text-3xl font-bold text-gray-900">0</div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="text-gray-500 text-sm font-medium">Pending Tasks</div>
                <div class="mt-2 text-3xl font-bold text-gray-900">0</div>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Coming Soon</h2>
            <ul class="space-y-2 text-gray-600">
                <li>✓ Member Management</li>
                <li>✓ Committee Management</li>
                <li>✓ Meeting Scheduling</li>
                <li>✓ Attendance Tracking</li>
                <li>✓ Document Management</li>
                <li>✓ Reports & Analytics</li>
            </ul>
        </div>
    </div>
</div>
@endsection
