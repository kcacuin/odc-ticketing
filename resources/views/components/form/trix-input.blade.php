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
        class="[&_.trix-button]:bg-white [&_.trix-button.trix-active]:bg-gray-300"
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
        {{ $attributes->merge(['class' => 'trix-content border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:ring-1 focus:border-odc-blue-500 dark:focus:border-odc-blue-600 focus:ring-odc-blue-500 dark:focus:ring-odc-blue-600 rounded-md shadow-sm dark:[&_pre]:!bg-gray-700 dark:[&_pre]:rounded dark:[&_pre]:!text-white']) }}
    ></trix-editor>
    <x-form.error name="{{ $name }}"/>
</x-form.field>


