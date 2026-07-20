<?php

namespace App\Services;

use App\Features\Memos\Models\Memo;
use App\Features\Memos\Models\MemoAttachment;
use App\Features\Memos\Models\MemoRecipient;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MemoService
{
    protected string $disk;

    public function __construct()
    {
        $this->disk = config('filesystems.private_disk', config('filesystems.default'));
    }

    public function createMemo(array $data, User $creator): Memo
    {
        return DB::transaction(function () use ($data, $creator) {
            $memo = Memo::create([
                'title' => $data['title'],
                'body' => $data['body'],
                'created_by_id' => $creator->id,
            ]);

            // attachments
            if (! empty($data['attachments']) && is_array($data['attachments'])) {
                foreach ($data['attachments'] as $file) {
                    if ($file instanceof UploadedFile) {
                        $this->storeAttachment($memo, $file, $creator->id);
                    }
                }
            }

            // recipients
            $targetUsers = $this->resolveRecipients($memo, $data['recipients'] ?? []);

            // dispatch notifications after commit
            DB::afterCommit(function () use ($memo, $targetUsers) {
                if ($targetUsers->isNotEmpty()) {
                    \Illuminate\Support\Facades\Notification::send($targetUsers, new \App\Notifications\MemoNotification($memo));
                }
            });

            return $memo;
        });
    }

    protected function storeAttachment(Memo $memo, UploadedFile $file, int $uploaderId): MemoAttachment
    {
        $path = 'memos/'.$memo->id.'/attachments';
        $filename = uniqid().'_'.preg_replace('/[^a-zA-Z0-9_.-]/', '_', $file->getClientOriginalName());
        $stored = $file->storeAs($path, $filename, $this->disk);

        return MemoAttachment::create([
            'memo_id' => $memo->id,
            'file_path' => $stored,
            'file_type' => $file->getClientMimeType(),
            'uploaded_by_id' => $uploaderId,
        ]);
    }

    protected function resolveRecipients(Memo $memo, array $recipients)
    {
        $targetUsers = collect();

        foreach ($recipients as $r) {
            $type = $r['type'] ?? null;
            $id = $r['id'] ?? null;

            MemoRecipient::create([
                'memo_id' => $memo->id,
                'recipient_type' => $type,
                'recipient_id' => $id,
            ]);

            if ($type === 'all') {
                $targetUsers = User::query()->where('is_active', true)->get();
                break;
            }

            if ($type === 'committee' && $id) {
                $users = User::whereHas('member', function ($q) use ($id) {
                    $q->whereHas('committees', function ($q2) use ($id) {
                        $q2->where('committees.id', $id);
                    });
                })->get();

                $targetUsers = $targetUsers->merge($users);
            }

            if ($type === 'member' && $id) {
                $user = User::find($id);
                if ($user) $targetUsers->push($user);
            }
        }

        return $targetUsers->unique('id');
    }
}
