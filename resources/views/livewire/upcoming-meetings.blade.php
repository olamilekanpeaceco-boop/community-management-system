<div class="bg-white rounded-lg shadow p-4">
    <h3 class="text-lg font-medium">Upcoming Meetings</h3>
    <ul class="mt-3 space-y-2">
        @forelse($meetings as $m)
            <li class="flex items-start justify-between">
                <div>
                    <div class="font-medium">{{ $m->title }}</div>
                    <div class="text-sm text-gray-500">{{ 
                        \Illuminate\Support\Carbon::parse($m->scheduled_at)->format('M d, Y H:i') }} @if($m->committee) • {{ $m->committee->name }} @endif</div>
                </div>
                <div class="text-sm text-gray-400">&nbsp;</div>
            </li>
        @empty
            <li class="text-sm text-gray-500">No upcoming meetings</li>
        @endforelse
    </ul>
</div>
