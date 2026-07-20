<?php

namespace App\Features\Meetings\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MeetingMinuteRequest extends FormRequest
{
    public function authorize(): bool
    {
        // For creating minutes, ensure user can create minutes generally
        if ($this->isMethod('post')) {
            return $this->user() && $this->user()->can('create', \App\Features\Meetings\Models\MeetingMinute::class);
        }

        // For update/delete, grab the minute from route and check update permission
        $minute = $this->route('minute');
        if ($minute) {
            return $this->user() && $this->user()->can('update', $minute);
        }

        return false;
    }

    protected function prepareForValidation(): void
    {
        // Allow passing discussion_notes/resolutions/action_items as JSON strings
        foreach (['discussion_notes', 'resolutions', 'action_items', 'assigned_tasks'] as $field) {
            $value = $this->input($field);
            if (is_string($value)) {
                $decoded = json_decode($value, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $this->merge([$field => $decoded]);
                }
            }
        }
    }

    public function rules(): array
    {
        return [
            'summary' => ['required', 'string', 'max:65535'],
            'discussion_notes' => ['nullable', 'array'],
            'resolutions' => ['nullable', 'array'],
            'resolutions.*.text' => ['required_with:resolutions', 'string'],
            'action_items' => ['nullable', 'array'],
            'action_items.*.text' => ['required_with:action_items', 'string'],
            'assigned_tasks' => ['nullable', 'array'],
            'assigned_tasks.*.task' => ['required_with:assigned_tasks', 'string'],
            'attachments' => ['nullable', 'array'],
            'attachments.*' => ['file', 'max:51200', 'mimes:pdf,doc,docx,xlsx,jpg,png'],
        ];
    }
}
