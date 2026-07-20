<?php

namespace App\Features\Meetings\Controllers;

use App\Features\Meetings\Models\Meeting;
use App\Features\Meetings\Requests\CreateMeetingRequest;
use App\Features\Meetings\Requests\UpdateMeetingRequest;
use App\Features\Meetings\Services\MeetingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MeetingController
{
    protected MeetingService $meetingService;

    public function __construct(MeetingService $meetingService)
    {
        $this->meetingService = $meetingService;
    }

    public function index(): View
    {
        $meetings = Meeting::with('committee', 'organizer')
            ->orderBy('scheduled_at', 'desc')
            ->paginate(15);

        return view('meetings.index', ['meetings' => $meetings]);
    }

    public function create(): View
    {
        return view('meetings.create');
    }

    public function store(CreateMeetingRequest $request): RedirectResponse
    {
        $meeting = $this->meetingService->createMeeting($request->validated());
        return redirect()->route('meetings.show', $meeting)->with('status', 'meeting-created');
    }

    public function show(Meeting $meeting): View
    {
        $meeting->load('committee', 'organizer', 'agendas', 'attendance', 'documents');
        return view('meetings.show', ['meeting' => $meeting]);
    }

    public function edit(Meeting $meeting): View
    {
        return view('meetings.edit', ['meeting' => $meeting]);
    }

    public function update(UpdateMeetingRequest $request, Meeting $meeting): RedirectResponse
    {
        $this->meetingService->updateMeeting($meeting, $request->validated());
        return redirect()->route('meetings.show', $meeting)->with('status', 'meeting-updated');
    }

    public function destroy(Meeting $meeting): RedirectResponse
    {
        $this->meetingService->deleteMeeting($meeting);
        return redirect()->route('meetings.index')->with('status', 'meeting-deleted');
    }
}
