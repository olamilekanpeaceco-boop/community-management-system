@extends('layouts.guest')
@section('title', 'Verify Email')
@section('content')
<div class="mb-4 text-sm text-gray-600">Thanks for signing up! Verify your email address by clicking the link we sent you. If you didn't receive it, we'll send another.</div>
@if (session('status') == 'verification-link-sent')
<div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">A new verification link has been sent to your email.</div>
@endif
<form method="POST" action="{{ route('verification.send') }}" class="mb-4">
    @csrf
    <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Resend Verification Email</button>
</form>
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="w-full px-4 py-2 bg-gray-300 text-gray-700 rounded-md font-medium hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">Log Out</button>
</form>
@endsection
