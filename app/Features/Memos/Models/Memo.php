<?php

namespace App\Features\Memos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Memo extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    // UUID PK configuration
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'title',
        'body',
        'created_by_id',
    ];

    public function attachments()
    {
        return $this->hasMany(MemoAttachment::class);
    }

    public function recipients()
    {
        return $this->hasMany(MemoRecipient::class);
    }

    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by_id');
    }
}
