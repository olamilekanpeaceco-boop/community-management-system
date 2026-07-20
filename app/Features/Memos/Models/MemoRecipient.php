<?php

namespace App\Features\Memos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MemoRecipient extends Model
{
    use HasUuids;

    protected $fillable = [
        'memo_id',
        'recipient_type',
        'recipient_id',
    ];

    public function memo()
    {
        return $this->belongsTo(Memo::class, 'memo_id');
    }
}
