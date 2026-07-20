<?php

namespace App\Features\Meetings\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MeetingMinute extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    // UUID primary key settings
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'meeting_id',
        'summary',
        'discussion_notes',
        'resolutions',
        'action_items',
        'assigned_tasks',
        'created_by_id',
        'pdf_path',
    ];

    protected function casts(): array
    {
        return [
            'discussion_notes' => 'array',
            'resolutions' => 'array',
            'action_items' => 'array',
            'assigned_tasks' => 'array',
        ];
    }

    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by_id');
    }

    public function attachments()
    {
        return $this->hasMany(MeetingMinuteAttachment::class);
    }
}
