<?php

namespace App\Features\Memos\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemoRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Only users with the send-memo permission can create memos
        return $this->user() && $this->user()->can('send-memo');
    }

    protected function prepareForValidation(): void
    {
        $recipients = $this->input('recipients');

        if (is_string($recipients)) {
            $decoded = json_decode($recipients, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $this->merge(['recipients' => $decoded]);
            } else {
                $this->merge(['recipients' => []]);
            }
        }
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'recipients' => ['required', 'array', 'min:1'],
            'recipients.*.type' => ['required', 'in:all,committee,member'],
            'recipients.*.id' => ['nullable', 'uuid'],
            'attachments' => ['nullable', 'array'],
            'attachments.*' => ['file', 'max:51200', 'mimes:pdf,doc,docx,xlsx,jpg,png'],
        ];
    }
}
