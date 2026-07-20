<?php

namespace App\Features\Meetings\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMeetingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->can('manage-meetings');
    }

    public function rules(): array
    {
        return [
            'committee_id' => ['required', 'exists:committees,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'meeting_type' => ['required', 'in:regular,special,emergency,annual'],
            'scheduled_at' => ['required', 'date', 'after:now'],
            'duration_minutes' => ['required', 'integer', 'min:15', 'max:480'],
            'location_type' => ['required', 'in:physical,virtual,hybrid'],
            'location' => ['nullable', 'string', 'max:255'],
            'meeting_link' => ['nullable', 'url'],
            'room_number' => ['nullable', 'string', 'max:50'],
        ];
    }
}
