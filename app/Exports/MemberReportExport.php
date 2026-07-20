<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MemberReportExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = DB::table('users')->select('id', 'name', 'email', 'is_active', 'created_at');

        if (! empty($this->filters['from'])) $query->whereDate('created_at', '>=', $this->filters['from']);
        if (! empty($this->filters['to'])) $query->whereDate('created_at', '<=', $this->filters['to']);
        if (! empty($this->filters['committee_id'])) {
            $query->whereExists(function ($q) {
                $q->select(DB::raw(1))->from('committee_members')->whereRaw('committee_members.member_id = users.id');
            });
        }

        return $query->orderBy('created_at')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Name', 'Email', 'Active', 'Joined At'];
    }
}
