<?php

namespace App\Features\Meetings\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MeetingAgenda extends Model
{
    use HasUuids;

    protected $fillable = [
        'meeting_id',
        'item_number',
        'title',
        'description',
        'presenter_id',
        'estimated_duration_minutes',
        'discussion_points',
        'materials_url',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'discussion_points' => 'array',
        ];
    }

    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }
}
