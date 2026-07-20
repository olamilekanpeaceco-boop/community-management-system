<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Features\Meetings\Models\Meeting;
use App\Features\Memos\Models\Memo;
use App\Features\Meetings\Models\MeetingMinute;
use App\Policies\MeetingPolicy;
use App\Policies\MemoPolicy;
use App\Policies\MeetingMinutePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Meeting::class => MeetingPolicy::class,
        Memo::class => MemoPolicy::class,
        MeetingMinute::class => MeetingMinutePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Additional Gates can be defined here if needed
    }
}
