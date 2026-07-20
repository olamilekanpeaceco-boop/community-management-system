<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MeetingReportExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = DB::table('meetings')->select('id', 'title', 'scheduled_at', 'status', 'committee_id');

        if (! empty($this->filters['from'])) $query->whereDate('scheduled_at', '>=', $this->filters['from']);
        if (! empty($this->filters['to'])) $query->whereDate('scheduled_at', '<=', $this->filters['to']);
        if (! empty($this->filters['committee_id'])) $query->where('committee_id', $this->filters['committee_id']);

        return $query->orderBy('scheduled_at')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Title', 'Scheduled At', 'Status', 'Committee ID'];
    }
}
