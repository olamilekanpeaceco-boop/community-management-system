<?php

namespace App\Features\Meetings\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MeetingMinuteRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Authorization handled in controller via policies
        return true;
    }

    protected function prepareForValidation(): void
    {
        // normalize arrays possibly sent as JSON
        foreach (['resolutions', 'action_items', 'assigned_tasks'] as $key) {
            $val = $this->input($key);
            if (is_string($val) && $val !== '') {
                $decoded = json_decode($val, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $this->merge([$key => $decoded]);
                }
            }
        }

        // sanitize discussion notes
        $notes = $this->input('discussion_notes', '');
        if (class_exists('\Purifier')) {
            $clean = \Purifier::clean($notes);
        } else {
            if (method_exists(\App\Utils\HtmlSanitizer::class, 'sanitize')) {
                $clean = \App\Utils\HtmlSanitizer::sanitize($notes);
            } else {
                $clean = strip_tags($notes);
            }
        }

        $this->merge(['discussion_notes' => $clean]);
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
