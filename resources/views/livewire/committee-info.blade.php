<div class="bg-white rounded-lg shadow p-4">
    <h3 class="text-lg font-medium">Committees <span class="text-sm text-gray-500">({{ $activeCount }})</span></h3>
    <ul class="mt-3 space-y-2">
        @forelse($recent as $c)
            <li>
                <div class="font-medium">{{ $c->name }}</div>
            </li>
        @empty
            <li class="text-sm text-gray-500">No committees</li>
        @endforelse
    </ul>
</div>
