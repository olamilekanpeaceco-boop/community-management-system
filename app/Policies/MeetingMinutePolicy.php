<?php

namespace App\Policies;

use App\Features\Meetings\Models\MeetingMinute;
use App\Models\User;

class MeetingMinutePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, MeetingMinute $minute): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->can('manage-meetings');
    }

    public function update(User $user, MeetingMinute $minute): bool
    {
        return $user->can('manage-meetings') || $user->id === $minute->created_by_id;
    }

    public function delete(User $user, MeetingMinute $minute): bool
    {
        return $user->can('manage-meetings');
    }
}
