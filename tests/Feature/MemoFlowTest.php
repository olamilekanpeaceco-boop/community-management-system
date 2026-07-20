<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemoFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_create_memo()
    {
        $response = $this->get('/memos/create');
        $response->assertRedirect('/login');
    }

    // Add more tests for memo creation, recipients resolution, and attachments
}
