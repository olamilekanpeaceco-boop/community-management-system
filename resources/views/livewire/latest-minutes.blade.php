<div class="bg-white rounded-lg shadow p-4">
    <h3 class="text-lg font-medium">Latest Meeting Minutes</h3>
    <ul class="mt-3 space-y-2">
        @forelse($minutes as $m)
            <li>
                <a href="{{ route('meetings.minutes.show', [$m->meeting_id ?? null, $m->id]) }}" class="block">
                    <div class="font-medium">{{ \Illuminate\Support\Str::limit($m->summary, 80) }}</div>
                    <div class="text-xs text-gray-400">{{ $m->created_at->diffForHumans() }}</div>
                </a>
            </li>
        @empty
            <li class="text-sm text-gray-500">No minutes yet</li>
        @endforelse
    </ul>
</div>
