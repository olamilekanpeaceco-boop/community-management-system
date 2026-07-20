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
use Illuminate\Support\Facades\DB;

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
        $attachments = $request->file('attachments', []);

        DB::transaction(function () use (&$minute, $meeting, $data, $attachments, $request) {
            $minute = $meeting->minutes()->create(array_merge($data, [
                'created_by_id' => $request->user()->id,
            ]));

            if (! empty($attachments)) {
                foreach ($attachments as $file) {
                    $this->storeAttachment($minute, $file, $request->user()->id);
                }
            }
        });

        DB::afterCommit(function () use ($minute, $meeting) {
            // future: dispatch notifications about new minutes
        });

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
        $attachments = $request->file('attachments', []);

        DB::transaction(function () use ($request, $minute, $attachments) {
            $minute->update($request->validated());

            if (! empty($attachments)) {
                foreach ($attachments as $file) {
                    $this->storeAttachment($minute, $file, $request->user()->id);
                }
            }
        });

        DB::afterCommit(function () use ($minute, $meeting) {
            // future: notifications
        });

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

    public function downloadAttachment(Meeting $meeting, MeetingMinute $minute, MeetingMinuteAttachment $attachment)
    {
        $this->authorize('view', $minute);

        if ($attachment->meeting_minute_id !== $minute->id) abort(404);

        $disk = config('filesystems.private_disk', config('filesystems.default', 'public'));

        if (! Storage::disk($disk)->exists($attachment->file_path)) abort(404);

        return Storage::disk($disk)->download($attachment->file_path, basename($attachment->file_path));
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
        $disk = config('filesystems.private_disk', config('filesystems.default', 'public'));

        $filename = uniqid('minute_') . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('minutes/attachments', $filename, $disk);

        return $minute->attachments()->create([
            'file_path' => $path,
            'file_type' => $file->getClientMimeType(),
            'uploaded_by_id' => $userId,
        ]);
    }
}
