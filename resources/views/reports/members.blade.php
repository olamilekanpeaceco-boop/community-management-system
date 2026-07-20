@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Member Report</h1>
        <div class="space-x-2">
            <a href="{{ route('reports.export', ['type' => 'members', 'format' => 'excel'] + request()->all()) }}" class="px-3 py-2 bg-green-600 text-white rounded">Export Excel</a>
            <a href="{{ route('reports.export', ['type' => 'members', 'format' => 'pdf'] + request()->all()) }}" class="px-3 py-2 bg-blue-600 text-white rounded">Export PDF</a>
        </div>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <h2 class="font-semibold mb-2">Members</h2>
        <table class="w-full text-left">
            <thead>
                <tr>
                    <th class="p-2">Name</th>
                    <th class="p-2">Email</th>
                    <th class="p-2">Joined</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $user)
                    <tr>
                        <td class="p-2">{{ $user->name }}</td>
                        <td class="p-2">{{ $user->email }}</td>
                        <td class="p-2">{{ optional($user->created_at)->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">{{ $data->links() }}</div>
    </div>
</div>
@endsection
