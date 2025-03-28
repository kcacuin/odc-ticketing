@props([
    'name',
])

<div
    wire:ignore
    x-data
    x-init="
        FilePond.registerPlugin(FilePondPluginImagePreview);
        FilePond.setOptions({
            allowMultiple: {{ isset($attributes['multiple']) ? 'true' : 'false' }},
            server: {
                process: '/tmp-upload',
                revert: '/tmp-delete',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            },
        });
        FilePond.create($refs.input);
        const elementToRemove = document.querySelector('.filepond--credits');
        if (elementToRemove) {
            elementToRemove.remove();
        }
    "
>
    <input type="file" id="{{ $name }}" name="{{ $name }}" wire:model="{{ $name }}" x-ref="input" class="--filepond--label">
</div>

