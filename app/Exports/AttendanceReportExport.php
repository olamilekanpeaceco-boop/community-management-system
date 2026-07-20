<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class AttendanceReportExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = DB::table('attendances')->select('id', 'meeting_id', 'member_id', 'status', 'created_at');

        if (! empty($this->filters['from'])) $query->whereDate('created_at', '>=', $this->filters['from']);
        if (! empty($this->filters['to'])) $query->whereDate('created_at', '<=', $this->filters['to']);
        if (! empty($this->filters['committee_id'])) {
            if (Schema::hasColumn('attendances', 'committee_id')) {
                $query->where('committee_id', $this->filters['committee_id']);
            } else {
                $query->join('meetings', 'attendances.meeting_id', '=', 'meetings.id')->where('meetings.committee_id', $this->filters['committee_id']);
            }
        }

        return $query->orderBy('created_at')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Meeting ID', 'Member ID', 'Status', 'Recorded At'];
    }
}
