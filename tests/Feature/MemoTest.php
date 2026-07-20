<?php

use App\Models\User;
use App\Features\Memos\Models\Memo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;

uses(RefreshDatabase::class);

it('allows admin to create and send memo to a member', function () {
    Notification::fake();

    $admin = User::factory()->create();
    $member = User::factory()->create();

    // give permission
    $admin->givePermissionTo('send-memo');

    actingAs($admin)
        ->post(route('memos.store'), [
            'title' => 'Test Memo',
            'body' => '<p>Important update</p>',
            'recipients' => json_encode([['type' => 'member', 'id' => $member->id]]),
            'attachments' => [UploadedFile::fake()->create('file.pdf', 100)],
        ])
        ->assertRedirect();

    $memo = Memo::first();
    $this->assertNotNull($memo);

    Notification::assertSentTo([$member], \App\Notifications\MemoNotification::class);
});
