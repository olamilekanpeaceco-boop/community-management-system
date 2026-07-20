@csrf

<div>
    <label class="block text-sm font-medium text-gray-700">Summary</label>
    <textarea name="summary" rows="3" required class="mt-1 block w-full border rounded px-3 py-2">{{ old('summary', $minute->summary ?? '') }}</textarea>
    @error('summary')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Discussion Notes</label>
    <input id="discussion_notes" type="hidden" name="discussion_notes" value="{{ old('discussion_notes', isset($minute) ? json_encode($minute->discussion_notes) : '') }}">
    <trix-editor input="discussion_notes" class="prose max-w-full"></trix-editor>
    @error('discussion_notes')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Resolutions (JSON array)</label>
    <textarea name="resolutions" rows="2" class="mt-1 block w-full border rounded px-3 py-2">{{ old('resolutions', isset($minute) ? json_encode($minute->resolutions) : '') }}</textarea>
    <p class="text-xs text-gray-500">Provide resolutions as JSON array of objects, e.g. [{"text":"Resolution text"}]</p>
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Action Items (JSON array)</label>
    <textarea name="action_items" rows="2" class="mt-1 block w-full border rounded px-3 py-2">{{ old('action_items', isset($minute) ? json_encode($minute->action_items) : '') }}</textarea>
    <p class="text-xs text-gray-500">Provide action items as JSON array of objects, e.g. [{"text":"Do X","assignee_id":"..."}]</p>
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Assigned Tasks (JSON array)</label>
    <textarea name="assigned_tasks" rows="2" class="mt-1 block w-full border rounded px-3 py-2">{{ old('assigned_tasks', isset($minute) ? json_encode($minute->assigned_tasks) : '') }}</textarea>
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Attachments</label>
    <input type="file" name="attachments[]" multiple class="mt-1" />
</div>
