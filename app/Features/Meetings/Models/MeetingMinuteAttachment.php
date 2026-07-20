<?php

namespace App\Features\Meetings\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MeetingMinuteAttachment extends Model
{
    use HasUuids;

    // UUID primary key settings
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'meeting_minute_id',
        'file_path',
        'file_type',
        'uploaded_by_id',
    ];

    public function minute()
    {
        return $this->belongsTo(MeetingMinute::class, 'meeting_minute_id');
    }
}
