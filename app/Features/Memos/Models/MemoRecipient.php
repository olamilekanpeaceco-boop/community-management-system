<?php

namespace App\Features\Memos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MemoRecipient extends Model
{
    use HasUuids;

    // UUID PK configuration
    public $incrementing = false;
    protected $keyType = 'string';

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
