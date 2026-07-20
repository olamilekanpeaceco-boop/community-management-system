<?php

namespace App\Features\Meetings\Exports;

use App\Features\Meetings\Models\Meeting;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\Exportable;

class MeetingsExport implements FromQuery, WithHeadings, WithChunkReading, ShouldQueue
{
    use Exportable;

    public function query()
    {
        return Meeting::query()->select(['id', 'title', 'committee_id', 'scheduled_at', 'duration_minutes', 'status']);
    }

    public function headings(): array
    {
        return [
            'ID', 'Title', 'Committee ID', 'Scheduled At', 'Duration (minutes)', 'Status'
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
