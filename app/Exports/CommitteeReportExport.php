<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CommitteeReportExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = DB::table('committees')->select('id', 'name');
        $query->leftJoin('committee_members', 'committees.id', '=', 'committee_members.committee_id')
            ->selectRaw('committees.id, committees.name, COUNT(committee_members.member_id) as member_count')
            ->groupBy('committees.id', 'committees.name');

        if (! empty($this->filters['committee_id'])) $query->where('committees.id', $this->filters['committee_id']);

        return $query->get();
    }

    public function headings(): array
    {
        return ['ID', 'Name', 'Member Count'];
    }
}
