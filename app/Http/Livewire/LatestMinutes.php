<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Features\Meetings\Models\MeetingMinute;

class LatestMinutes extends Component
{
    public $minutes = [];

    public function mount()
    {
        $this->minutes = MeetingMinute::query()
            ->with('meeting')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get(['id', 'meeting_id', 'summary', 'created_at']);
    }

    public function render()
    {
        return view('livewire.latest-minutes');
    }
}
