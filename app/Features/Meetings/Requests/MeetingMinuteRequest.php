<?php

namespace App\Features\Meetings\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MeetingMinuteRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Authorization is handled in controller via policies
        return true;
    }

    public function rules(): array
    {
        return [
            'summary' => ['required', 'string', 'max:65535'],
            'discussion_notes' => ['nullable', 'string'],
            'resolutions' => ['nullable', 'array'],
            'resolutions.*.text' => ['required_with:resolutions', 'string'],
            'action_items' => ['nullable', 'array'],
            'action_items.*.text' => ['required_with:action_items', 'string'],
            'assigned_tasks' => ['nullable', 'array'],
            'assigned_tasks.*.task' => ['required_with:assigned_tasks', 'string'],
            'attachments' => ['nullable', 'array'],
            'attachments.*' => ['file', 'max:51200'],
        ];
    }
}
