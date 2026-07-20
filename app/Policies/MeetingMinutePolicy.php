<?php

namespace App\Policies;

use App\Models\User;
use App\Features\Meetings\Models\MeetingMinute;
use Illuminate\Auth\Access\HandlesAuthorization;

class MeetingMinutePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('manage-minutes') || $user->hasRole('super_admin');
    }

    public function view(User $user, MeetingMinute $minute): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('manage-minutes') || $user->hasRole('super_admin');
    }

    public function update(User $user, MeetingMinute $minute): bool
    {
        return $user->hasPermissionTo('manage-minutes') || $user->hasRole('super_admin');
    }

    public function delete(User $user, MeetingMinute $minute): bool
    {
        return $user->hasPermissionTo('manage-minutes') || $user->hasRole('super_admin');
    }
}
