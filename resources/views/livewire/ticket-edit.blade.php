<div class="py-12 max-w-5xl mx-auto">
    @auth
        <form method="POST" action="{{ route('tickets.update', $ticket) }}" enctype="multipart/form-data" class="mt-2">
            @csrf
            @method('PATCH')

            {{-- <x-form.input name="number" :value="old('number', $ticket->number)" labelname="Ticket Number" type="number"/> --}}
            {{-- <div class="grid grid-cols-2 grid-rows-1 gap-4"> --}}
                {{-- <x-form.input  name="date_received" :value="old('date_received', $ticket->date_received)" labelname="Date Received" type="date"/> --}}
                {{-- <x-form.input  name="requested_by" :value="old('requested_by', $ticket->requested_by)" labelname="Requested By" type="text"/> --}}
            {{-- </div> --}}
            <div class="grid grid-cols-2 grid-rows-1 gap-4">
                <div>
                    <x-form.input-clipboard :value="old('number', $ticket->number)"  name="number" labelname="Ticket Number" type="number" readonly="true" />
                </div>
                <div x-data="{ currentDate: '{{ now()->format('Y-m-d') }}' }" >
                    <x-form.date :value="old('date_received', $ticket->date_received)" name="date_received" labelname="Date Received" type="date" class="appearance-none"/>
                </div>
            </div>
            <div class="grid grid-cols-2 grid-rows-1 gap-4">
                <x-form.input-tooltip :value="old('requested_by', $ticket->requested_by)" name="requested_by" labelname="Requested By" type="text" tooltip="Person who requested assistance."/>
                <x-form.input-tooltip :value="old('client', $ticket->client)" name="client" labelname="Client" type="text" tooltip="Client or customer associated."/>
            </div>
            {{-- <div class="grid grid-cols-2 grid-rows-1 gap-4">
                <x-form.input name="client" :value="old('client', $ticket->client)" labelname="Client" type="text"/>
                <x-form.input name="product" :value="old('product', $ticket->product)" labelname="Product" type="text"/>
            </div> --}}
            <div class="grid grid-cols-2 grid-rows-1 gap-4 mb-6">
                <x-form.input-tooltip :value="old('product', $ticket->product)" name="product" labelname="Product" type="text" tooltip="Relevant product or service."/>
                <x-form.field>
                        <select name="status_id" id="status_id" required
                        class="appearance-none block mt-1 w-full peer h-[3rem] px-6 text-sm text-white bg-gray-dark rounded-lg border-opacity-75 border-2 outline-none placeholder-gray-300 placeholder-opacity-0 transition duration-200 placeholder-transparent placeholder:pointer-events-none
                        ring-0 placeholder:select-none focus:shadow-md focus:shadow-odc-blue-700 focus:border-blue-secondary focus:ring-0">
                            @php
                                $statuses = \App\Models\Status::all();
                            @endphp

                            @foreach ($statuses as $status)
                                    <option
                                    value="{{ $status->id }}"
                                    {{ old('status_id', $ticket->status_id ) == $status->id ? 'selected' : '' }}
                                >{{ ucwords($status->name) }}</option>
                            @endforeach
                        </select>
                        <x-form.label class="-translate-y-[6px] peer-focus:-translate-y-[6px]" name="status" labelname="Status"/>
                        <x-form.error name="status_id"/>
                </x-form.field>
            </div>
            <div class="flex flex-col space-y-4 border-t border-t-slate-300">
                {{-- * Title --}}
                <x-form.input-tooltip :value="old('title', $ticket->title)" name="title" labelname="Title" type="text" tooltip="Brief description of the problem."/>
                {{-- * Issue --}}
                <x-input.rich-text :value="old('issue', $ticket->issue)" name="issue" id="issue"/>

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
            <x-primary-button class="mt-4">Update</x-primary-button>
        </form>
    @endauth
</div>
