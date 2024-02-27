<x-app-layout>
    <x-slot name="header">
        <h2 class="mr-10 text-left font-semibold text-xl text-white dark:text-gray-200 leading-tight">
            {{ __('Add Incident') }}
        </h2>
    </x-slot>
    <div class="py-10 px-4 max-w-6xl mx-auto relative">
        @auth
            <form method="POST" action="/tickets" enctype="multipart/form-data" class="mt-2">
                @csrf

                {{-- * Ticket Number (Copy to Clipboard) --}}
                <div class="grid grid-cols-2 grid-rows-1 gap-4">
                    <div x-data="{ input: '{{ $nextTicketNumber }}', showMsg: false }">
                        <x-form.input-clipboard  name="number" labelname="Ticket Number" type="number" readonly="true" :value="$nextTicketNumber"/>
                    </div>
                    <div x-data="{ currentDate: '{{ now()->format('Y-m-d') }}' }">
                        <x-form.input x-model="currentDate" name="date_received" labelname="Date Received" type="date" class="appearance-none"/>
                    </div>
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
                    <x-form.input-tooltip  name="requested_by" labelname="Requested By" type="text" tooltip="Person who requested assistance."/>
                    <x-form.input-tooltip name="client" labelname="Client" type="text" tooltip="Client or customer associated."/>
                </div>
                <div class="grid grid-cols-2 grid-rows-1 gap-4">
                    <x-form.input-tooltip name="product" labelname="Product" type="text" tooltip="Relevant product or service."/>
                    <x-form.field>
                            <select name="status_id" id="status_id" required
                            class="appearance-none block mt-1 w-full peer h-[3rem] px-6 text-sm text-white bg-gray-dark rounded-lg border-opacity-75 border-2 outline-none placeholder-gray-300 placeholder-opacity-0 transition duration-200 placeholder-transparent placeholder:pointer-events-none
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
                            <x-form.label class="-translate-y-[0.3rem] peer-focus:-translate-y-[0.3rem]" name="status" labelname="Status"/>
                            <x-form.error name="status_id"/>
                    </x-form.field>
                </div>
                <div class="grid grid-cols-2 grid-rows-1 gap-4">
                    <div>
                        {{-- * Title --}}
                        <x-form.input-tooltip name="title" labelname="Title" type="text" tooltip="Brief description of the problem."/>
                        {{-- * Issue --}}
                        <x-form.textarea name="issue" labelname="Issue" type="text"/>
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
