<?php

namespace App\Policies;

use App\Models\User;
use App\Features\Meetings\Models\Meeting;
use Illuminate\Auth\Access\HandlesAuthorization;

class MeetingPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('manage-meetings') || $user->hasRole('super_admin');
    }

    public function view(User $user, Meeting $meeting): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('manage-meetings') || $user->hasRole('super_admin');
    }

    public function update(User $user, Meeting $meeting): bool
    {
        return $user->hasPermissionTo('manage-meetings') || $user->hasRole('super_admin');
    }

    public function delete(User $user, Meeting $meeting): bool
    {
        return $user->hasPermissionTo('manage-meetings') || $user->hasRole('super_admin');
    }
}
