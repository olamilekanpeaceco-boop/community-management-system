<?php

namespace App\Features\Auth\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProfileService
{
    public function updateProfile(User $user, array $data): User
    {
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'bio' => $data['bio'] ?? null,
        ]);
        return $user->refresh();
    }

    public function uploadAvatar(User $user, UploadedFile $file): User
    {
        if ($user->avatar_url && !str_contains($user->avatar_url, 'ui-avatars')) {
            Storage::disk('public')->delete($user->avatar_url);
        }
        $path = $file->store('avatars', 'public');
        $user->update(['avatar_url' => $path]);
        return $user->refresh();
    }

    public function deleteAvatar(User $user): User
    {
        if ($user->avatar_url && !str_contains($user->avatar_url, 'ui-avatars')) {
            Storage::disk('public')->delete($user->avatar_url);
            $user->update(['avatar_url' => null]);
        }
        return $user->refresh();
    }

    public function updatePassword(User $user, array $data): User
    {
        $user->update(['password' => Hash::make($data['password'])]);
        return $user->refresh();
    }
}