<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Collection;
use App\Features\Meetings\Models\Meeting;
use App\Features\Memos\Models\Memo;
use App\Features\Meetings\Models\MeetingMinute;

class RecentActivities extends Component
{
    public $activities = [];

    public function mount()
    {
        // load latest items from several sources and merge-sort by created_at
        $meetings = Meeting::query()->select('id', 'title', 'created_at')->orderBy('created_at', 'desc')->limit(5)->get()->map(function ($m) { return ['type' => 'meeting', 'id' => $m->id, 'title' => $m->title, 'created_at' => $m->created_at]; });
        $memos = Memo::query()->select('id', 'title', 'created_at')->orderBy('created_at', 'desc')->limit(5)->get()->map(function ($m) { return ['type' => 'memo', 'id' => $m->id, 'title' => $m->title, 'created_at' => $m->created_at]; });
        $minutes = MeetingMinute::query()->select('id', 'summary', 'created_at')->orderBy('created_at', 'desc')->limit(5)->get()->map(function ($m) { return ['type' => 'minute', 'id' => $m->id, 'title' => (strlen($m->summary) > 60 ? substr($m->summary, 0, 57) . '...' : $m->summary), 'created_at' => $m->created_at]; });

        $merged = collect()->merge($meetings)->merge($memos)->merge($minutes)->sortByDesc('created_at')->take(10)->values();

        $this->activities = $merged;
    }

    public function render()
    {
        return view('livewire.recent-activities');
    }
}
