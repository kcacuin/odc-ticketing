<x-app-layout>
    <x-slot name="header">
        <h2 class="mr-10 text-left font-semibold text-xl text-white dark:text-gray-200 leading-tight">
            {{ __('Add Incident') }}
        </h2>
    </x-slot>
    <div class="py-12 max-w-5xl mx-auto relative">
        @auth
            <form method="POST" action="/tickets" enctype="multipart/form-data" class="mt-2">
                @csrf

                {{-- * Ticket Number (Copy to Clipboard) --}}
                <div x-data="{ input: '{{ $nextTicketNumber }}', showMsg: false }">
                    <x-form.input-clipboard  name="ticket_number" labelname="Ticket Number" type="number" readonly="true" :value="$nextTicketNumber"/>
                </div>
                <div class="grid grid-cols-2 grid-rows-1 gap-4">
                    {{-- <x-form.field>
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                            </svg>
                        </div>
                        <input name="date_received" datepicker datepicker-autohide datepicker-buttons datepicker-autoselect-today autocomplete="off" type="text" class="bg-gray-500  border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-secondary focus:border-blue-secondary block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-secondary dark:focus:border-blue-secondary" placeholder="Select Date Received">
                        <x-form.error name="date_received"/>
                        <x-form.label name="date_received" labelname="Date Received"/>
                    </x-form.field> --}}
                    <x-form.input  name="date_received" labelname="Date Received" type="date"/>
                    <x-form.input-tooltip  name="requested_by" labelname="Requested By" type="text" tooltip="Person who requested assistance."/>
                </div>
                <div class="grid grid-cols-2 grid-rows-1 gap-4">
                    <x-form.input-tooltip name="client" labelname="Client" type="text" tooltip="Client or customer associated."/>
                    <x-form.input-tooltip name="product" labelname="Product" type="text" tooltip="Relevant product or service."/>
                </div>
                <x-form.field>
                        <select name="status_id" id="status_id" required>
                            @php
                                $statuses = \App\Models\Status::all();
                            @endphp

                            @foreach ($statuses as $status)
                                <option
                                    value="{{ $status->id }}"
                                    {{ old('status_id') == $status->id ? 'selected' : '' }}
                                >{{ ucwords($status->name) }}</option>
                            @endforeach
                        </select>
                        <x-form.label name="status" labelname="Status"/>
                        <x-form.error name="status_id"/>
                </x-form.field>
                <x-form.textarea name="issue" labelname="Issue" type="text"/>
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
                                @dragover="$refs.dnd.classList.add('bg-blue-100')"
                                @dragleave="$refs.dnd.classList.remove('bg-blue-100')"
                                @drop="$refs.dnd.classList.remove('bg-blue-100')"
                            />
                            <div class="flex flex-col items-center justify-center text-xs text-center">
                                {{-- @if ($files) --}}
                                {{-- <img src="{{ $files->temporaryUrl() }}" alt="{{ $files->temporaryUrl() }}" class="absolute p-2 -z-10 inset-0 w-full h-full object-cover"> --}}
                                {{-- @else --}}
                                <x-svg-icon name="export"/>
                                <div class="mt-2 text-center">
                                    <p>Drag and Drop here</p>
                                    <p>or</p>
                                    <p class="underline">Browse Files</p>
                                </div>
                                {{-- @endif --}}
                                <p class="mt-2 text-blue-secondary text-opacity-65"
                                    x-text="fileName ? '' : 'Supported File Types: PNG, JPG, JPEG and WEBP only.'"></p>
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
                                    x-text="progress ? progress + '%': '0%'"
                                    >
                                </div>
                            </div>
                        </div>
                        <div x-text="fileName" class="mt-2 text-xs text-center text-white"></div>
                        </div>
                </div>
                {{-- <x-form.input class="w-[31rem]" name="files" labelname="files" type="file"/> --}}

                <x-primary-button class="mt-4">Submit</x-primary-button>
            </form>

            @if (session()->has('message'))
                <div class="mt-2 text-green-500">
                    {{ session('message') }}
                </div>
            @endif

        @endauth
    </div>
</x-app-layout>
