<?php

use App\Models\User;
use App\Features\Meetings\Models\Meeting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

it('allows authorized user to create meeting minutes', function () {
    Storage::fake('public');

    $user = User::factory()->create();
    $meeting = Meeting::factory()->create();

    actingAs($user)
        ->post(route('meetings.minutes.store', $meeting), [
            'summary' => 'Meeting summary example',
            'discussion_notes' => '<p>Discussion</p>',
            'resolutions' => json_encode([['text' => 'Resolve A']]),
            'action_items' => json_encode([['text' => 'Do A']]),
            'assigned_tasks' => json_encode([['task' => 'Follow up']]),
            'attachments' => [UploadedFile::fake()->create('doc.pdf', 100)],
        ])
        ->assertRedirect();

    $this->assertDatabaseHas('meeting_minutes', ['meeting_id' => $meeting->id]);
});
