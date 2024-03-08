<x-app-layout>
    <x-slot name="header">
        <h2 class="mr-10 text-left text-xl text-white dark:text-gray-200 leading-3">
            <p class="text-xs font-bold uppercase">Incident</p>
            <a href="{{ route('tickets.show', $ticket) }}">
                <div x-data="{ showArrow: false }">
                    <p
                        class="relative font-thin"
                        @mouseover="showArrow = true"
                        @mouseout="showArrow = false"
                    >
                        ODC{{ $ticket->number }}
                        <span
                            x-show="showArrow"
                            class="absolute -translate-y-4"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-90"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-90"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                            </svg>
                        </span>
                    </p>
                </div>
            </a>
        </h2>
    </x-slot>
    <div class="max-w-8xl mx-auto relative my-8">
        @auth
            <form method="POST" action="{{ route('tickets.update', ['ticket' => $ticket->id]) }}" enctype="multipart/form-data" class="py-2 pb-6 px-8 bg-white mx-8">
                @csrf
                @method('PATCH')

                <div class="flex flex-row-reverse w-full gap-10">
                    {{-- * Right Column --}}
                    <div class="flex flex-col w-[25%]">
                        <div class="mb-4">
                            {{-- * Ticket Number (Copy to Clipboard) --}}
                            <x-form.input-clipboard xModel="ticketNumber" :value="old('number', $ticket->number)" name="number" labelname="Ticket Number" type="number"/>
                            {{-- * Status --}}
                            <x-form.field>
                                <select xModel="ticketStatus" name="status_id" id="status_id"
                                class="appearance-none block mt-1 w-full peer h-[3rem] px-6 text-sm text-white bg-gray-dark rounded-lg border-opacity-75 border-2 outline-none placeholder-gray-300 placeholder-opacity-0 transition duration-200 placeholder-transparent placeholder:pointer-events-none
                                ring-0 placeholder:select-none focus:shadow-md focus:shadow-odc-blue-700 focus:border-blue-secondary focus:ring-0">
                                    @php
                                        $statuses = \App\Models\Status::all();
                                    @endphp
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
                            <x-form.date xModel="ticketDate" :value="old('date_received', $ticket->date_received)" name="date_received" labelname="Date Received" type="date" class="appearance-none"/>
                        </div>
                        {{-- * Dropzone --}}
                        <div class="flex flex-col h-52 overflow-y-auto">
                            <div class="rounded-md border border-dashed border-blue-secondary bg-[#f1f0ef]">
                                <x-input.filepond xModel="ticketFiles" name="files" multiple/>

                                {{-- @if ($ticket->files) --}}
                                    {{-- @foreach ($ticket->files as $file)
                                        <div>
                                            <span>{{ $file->file_name }}</span> --}}
                                            {{-- <a href="{{ route('load-file', ['id' => $file->id]) }}" target="_blank">{{ $file->file_name }}</a> --}}
                                        {{-- </div> --}}
                                    {{-- @endforeach --}}
                                {{-- @else --}}
                                    {{-- <p>No files uploaded for this ticket.</p> --}}
                                {{-- @endif --}}

                                {{-- @foreach ($ticket->files ?? collect() as $file)
                                    <div>
                                        <a href="{{ route('tmp-load', ['folder' => $file->folder, 'filename' => $file->file_name]) }}" target="_blank">{{ $file->file_name }}</a>
                                    </div>
                                @endforeach --}}
                            </div>
                            @if ($files->isNotEmpty())
                                <div class="mt-4">
                                    <h2 class="text-xs">Attachments:</h2>
                                    <ul>
                                        <div>
                                            @foreach($files as $file)
                                                @if(isset($files[0]))
                                                <li class="hidden">
                                                    <a href="{{ asset('storage/attached_files/' . $file->file_path . $file->file_name) }}" target="_blank"
                                                        class="text-xs"
                                                    >{{ $file->file_name }}</a>
                                                    <form action="{{ route('tickets.files.destroy', ['ticket' => $ticket, 'file' => $file])}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit">Delete</button>
                                                    </form>
                                                </li>
                                                @endif

                                                <li class="flex items-center justify-between">
                                                    <a href="{{ asset('storage/attached_files/' . $file->file_path . $file->file_name) }}" target="_blank"
                                                        class="text-xs"
                                                    >{{ $file->file_name }}</a>
                                                    <form action="{{ route('tickets.files.destroy', ['ticket' => $ticket, 'file' => $file])}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-xs">Delete</button>
                                                    </form>
                                                </li>
                                            @endforeach
                                        </div>
                                    </ul>
                                </div>
                            @else
                                <span class="mt-4 text-center text-xs text-blue-secondary">No files attached to this ticket.</span>
                            @endif
                        </div>
                    </div>
                    {{-- * Left Column --}}
                    <div class="flex flex-col w-[75%] pr-10 border-r border-r-slate-200">
                        <div class="grid grid-cols-3 grid-rows-1 gap-4 mb-6">
                            <x-form.input-tooltip xModel="ticketRequestedBy" :value="old('requested_by', $ticket->requested_by)" name="requested_by" labelname="Requested By" type="text" tooltip="Person who requested assistance."/>
                            <x-form.input-tooltip xModel="ticketClient" :value="old('client', $ticket->client)" name="client" labelname="Client" type="text" tooltip="Client or customer associated."/>
                            <x-form.input-tooltip xModel="ticketProduct" :value="old('product', $ticket->product)" name="product" labelname="Product" type="text" tooltip="Relevant product or service."/>
                        </div>
                        <div class="flex flex-col space-y-4 border-t border-t-slate-200">
                            {{-- * Title --}}
                            <x-form.input-tooltip xModel="ticketTitle" :value="old('title', $ticket->title)" name="title" labelname="Title" type="text" tooltip="Brief description of the problem."/>

                            {{-- <x-input.rich-text name="issue" id="issue" :value="$issue" /> --}}
                            <div class="relative">
                                <x-form.trix-input x-model="ticketIssue" value="{!! $ticket->issue->toTrixHTML() !!}" id="issue" name="issue" class="h-52 rounded-md overflow-y-auto"/>
                                {{-- <input
                                    id="x"
                                    xModel="ticketIssue"
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
                                    class="h-52 rounded-md overflow-y-auto"
                                ></trix-editor>
                                <x-form.error name="issue"/> --}}
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
