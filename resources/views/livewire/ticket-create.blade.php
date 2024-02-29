<div class="py-10 px-4 max-w-6xl mx-auto relative">
    @auth
        <form method="POST" action="/tickets" enctype="multipart/form-data" class="mt-2">
            @csrf

            {{-- * Ticket Number (Copy to Clipboard) --}}
            <div class="grid grid-cols-2 grid-rows-1 gap-4">
                <div x-data="{ input: '{{ $nextTicketNumber }}', showMsg: false }" class="opacity-90">
                    <x-form.input-clipboard name="number" labelname="Ticket Number" type="number" readonly="true" :value="$nextTicketNumber" class="disabled:opacity-90"/>
                </div>
                {{-- <x-input.group inline for="date_received" label="Date Received" x-data="{ currentDate: '{{ now()->format('Y-m-d') }}' }">
                    <x-input.date name="date_received" wire:model.live.blur='date_received' id="date_received"/>
                </x-input.group> --}}
                <x-form.field>
                    <select name="status_id" id="status_id" disabled
                    class="disabled:opacity-90 disabled:text-slate-300 appearance-none block mt-1 w-full peer h-[3rem] px-6 text-sm text-white bg-gray-dark rounded-lg border-opacity-75 border-2 outline-none placeholder-gray-300 placeholder-opacity-0 transition duration-200 placeholder-transparent placeholder:pointer-events-none
                    ring-0 placeholder:select-none focus:shadow-md focus:shadow-odc-blue-700 focus:border-blue-secondary focus:ring-0">
                        @php
                            $statuses = \App\Models\Status::all();
                        @endphp

                        @foreach ($statuses as $status)
                            <option
                                value="{{ old('status_id') == $status->id ? 'selected' : '' }}"
                                class="py-4"
                            >{{ ucwords($status->name) }}</option>
                        @endforeach
                    </select>
                    <x-form.label class="-translate-y-[6px] peer-focus:-translate-y-[6px]" name="status" labelname="Status"/>
                    <x-form.error name="status_id"/>
            </x-form.field>
            </div>
            <div class="grid grid-cols-2 grid-rows-1 gap-4">
                <div x-data="{ currentDate: '{{ now()->format('Y-m-d') }}' }" >
                    <x-form.date x-model="currentDate" name="date_received" labelname="Date Received" type="date" class="appearance-none"/>
                </div>
                <x-form.input-tooltip wire:model='requested_by' name="requested_by" labelname="Requested By" type="text" tooltip="Person who requested assistance."/>
            </div>
            <div class="grid grid-cols-2 grid-rows-1 gap-4 mb-6">
                <x-form.input-tooltip name="client" labelname="Client" type="text" tooltip="Client or customer associated."/>
                <x-form.input-tooltip name="product" labelname="Product" type="text" tooltip="Relevant product or service."/>
            </div>
            <div class="flex flex-col space-y-4 border-t border-t-slate-300">
                {{-- * Title --}}
                <x-form.input-tooltip name="title" labelname="Title" type="text" tooltip="Brief description of the problem."/>

                {{-- <x-input.rich-text name="issue" id="issue" :value="$issue" /> --}}
                <div>
                    <input
                        id="x"
                        value="{{ $ticket->issue}}"
                        type="hidden"
                        name="issue">
                    <trix-editor
                        input="x"
                        x-data="{
                            upload(event) {
                                const data = new FormData();
                                data.append('attachment', event.attachment.file);

                                window.axios.post('/attachments', data, {
                                    onUploadProgress(progressEvent) {
                                        event.attachment.setUploadProgress(
                                            progressEvent.loaded / progressEvent.total * 100
                                        );
                                    },
                                }).then(({ data }) => {
                                    event.attachment.setAttributes({
                                        url: data.image_url,
                                    });
                                });
                            }
                        }"
                        x-on:trix-attachment-add="upload"
                    ></trix-editor>
                    <x-form.error name="issue"/>
                </div>

                {{-- * Dropzone --}}
                <div
                x-data="{ isUploading: false, progress: 5 }"
                x-on:livewire-upload-start="isUploading = true"
                x-on:livewire-upload-finish="isUploading = false; progress: 5"
                x-on:livewire-upload-error="isUploading = false"
                x-on:livewire-upload-progress="progress = $event.detail.progress"
                class="mt-4 flex items-center gap-4"
                >
                <div x-data="{ fileName: '' }" class="bg-transparent mt-1 w-full relative rounded-md">
                    <div x-ref="dnd"
                        class="relative flex items-center justify-center overflow-clip min-h-44 p-6 text-blue-secondary font-light border-2 border-blue-secondary border-dashed rounded-md cursor-pointer">
                        <input type="file" name="files" x-ref="file" @change="fileName = $refs.file.files[0].name"
                            class="absolute inset-0 z-50 w-full h-full p-0 m-0 outline-none opacity-0 cursor-pointer"
                            @dragover="$refs.dnd.classList.add('bg-odc-blue-300')"
                            @dragleave="$refs.dnd.classList.remove('bg-odc-blue-300')"
                            @drop="$refs.dnd.classList.remove('bg-odc-blue-300')"
                        />
                        <div class="flex flex-col items-center justify-center text-xs text-center">
                            @if ($ticket->files)
                            <img src="{{ $ticket->files->temporaryUrl() }}" alt="{{ $ticket->files->temporaryUrl() }}" class="absolute p-2 -z-10 inset-0 w-full h-full object-cover">
                            @else
                            <x-svg-icon name="export"/>
                            <div class="mt-2 text-center">
                                <p>Drag and Drop here</p>
                                <p>or</p>
                                <p class="underline">Browse Files</p>
                            </div>
                            @endif
                            <p class="mt-2 text-blue-secondary text-opacity-65"
                                x-text="fileName ? '' : 'Supported File Types: PNG, JPG, JPEG and WEBP only.'"></p>
                        </div>
                    </div>
                    <div class="mt-2 relative w-full">
                        <div x-show.transition="isUploading" class="rounded-xl bg-gray-dark">
                            <div
                                class="pl-2 text-center text-xs text-white bg-odc-blue-500 rounded-xl"
                                x-bind:style="`width: ${progress}%`"
                                role="progressbar"
                                aria-valuemin="0"
                                aria-valuemax="100"
                                x-text="progress ? progress + '%': '0%'"
                                >
                            </div>
                        </div>
                    </div>
                    <div x-text="fileName" class="mt-2 text-xs text-center text-blue-secondary"></div>
                    </div>
                    <x-form.error name="files"/>
                </div>
            </div>

            {{-- <x-form.input class="w-[31rem]" name="files" labelname="files" type="file"/> --}}

            <x-primary-button class="mt-4 float-end">Submit</x-primary-button>
        </form>

        @if (session()->has('message'))
            <div class="mt-2 text-green-500">
                {{ session('message') }}
            </div>
        @endif

    @endauth
</div>

{{-- @push('styles')
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@1.2.3/dist/trix.css">
@endpush

@push('scripts')
<script src="https://unpkg.com/trix@1.2.3/dist/trix.js"></script>
@endpush --}}

