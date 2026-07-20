<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationsWidget extends Component
{
    public $notifications = [];

    public function mount()
    {
        $user = Auth::user();
        if (! $user) return;

        $this->notifications = $user->notifications()->orderBy('created_at', 'desc')->limit(10)->get(['id', 'type', 'data', 'read_at', 'created_at']);
    }

    public function render()
    {
        return view('livewire.notifications-widget');
    }
}
