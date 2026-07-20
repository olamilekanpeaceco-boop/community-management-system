<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UnreadMemos extends Component
{
    public $count = 0;
    public $memos = [];

    public function mount()
    {
        $user = Auth::user();
        if (! $user) return;

        // use notifications as the source of unread memos for efficiency
        $query = $user->unreadNotifications()->where('type', 'App\\Notifications\\MemoNotification');
        $this->count = $query->count();
        $this->memos = $query->limit(5)->get()->map(function ($n) {
            return [
                'id' => $n->data['memo_id'] ?? null,
                'title' => $n->data['title'] ?? null,
                'snippet' => $n->data['snippet'] ?? null,
                'created_at' => $n->created_at,
            ];
        });
    }

    public function render()
    {
        return view('livewire.unread-memos');
    }
}
