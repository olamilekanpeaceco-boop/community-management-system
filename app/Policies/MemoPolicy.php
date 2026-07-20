<?php

namespace App\Policies;

use App\Models\User;
use App\Features\Memos\Models\Memo;
use Illuminate\Auth\Access\HandlesAuthorization;

class MemoPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        // allow users who can send memos or super admin to view memos
        return $user->hasPermissionTo('send-memo') || $user->hasRole('super_admin');
    }

    public function view(User $user, Memo $memo): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('send-memo') || $user->hasRole('super_admin');
    }

    public function update(User $user, Memo $memo): bool
    {
        return $user->hasPermissionTo('send-memo') || $user->hasRole('super_admin');
    }

    public function delete(User $user, Memo $memo): bool
    {
        return $user->hasPermissionTo('send-memo') || $user->hasRole('super_admin');
    }
}
