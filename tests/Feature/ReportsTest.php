<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders reports index for authorized user', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('view-reports');

    actingAs($user)
        ->get(route('reports.index'))
        ->assertStatus(200);
});
