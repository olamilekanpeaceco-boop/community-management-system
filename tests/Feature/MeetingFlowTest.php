<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MeetingFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_view_meetings()
    {
        $response = $this->get('/meetings');
        $response->assertRedirect('/login');
    }

    // Add more tests: create meeting, upload attachment, download attachment, authorization tests
}
