<?php

namespace App\Policies;

use App\Features\Memos\Models\Memo;
use App\Models\User;

class MemoPolicy
{
    public function viewAny(User $user): bool
    {
        // everyone with access can view memos
        return $user->hasAnyRole(['super_admin', 'admin', 'secretary', 'committee_head', 'member']);
    }

    public function view(User $user, Memo $memo): bool
    {
        // recipients can view or admins
        if ($user->can('send-memo') || $user->can('manage-users')) {
            return true;
        }
        // check recipients
        return $memo->recipients()->where(function ($q) use ($user) {
            $q->where(function ($q2) use ($user) {
                $q2->where('recipient_type', 'member')->where('recipient_id', $user->id);
            })->orWhere('recipient_type', 'all');
        })->exists();
    }

    public function create(User $user): bool
    {
        return $user->can('send-memo');
    }

    public function update(User $user, Memo $memo): bool
    {
        return $user->can('send-memo') || $user->id === $memo->created_by_id;
    }

    public function delete(User $user, Memo $memo): bool
    {
        return $user->can('send-memo');
    }
}
