<?php

namespace App\Jobs;

use App\Features\Meetings\Exports\MeetingsExport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RunMeetingsExportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $filename;

    public function __construct(string $filename = 'exports/meetings.xlsx')
    {
        $this->filename = $filename;
    }

    public function handle()
    {
        $export = new MeetingsExport();

        // store on private disk
        $disk = config('filesystems.private_disk', config('filesystems.default'));

        // meetings export implements ShouldQueue and chunking; calling store will run the export synchronously in this job
        $export->store($this->filename, $disk);
    }
}
