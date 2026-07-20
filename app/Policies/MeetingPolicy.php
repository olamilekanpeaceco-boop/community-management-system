<?php

namespace App\Policies;

use App\Features\Meetings\Models\Meeting;
use App\Models\User;

class MeetingPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Meeting $meeting): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->can('manage-meetings');
    }

    public function update(User $user, Meeting $meeting): bool
    {
        return $user->can('manage-meetings') || $user->id === $meeting->organizer_id;
    }

    public function delete(User $user, Meeting $meeting): bool
    {
        return $user->can('manage-meetings');
    }
}
