<?php

namespace App\Features\Memos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MemoAttachment extends Model
{
    use HasUuids;

    protected $fillable = [
        'memo_id',
        'file_path',
        'file_type',
        'uploaded_by_id',
    ];

    public function memo()
    {
        return $this->belongsTo(Memo::class, 'memo_id');
    }
}
