<?php

namespace App\Features\Memos\Controllers;

use App\Features\Memos\Models\Memo;
use App\Features\Memos\Models\MemoAttachment;
use App\Features\Memos\Models\MemoRecipient;
use App\Features\Memos\Requests\MemoRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\MemoNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class MemoController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Memo::class);
        $memos = Memo::with('creator')->orderBy('created_at', 'desc')->paginate(15);
        return view('memos.index', compact('memos'));
    }

    public function create()
    {
        $this->authorize('create', Memo::class);
        return view('memos.create');
    }

    public function store(MemoRequest $request): RedirectResponse
    {
        $this->authorize('create', Memo::class);

        $data = $request->validated();
        $memo = Memo::create([
            'title' => $data['title'],
            'body' => $data['body'],
            'created_by_id' => $request->user()->id,
        ]);

        // attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $this->storeAttachment($memo, $file, $request->user()->id);
            }
        }

        // recipients
        $recipients = $data['recipients'] ?? [];
        $targetUsers = collect();
        foreach ($recipients as $r) {
            $type = $r['type'];
            $id = $r['id'] ?? null;
            MemoRecipient::create([
                'memo_id' => $memo->id,
                'recipient_type' => $type,
                'recipient_id' => $id,
            ]);

            if ($type === 'all') {
                // all members
                $targetUsers = User::query()->where('is_active', true)->get();
                break; // no need to evaluate other recipients
            }

            if ($type === 'committee' && $id) {
                // assume Committee has members via committee_members table and Member model maps to users
                $users = User::whereHas('member', function ($q) use ($id) {
                    $q->whereHas('committees', function ($q2) use ($id) {
                        $q2->where('committees.id', $id);
                    });
                })->get();
                $targetUsers = $targetUsers->merge($users);
            }

            if ($type === 'member' && $id) {
                $user = User::find($id);
                if ($user) $targetUsers->push($user);
            }
        }

        $targetUsers = $targetUsers->unique('id');

        // send notifications (email + in-app)
        if ($targetUsers->isNotEmpty()) {
            Notification::send($targetUsers, new MemoNotification($memo));
        }

        return redirect()->route('memos.index')->with('success', 'Memo created and sent.');
    }

    public function show(Memo $memo)
    {
        $this->authorize('view', $memo);
        $memo->load('attachments', 'recipients');
        return view('memos.show', compact('memo'));
    }

    public function edit(Memo $memo)
    {
        $this->authorize('update', $memo);
        $memo->load('recipients');
        return view('memos.edit', compact('memo'));
    }

    public function update(MemoRequest $request, Memo $memo): RedirectResponse
    {
        $this->authorize('update', $memo);
        $data = $request->validated();

        $memo->update([
            'title' => $data['title'],
            'body' => $data['body'],
        ]);

        // attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $this->storeAttachment($memo, $file, $request->user()->id);
            }
        }

        // replace recipients
        $memo->recipients()->delete();
        $recipients = $data['recipients'] ?? [];
        $targetUsers = collect();
        foreach ($recipients as $r) {
            $type = $r['type'];
            $id = $r['id'] ?? null;
            MemoRecipient::create([
                'memo_id' => $memo->id,
                'recipient_type' => $type,
                'recipient_id' => $id,
            ]);

            if ($type === 'all') {
                $targetUsers = User::query()->where('is_active', true)->get();
                break;
            }

            if ($type === 'committee' && $id) {
                $users = User::whereHas('member', function ($q) use ($id) {
                    $q->whereHas('committees', function ($q2) use ($id) {
                        $q2->where('committees.id', $id);
                    });
                })->get();
                $targetUsers = $targetUsers->merge($users);
            }

            if ($type === 'member' && $id) {
                $user = User::find($id);
                if ($user) $targetUsers->push($user);
            }
        }
        $targetUsers = $targetUsers->unique('id');

        if ($targetUsers->isNotEmpty()) {
            Notification::send($targetUsers, new MemoNotification($memo));
        }

        return redirect()->route('memos.show', $memo)->with('success', 'Memo updated.');
    }

    public function destroy(Memo $memo): RedirectResponse
    {
        $this->authorize('delete', $memo);
        $memo->delete();
        return redirect()->route('memos.index')->with('success', 'Memo deleted.');
    }

    protected function storeAttachment(Memo $memo, UploadedFile $file, $userId)
    {
        $path = $file->store('memos/attachments', 'public');
        return $memo->attachments()->create([
            'file_path' => $path,
            'file_type' => $file->getClientMimeType(),
            'uploaded_by_id' => $userId,
        ]);
    }
}
