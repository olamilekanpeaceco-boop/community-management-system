<?php

namespace App\Features\Meetings\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Meeting extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = [
        'committee_id',
        'title',
        'slug',
        'description',
        'meeting_type',
        'scheduled_at',
        'duration_minutes',
        'location_type',
        'location',
        'meeting_link',
        'room_number',
        'organizer_id',
        'status',
        'cancelled_reason',
        'cancelled_at',
        'is_recurring',
        'recurrence_pattern',
        'recurrence_end_date',
        'reminder_sent_at',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_at' => 'datetime',
            'cancelled_at' => 'datetime',
            'reminder_sent_at' => 'datetime',
            'recurrence_end_date' => 'date',
            'is_recurring' => 'boolean',
        ];
    }

    public function committee()
    {
        return $this->belongsTo(Committee::class);
    }

    public function organizer()
    {
        return $this->belongsTo(Member::class);
    }

    public function agendas()
    {
        return $this->hasMany(MeetingAgenda::class);
    }

    public function minutes()
    {
        return $this->hasOne(MeetingMinute::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function documents()
    {
        return $this->hasMany(MeetingDocument::class);
    }
}
