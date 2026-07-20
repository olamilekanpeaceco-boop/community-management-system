<?php

namespace App\Features\Auth\Controllers;

use App\Features\Auth\Requests\ForgotPasswordRequest;
use App\Features\Auth\Requests\ResetPasswordRequest;
use App\Features\Auth\Services\PasswordResetService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PasswordResetController
{
    protected PasswordResetService $passwordResetService;

    public function __construct(PasswordResetService $passwordResetService)
    {
        $this->passwordResetService = $passwordResetService;
    }

    public function showForgotPasswordForm(): View
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(ForgotPasswordRequest $request): RedirectResponse
    {
        $this->passwordResetService->sendResetLink($request->email);
        return back()->with('status', 'password-reset-link-sent');
    }

    public function showResetForm(Request $request, string $token): View
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->query('email')]);
    }

    public function resetPassword(ResetPasswordRequest $request): RedirectResponse
    {
        $result = $this->passwordResetService->resetPassword($request->validated());
        if ($result) {
            return redirect()->route('login')->with('status', 'password-reset');
        }
        return back()->withInput($request->only('email'))->withErrors(['email' => 'Failed to reset password.']);
    }
}