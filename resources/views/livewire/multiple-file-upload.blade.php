<div>
    <input type="file" wire:model="files" multiple>

    @error('files.*') <span class="error">{{ $message }}</span> @enderror

    @if ($files)
        <div>Files to upload:</div>
        <ul>
            @foreach ($files as $file)
                <li>{{ $file->getClientOriginalName() }}</li>
            @endforeach
        </ul>
    @endif
</div>
