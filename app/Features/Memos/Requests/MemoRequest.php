<?php

namespace App\Features\Memos\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemoRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Authorization is handled in the controller via policies
        return true;
    }

    protected function prepareForValidation(): void
    {
        // normalize recipients which may be sent as JSON string from some clients
        $recipients = $this->input('recipients');
        if (is_string($recipients) && $recipients !== '') {
            $decoded = json_decode($recipients, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $this->merge(['recipients' => $decoded]);
            }
        }

        // sanitize body HTML using HTMLPurifier if available, otherwise use app sanitizer
        $body = $this->input('body', '');
        if (class_exists('\Purifier')) {
            $clean = \Purifier::clean($body);
        } else {
            if (method_exists(\App\Utils\HtmlSanitizer::class, 'sanitize')) {
                $clean = \App\Utils\HtmlSanitizer::sanitize($body);
            } else {
                $clean = strip_tags($body);
            }
        }

        $this->merge(['body' => $clean]);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'recipients' => ['required', 'array'],
            'recipients.*.type' => ['required', 'in:all,committee,member'],
            'recipients.*.id' => ['nullable', 'uuid'],
            'attachments' => ['nullable', 'array'],
            'attachments.*' => ['file', 'max:51200'],
        ];
    }
}
