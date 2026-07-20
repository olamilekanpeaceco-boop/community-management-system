<div class="bg-white rounded-lg shadow p-4">
    <h3 class="text-lg font-medium">Notifications</h3>
    <ul class="mt-3 space-y-2">
        @forelse($notifications as $n)
            <li class="flex items-start justify-between">
                <div>
                    <div class="text-sm">{{ data_get($n->data, 'title') ?? class_basename($n->type) }}</div>
                    <div class="text-xs text-gray-400">{{ $n->created_at->diffForHumans() }}</div>
                </div>
                <div class="text-sm text-gray-400">@if($n->read_at) Read @else New @endif</div>
            </li>
        @empty
            <li class="text-sm text-gray-500">No notifications</li>
        @endforelse
    </ul>
</div>
