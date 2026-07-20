<?php

namespace App\Features\Meetings\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MeetingDocument extends Model
{
    use HasUuids;

    protected $fillable = [
        'meeting_id',
        'title',
        'file_path',
        'file_type',
        'uploaded_by_id',
    ];

    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }
}
