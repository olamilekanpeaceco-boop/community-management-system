<?php

namespace App\Features\Auth\Services;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;

class EmailVerificationService
{
    public function sendVerificationEmail(User $user): void
    {
        $user->notify(new VerifyEmail());
    }
}