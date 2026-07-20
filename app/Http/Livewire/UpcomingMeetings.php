<?php

namespace App\Http\Livewire;

use App\Features\Meetings\Models\Meeting;
use Livewire\Component;
use Illuminate\Support\Carbon;

class UpcomingMeetings extends Component
{
    public $meetings;

    public function mount()
    {
        $this->meetings = Meeting::query()
            ->where('scheduled_at', '>=', Carbon::now())
            ->with(['committee'])
            ->orderBy('scheduled_at', 'asc')
            ->limit(5)
            ->get(['id', 'title', 'scheduled_at', 'committee_id']);
    }

    public function render()
    {
        return view('livewire.upcoming-meetings');
    }
}
