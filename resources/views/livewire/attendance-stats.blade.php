<div class="bg-white rounded-lg shadow p-4">
    <h3 class="text-lg font-medium">Attendance (30d)</h3>
    <div class="mt-3">
        <div class="text-sm text-gray-600">Present: <span class="font-medium">{{ $presentCount }}</span></div>
        <div class="text-sm text-gray-600">Absent: <span class="font-medium">{{ $absentCount }}</span></div>
    </div>

    <ul class="mt-3 space-y-2">
        @forelse($recent as $r)
            <li class="text-sm text-gray-500">Meeting {{ $r->meeting_id ?? 'N/A' }} • {{ ucfirst($r->status ?? 'N/A') }} • {{ \Illuminate\Support\Carbon::parse($r->created_at)->diffForHumans() }}</li>
        @empty
            <li class="text-sm text-gray-500">No recent attendance records</li>
        @endforelse
    </ul>
</div>
