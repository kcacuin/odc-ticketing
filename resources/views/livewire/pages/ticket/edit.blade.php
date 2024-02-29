<x-app-layout>
    <x-slot name="header">
        <h2 class="mr-10 text-left text-xl text-white dark:text-gray-200 leading-3">
            <p class="text-sm font-bold uppercase">Incident</p>
            <p class="font-thin">ODC{{ $ticket->number }}</p>
        </h2>
    </x-slot>
    <div class="max-w-8xl mx-auto relative my-8">
        @auth
            <form method="POST" action="{{ route('tickets.update', $ticket) }}" enctype="multipart/form-data" class="py-2 pb-6 px-8 bg-white mx-8">
                @csrf
                @method('PATCH')

                <div class="flex flex-row-reverse w-full gap-10">
                    {{-- * Right Column --}}
                    <div class="flex flex-col w-[25%]">
                        <div class="h-1/2">
                            {{-- * Ticket Number (Copy to Clipboard) --}}
                            <x-form.input-clipboard :value="old('number', $ticket->number)" name="number" labelname="Ticket Number" type="number"/>
                            {{-- * Status --}}
                            <x-form.field>
                                <select name="status_id" id="status_id"
                                class="appearance-none block mt-1 w-full peer h-[3rem] px-6 text-sm text-white bg-gray-dark rounded-lg border-opacity-75 border-2 outline-none placeholder-gray-300 placeholder-opacity-0 transition duration-200 placeholder-transparent placeholder:pointer-events-none
                                ring-0 placeholder:select-none focus:shadow-md focus:shadow-odc-blue-700 focus:border-blue-secondary focus:ring-0">
                                    @php
                                        $statuses = \App\Models\Status::all();
                                    @endphp

                                    {{-- @foreach ($statuses as $status)
                                        <option
                                            value="{{ old('status_id') == $status->id ? 'selected' : '' }}"
                                            class="py-4"
                                        >{{ ucwords($status->name) }}</option>
                                    @endforeach --}}

                                    @foreach ($statuses as $status)
                                        <option
                                            value="{{ $status->id }}"
                                            {{ old('status_id', $ticket->status_id) == $status->id ? 'selected' : '' }}>
                                            {{ ucwords($status->name) }}</option>
                                    @endforeach
                                </select>
                                <x-form.label class="-translate-y-[6px] peer-focus:-translate-y-[6px]" name="status" labelname="Status"/>
                                <x-form.error name="status_id"/>
                            </x-form.field>
                            {{-- * Date --}}
                            <x-form.date :value="old('date_received', $ticket->date_received)" name="date_received" labelname="Date Received" type="date" class="appearance-none"/>
                        </div>
                        {{-- * Dropzone --}}
                        <div class="h-1/2 flex flex-col">
                            <div
                                x-data="{ isUploading: false, progress: 5, fileName: '' }"
                                x-on:livewire-upload-start="isUploading = true"
                                x-on:livewire-upload-finish="isUploading = false; progress = 5"
                                x-on:livewire-upload-error="isUploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress"
                                class="flex items-center gap-4"
                            >
                                <div class="h-screen max-h-[11.4rem] w-full max-w-2xl relative rounded-md">
                                    <div x-ref="dnd"
                                        class="relative overflow-clip h-full p-6 text-blue-secondary font-light border-2 border-blue-secondary border-dashed rounded-md cursor-pointer">
                                        <input :value="old('files', $ticket->files)" multiple accept=".jpg, .jpeg, .png, .webp" type="file" name="files" x-ref="file" @change="fileName = $refs.file.files[0].name"
                                            class="absolute inset-0 z-50 w-full h-full p-0 m-0 outline-none opacity-0 cursor-pointer"
                                            @dragover="$refs.dnd.classList.add('bg-odc-blue-700')"
                                            @dragleave="$refs.dnd.classList.remove('bg-odc-blue-700')"
                                            @drop="$refs.dnd.classList.remove('bg-odc-blue-700')"
                                        />
                                        <div class="flex flex-col items-center justify-center text-xs text-center">
                                            <x-svg-icon name="export"/>
                                            <div class="mt-2 text-center">
                                                <p>Drag and Drop here</p>
                                                <p>or</p>
                                                <p class="underline">Browse Files</p>
                                            </div>
                                            <p class="mt-2 text-blue-primary text-opacity-55">Supported File Types: PNG, JPG, JPEG and WEBP only.</p>
                                        </div>
                                    </div>
                                    <div class="mt-2 relative w-full">
                                        <div x-show.transition="isUploading" class="rounded-xl bg-gray-dark">
                                            <div
                                                class="pl-2 text-center text-xs text-white bg-blue-500 rounded-xl"
                                                x-bind:style="`width: ${progress}%`"
                                                role="progressbar"
                                                aria-valuemin="0"
                                                aria-valuemax="100"
                                                x-text="progress ? progress + '%' : '0%'"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex justify-center">
                                        <span x-show="fileName" x-text="fileName" class="px-4 rounded-full border border-blue-secondary text-xs text-center text-blue-secondary"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- * Left Column --}}
                    <div class="flex flex-col w-[75%] pr-10 border-r border-r-slate-200">
                        <div class="grid grid-cols-3 grid-rows-1 gap-4 mb-6">
                            <x-form.input-tooltip :value="old('requested_by', $ticket->requested_by)" name="requested_by" labelname="Requested By" type="text" tooltip="Person who requested assistance."/>
                            <x-form.input-tooltip :value="old('client', $ticket->client)" name="client" labelname="Client" type="text" tooltip="Client or customer associated."/>
                            <x-form.input-tooltip :value="old('product', $ticket->product)" name="product" labelname="Product" type="text" tooltip="Relevant product or service."/>
                        </div>
                        <div class="flex flex-col space-y-4 border-t border-t-slate-200">
                            {{-- * Title --}}
                            <x-form.input-tooltip :value="old('title', $ticket->title)" name="title" labelname="Title" type="text" tooltip="Brief description of the problem."/>

                            {{-- <x-input.rich-text name="issue" id="issue" :value="$issue" /> --}}
                            <div>
                                <input
                                    id="x"
                                    value="{{old('issue', $ticket->issue)}}"
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
                                    class="h-52 w-[42rem] rounded-md overflow-y-auto"
                                ></trix-editor>
                                <x-form.error name="issue"/>
                            </div>

                            <div>
                                <x-primary-button class="mt-4 float-end border border-slate-300">Update</x-primary-button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @endauth
    </div>
    {{-- @livewire('ticket-edit') --}}
</x-app-layout>

{{-- @push('styles')
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@1.2.3/dist/trix.css">
@endpush

@push('scripts')
<script src="https://unpkg.com/trix@1.2.3/dist/trix.js"></script>
@endpush --}}
