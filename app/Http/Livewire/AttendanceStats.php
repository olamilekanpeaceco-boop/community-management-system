<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AttendanceStats extends Component
{
    public $presentCount = 0;
    public $absentCount = 0;
    public $recent = [];

    public function mount()
    {
        if (! Schema::hasTable('attendances') && ! Schema::hasTable('attendance')) {
            $this->presentCount = 0;
            $this->absentCount = 0;
            $this->recent = [];
            return;
        }

        $table = Schema::hasTable('attendances') ? 'attendances' : 'attendance';

        // efficient aggregate: count present vs absent in last 30 days
        $stats = DB::table($table)
            ->selectRaw("SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present, SUM(CASE WHEN status = 'absent' THEN 1 ELSE 0 END) as absent")
            ->where('created_at', '>=', now()->subDays(30))
            ->first();

        $this->presentCount = $stats->present ?? 0;
        $this->absentCount = $stats->absent ?? 0;

        $this->recent = DB::table($table)
            ->select('id', 'meeting_id', 'member_id', 'status', 'created_at')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.attendance-stats');
    }
}
