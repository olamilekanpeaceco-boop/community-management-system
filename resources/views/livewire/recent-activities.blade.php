<div class="bg-white rounded-lg shadow p-4">
    <h3 class="text-lg font-medium">Recent Activities</h3>
    <ul class="mt-3 space-y-2">
        @forelse($activities as $a)
            <li class="text-sm">
                <div class="font-medium">{{ ucfirst($a['type']) }}: {{ $a['title'] }}</div>
                <div class="text-xs text-gray-400">{{ \Illuminate\Support\Carbon::parse($a['created_at'])->diffForHumans() }}</div>
            </li>
        @empty
            <li class="text-sm text-gray-500">No recent activity</li>
        @endforelse
    </ul>
</div>
