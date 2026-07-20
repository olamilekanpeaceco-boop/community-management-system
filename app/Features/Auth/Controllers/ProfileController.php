<?php

namespace App\Features\Auth\Controllers;

use App\Features\Auth\Requests\ChangePasswordRequest;
use App\Features\Auth\Requests\UpdateProfileRequest;
use App\Features\Auth\Requests\UploadAvatarRequest;
use App\Features\Auth\Services\ProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController
{
    protected ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function show(Request $request): View
    {
        return view('auth.profile.show', ['user' => $request->user()]);
    }

    public function edit(Request $request): View
    {
        return view('auth.profile.edit', ['user' => $request->user()]);
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $this->profileService->updateProfile($request->user(), $request->validated());
        return redirect()->route('profile.show')->with('status', 'profile-updated');
    }

    public function uploadAvatar(UploadAvatarRequest $request): RedirectResponse
    {
        $this->profileService->uploadAvatar($request->user(), $request->file('avatar'));
        return back()->with('status', 'avatar-uploaded');
    }

    public function deleteAvatar(Request $request): RedirectResponse
    {
        $this->profileService->deleteAvatar($request->user());
        return back()->with('status', 'avatar-deleted');
    }

    public function showChangePasswordForm(Request $request): View
    {
        return view('auth.profile.change-password', ['user' => $request->user()]);
    }

    public function updatePassword(ChangePasswordRequest $request): RedirectResponse
    {
        $this->profileService->updatePassword($request->user(), $request->validated());
        return redirect()->route('profile.show')->with('status', 'password-changed');
    }
}