<?php

namespace App\Features\Memos\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemoRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Authorization is handled in controller via policies
        return true;
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
