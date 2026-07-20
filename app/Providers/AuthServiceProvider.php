<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Register generated policies
        \App\Features\Meetings\Models\MeetingMinute::class => \App\Policies\MeetingMinutePolicy::class,
        \App\Features\Memos\Models\Memo::class => \App\Policies\MemoPolicy::class,
        // add other mappings here as needed
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Additional gates can be defined here
    }
}
