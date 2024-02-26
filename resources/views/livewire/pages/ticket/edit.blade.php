<x-app-layout>
    <x-slot name="header">
        <h2 class="mr-10 text-left text-xl text-white dark:text-gray-200 leading-3">
            <p class="text-sm font-bold uppercase">Incident</p>
            <p class="font-thin">ODC{{ $ticket->number }}</p>
        </h2>
    </x-slot>
    <div class="py-12 max-w-5xl mx-auto">
        @auth
            <form method="POST" action="{{ route('tickets.update', $ticket) }}" enctype="multipart/form-data" class="mt-2">
                @csrf
                @method('PATCH')

                <x-form.input name="number" :value="old('number', $ticket->number)" labelname="Ticket Number" type="number"/>
                <div class="grid grid-cols-2 grid-rows-1 gap-4">
                    <x-form.input  name="date_received" :value="old('date_received', $ticket->date_received)" labelname="Date Received" type="date"/>
                    <x-form.input  name="requested_by" :value="old('requested_by', $ticket->requested_by)" labelname="Requested By" type="text"/>
                </div>
                <div class="grid grid-cols-2 grid-rows-1 gap-4">
                    <x-form.input name="client" :value="old('client', $ticket->client)" labelname="Client" type="text"/>
                    <x-form.input name="product" :value="old('product', $ticket->product)" labelname="Product" type="text"/>
                </div>
                <x-form.field>
                    <select name="status_id" id="status_id">
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
                    <x-form.error name="status_id"/>
                    <x-form.label name="status" labelname="Status"/>
                </x-form.field>
                <x-form.textarea name="issue" labelname="Issue" type="text">
                    {!! nl2br(old('issue', $ticket->issue)) !!}
                </x-form.textarea>
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
                                @dragover="$refs.dnd.classList.add('bg-odc-blue-100')"
                                @dragleave="$refs.dnd.classList.remove('bg-odc-blue-100')"
                                @drop="$refs.dnd.classList.remove('bg-odc-blue-100')"
                            />
                            <div class="flex flex-col items-center justify-center text-xs text-center">
                                <x-svg-icon name="export"/>
                                <div class="mt-2 text-center">
                                    <p>Drag and Drop here</p>
                                    <p>or</p>
                                    <p class="underline">Browse Files</p>
                                </div>
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

                <x-primary-button class="mt-4">Update</x-primary-button>
            </form>
        @endauth
    </div>
</x-app-layout>
