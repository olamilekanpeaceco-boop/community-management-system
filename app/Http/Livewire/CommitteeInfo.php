<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class CommitteeInfo extends Component
{
    public $activeCount = 0;
    public $recent = [];

    public function mount()
    {
        if (!\Illuminate\Support\Facades\Schema::hasTable('committees')) {
            $this->activeCount = 0;
            $this->recent = [];
            return;
        }

        $this->activeCount = DB::table('committees')->where('status', 'active')->count();

        $this->recent = DB::table('committees')
            ->select('id', 'name')
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.committee-info');
    }
}
