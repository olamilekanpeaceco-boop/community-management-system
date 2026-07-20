<div class="bg-white rounded-lg shadow p-4">
    <h3 class="text-lg font-medium">Unread Memos <span class="text-sm text-gray-500">({{ $count }})</span></h3>
    <ul class="mt-3 space-y-2">
        @forelse($memos as $m)
            <li>
                <a href="{{ route('memos.show', $m['id']) }}" class="block">
                    <div class="font-medium">{{ $m['title'] }}</div>
                    <div class="text-sm text-gray-500">{{ $m['snippet'] }}</div>
                </a>
            </li>
        @empty
            <li class="text-sm text-gray-500">No unread memos</li>
        @endforelse
    </ul>
</div>
