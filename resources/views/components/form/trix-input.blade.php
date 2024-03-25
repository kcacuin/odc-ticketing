@props(['id', 'name', 'value'])

<x-form.field>
    <input
        type="hidden"
        name="{{ $name }}"
        id="{{ $id }}_input"
        {{-- value="{{ $value?->toTrixHtml() }}" --}}
        value="{{ $value }}"
    />

    <trix-toolbar
        class="[&_.trix-button]:bg-white [&_.trix-button.trix-active]:bg-slate-300"
        id="{{ $id }}_toolbar"
    ></trix-toolbar>

    <trix-editor
        x-data="{
            upload(event) {
                const data = new FormData()
                data.append('attachment', event.attachment.file)

                window.axios.post('/attachments', data, {
                    onUploadProgress(progressEvent) {
                        event.attachment.setUploadProgress(
                            progressEvent.loaded / progressEvent.total * 100
                        )
                    }
                }).then(({ data }) => {
                    event.attachment.setAttributes({
                        url: data.image_url,
                    })
                })
            }
        }"
        x-on:trix-attachment-add="upload"
        id="{{ $id }}"
        toolbar="{{ $id }}_toolbar"
        input="{{ $id }}_input"
        {{ $attributes->merge(['class' => 'trix-content px-3 py-2 border border-slate-200 ring-0 focus:border-0 focus:border-odc-blue-800 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:focus:border-odc-blue-600 dark:focus:ring-odc-blue-600 rounded-md shadow-sm dark:[&_pre]:!bg-slate-700 dark:[&_pre]:rounded dark:[&_pre]:!text-white']) }}
    ></trix-editor>
    <x-form.error name="{{ $name }}"/>
</x-form.field>


