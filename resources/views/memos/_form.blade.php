@csrf

<div>
    <label class="block text-sm font-medium text-gray-700">Title</label>
    <input type="text" name="title" required class="mt-1 block w-full border rounded px-3 py-2" value="{{ old('title', $memo->title ?? '') }}">
    @error('title')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Body</label>
    <input id="body_input" type="hidden" name="body" value="{{ old('body', $memo->body ?? '') }}">
    <trix-editor input="body_input" class="prose max-w-full"></trix-editor>
    @error('body')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Recipients</label>
    <p class="text-xs text-gray-500">Select recipients: use JSON array with objects {"type":"all|committee|member","id":"uuid (optional)"}</p>
    <textarea name="recipients" rows="3" class="mt-1 block w-full border rounded px-3 py-2">{{ old('recipients', isset($memo) ? json_encode($memo->recipients->map(function($r){return ['type'=>$r->recipient_type,'id'=>$r->recipient_id];})) : '') }}</textarea>
    @error('recipients')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700">Attachments</label>
    <input type="file" name="attachments[]" multiple class="mt-1" />
</div>
