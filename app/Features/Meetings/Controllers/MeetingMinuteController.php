<?php

namespace App\Features\Meetings\Controllers;

use App\Features\Meetings\Models\Meeting;
use App\Features\Meetings\Models\MeetingMinute;
use App\Features\Meetings\Models\MeetingMinuteAttachment;
use App\Features\Meetings\Requests\MeetingMinuteRequest;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MeetingMinuteController extends Controller
{
    public function index(Meeting $meeting)
    {
        $this->authorize('viewAny', MeetingMinute::class);
        $minutes = $meeting->minutes()->latest()->paginate(20);

        return view('meetings.minutes.index', compact('meeting', 'minutes'));
    }

    public function create(Meeting $meeting)
    {
        $this->authorize('create', MeetingMinute::class);
        return view('meetings.minutes.create', compact('meeting'));
    }

    public function store(MeetingMinuteRequest $request, Meeting $meeting): RedirectResponse
    {
        $this->authorize('create', MeetingMinute::class);

        $data = $request->validated();
        $minute = $meeting->minutes()->create(array_merge($data, [
            'created_by_id' => $request->user()->id,
        ]));

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $this->storeAttachment($minute, $file, $request->user()->id);
            }
        }

        return redirect()->route('meetings.show', $meeting)->with('success', 'Meeting minutes saved.');
    }

    public function show(Meeting $meeting, MeetingMinute $minute)
    {
        $this->authorize('view', $minute);
        $minute->load('attachments', 'createdBy');
        return view('meetings.minutes.show', compact('meeting', 'minute'));
    }

    public function edit(Meeting $meeting, MeetingMinute $minute)
    {
        $this->authorize('update', $minute);
        return view('meetings.minutes.edit', compact('meeting', 'minute'));
    }

    public function update(MeetingMinuteRequest $request, Meeting $meeting, MeetingMinute $minute): RedirectResponse
    {
        $this->authorize('update', $minute);
        $minute->update($request->validated());

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $this->storeAttachment($minute, $file, $request->user()->id);
            }
        }

        return redirect()->route('meetings.minutes.show', [$meeting, $minute])->with('success', 'Meeting minutes updated.');
    }

    public function destroy(Meeting $meeting, MeetingMinute $minute): RedirectResponse
    {
        $this->authorize('delete', $minute);
        $minute->delete();
        return redirect()->route('meetings.show', $meeting)->with('success', 'Meeting minutes deleted.');
    }

    public function downloadPdf(Meeting $meeting, MeetingMinute $minute)
    {
        $this->authorize('view', $minute);
        $minute->load('attachments', 'createdBy');
        $pdf = Pdf::loadView('meetings.minutes.pdf', compact('meeting', 'minute'));

        return $pdf->download('meeting_minute_'.$minute->id.'.pdf');
    }

    public function search(Request $request, Meeting $meeting)
    {
        $this->authorize('viewAny', MeetingMinute::class);
        $q = $request->get('q');
        $minutes = $meeting->minutes()
            ->where(function ($query) use ($q) {
                $query->where('summary', 'like', "%{$q}%")
                      ->orWhere('discussion_notes', 'like', "%{$q}%")
                      ->orWhere('resolutions', 'like', "%{$q}%");
            })
            ->paginate(20);

        return view('meetings.minutes.index', compact('meeting', 'minutes', 'q'));
    }

    protected function storeAttachment(MeetingMinute $minute, UploadedFile $file, $userId)
    {
        $path = $file->store('minutes/attachments', 'public');
        return $minute->attachments()->create([
            'file_path' => $path,
            'file_type' => $file->getClientMimeType(),
            'uploaded_by_id' => $userId,
        ]);
    }
}
