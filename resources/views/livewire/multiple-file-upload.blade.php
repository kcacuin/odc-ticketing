{{-- <div class="p-2 pb-0 rounded-md border border-dashed border-blue-secondary bg-[#f1f0ef]">
    <x-input.filepond name="files[]" wireModel='files' multiple/>
    <x-form.error name="files" />
</div> --}}

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
