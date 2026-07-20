<?php

namespace App\Features\Meetings\Services;

use App\Features\Meetings\Models\Meeting;
use Illuminate\Support\Str;

class MeetingService
{
    public function createMeeting(array $data): Meeting
    {
        $data['slug'] = Str::slug($data['title']);
        $data['organizer_id'] = auth()->user()->id;
        $data['status'] = 'scheduled';

        return Meeting::create($data);
    }

    public function updateMeeting(Meeting $meeting, array $data): Meeting
    {
        $data['slug'] = Str::slug($data['title']);
        $meeting->update($data);
        return $meeting->refresh();
    }

    public function deleteMeeting(Meeting $meeting): void
    {
        $meeting->delete();
    }

    public function cancelMeeting(Meeting $meeting, string $reason): Meeting
    {
        $meeting->update([
            'status' => 'cancelled',
            'cancelled_reason' => $reason,
            'cancelled_at' => now(),
        ]);
        return $meeting->refresh();
    }
}
