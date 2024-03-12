<x-app-layout>
    <x-slot name="header">
        <h2 class="mr-10 text-left text-xl text-white dark:text-gray-200 leading-3">
            <p class="text-xs font-bold uppercase">Incident</p>
            <p class="font-thin">ODC{{ $ticket->number }}</p>
        </h2>
    </x-slot>
    @section('title', 'Incident ' . $ticket->number)

    <div class="mt-6 px-6 py-6 max-w-6xl mx-auto bg-white border border-slate-200">
        <div class="flex justify-between">
            {{-- * Left --}}
            <div class="mr-32">
                {{-- * Top --}}
                <div>
                    <div class="flex items-start justify-between">
                        <div>
                            <h1 class="text-xl text-blue-primary font-semibold">
                                {!! clean($ticket->title) !!}
                            </h1>
                            <div class="text-xs">
                                <span class="text-gray-600">
                                    {{ $ticket->created_at->diffForHumans() }} by
                                </span>
                                <span class="font-bold">
                                    {!! clean($ticket->user->first_name . ' ' . $ticket->user->last_name) !!}
                                </span>
                            </div>
                        </div>
                        <div>
                            <a class="group text-odc-blue-800 font-bold underline transition " href="{{ route('tickets.edit', $ticket) }}">
                                {{-- <x-svg-icon class="scale-90 text-blue-secondary hover:opacity-80" name="edit" /> --}}
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                                  </svg>

                            </a>
                        </div>
                    </div>
                    <div class="prose my-6 py-6 border-t border-b border-slate-200">
                        {!! clean($ticket->issue->toTrixHTML()) !!}
                    </div>
                </div>
                {{-- * Bottom --}}
                <div>
                    @auth
                    <div>
                        <h3 class="text-lg font-bold">Notes</h3>
                    </div>
                    <ul class="divide-y mt-2 divide-slate-200">
                        @foreach ($notes as $note)
                        <li class="py-4 p-2">
                            <div class="px-3 py-2 rounded-md bg-slate-100">
                                <p class="text-base font-bold">{{ $note->user->first_name }} {{ $note->user->last_name }}</p>
                                <div>{!! clean($note->body) !!}</div>
                            </div>
                            <div class="px-3 flex items-center justify-between">
                                <span class="text-xs text-gray-600">
                                    {{ $note->created_at->diffForHumans() }}
                                </span>
                                <div
                                    x-data="{
                                        open: false,
                                        toggle() {
                                            if (this.open) {
                                                return this.close()
                                            }

                                            this.$refs.button.focus()

                                            this.open = true
                                        },
                                        close(focusAfter) {
                                            if (! this.open) return

                                            this.open = false

                                            focusAfter && focusAfter.focus()
                                        }
                                    }"
                                    x-on:keydown.escape.prevent.stop="close($refs.button)"
                                    x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
                                    x-id="['dropdown-button']"
                                    class="relative"
                                >
                                    <!-- Button -->
                                    <button
                                        x-ref="button"
                                        x-on:click="toggle()"
                                        :aria-expanded="open"
                                        :aria-controls="$id('dropdown-button')"
                                        type="button"
                                    >
                                        •••
                                    </button>
                                    <!-- Panel -->
                                    <div
                                        x-ref="panel"
                                        x-show="open"
                                        x-transition.origin.bottom.right
                                        x-on:click.outside="close($refs.button)"
                                        :id="$id('dropdown-button')"
                                        style="display: none;"
                                        class="absolute z-10 left-12 -bottom-6 rounded-md"
                                    >
                                        {{-- * Add edit button here --}}

                                        <form action="{{ route('tickets.notes.destroy', ['ticket' => $ticket, 'note' => $note])}}"
                                            method="POST" class="mt-2">
                                            @csrf
                                            @method('DELETE')

                                            <x-danger-button type="submit">
                                                <x-svg-icon class="scale-75 mr-2" name="trash"/>
                                                Delete
                                            </x-danger-button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            {{-- @can('delete', $note)
                            @endcan --}}
                        </li>
                        @endforeach
                    </ul>
                    <form action="{{ route('tickets.notes.store', $ticket) }}" method="POST" class="mt-2">
                        @csrf
                        {{-- * Add Notes --}}
                        <div class="relative">
                            <div class="mt-6">
                                <x-form.trix-input value="{!! $ticket->notes->body->toTrixHTML() !!}" id="body" name="body" class="h-52 rounded-md overflow-y-auto" placeholder="Write your notes here..."/>
                                {{-- <input
                                    id="x"
                                    name="body"
                                    type="hidden"> --}}
                                {{-- <trix-editor
                                    placeholder="Write your notes here..."
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
                                ></trix-editor> --}}
                            </div>
                            <div class="relative">
                                <div class="absolute right-4 bottom-2">
                                    <button type="submit" class="group text-blue-secondary hover:text-odc-blue-950">
                                        <x-svg-icon class="transition group-hover:drop-shadow-xl group-focus    :translate-x-1 " name="send"/>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    @endauth

                    <div class="mt-2">
                        {{ $notes->fragment('notes')->links() }}
                    </div>
                </div>
            </div>
            {{-- * Right --}}
            <div class="flex flex-col gap-4 w-80 text-blue-primary text-xs">
                {{-- * Top --}}
                <div class="flex flex-col border border-slate-200">
                    <div class="p-3 bg-slate-200">
                        <h3>Your request has been submitted</h3>
                    </div>
                    <div class="p-3">
                        <div class="flex justify-between py-3">
                            <p class="font-bold">Number</p>
                            {{ $ticket->number }}
                        </div>
                        <div class="flex justify-between py-3">
                            <p class="font-bold">Status</p>
                            <x-badge class="bg-{{ $ticket->status_color }}-100 text-{{ $ticket->status_color }}-800 dark:bg-{{ $ticket->status_color }}-900 dark:text-{{ $ticket->status_color }}-200">{{ $ticket->status->name }}</x-badge>
                        </div>
                        <div class="flex justify-between py-3">
                            <p class="font-bold">Created</p>

                            <div x-data="{ tooltip: false }" class="relative z-30 inline-flex">
                                <span x-on:mouseover="tooltip = true" x-on:mouseleave="tooltip = false">
                                    {{ $ticket->created_at->diffForHumans() }}
                                </span>
                                <div x-cloak x-show.transition.origin.top="tooltip">
                                    <div class="info-tooltip absolute z-[999] max-w-2xl ring-1 ring-slate-400 whitespace-nowrap -top-2 left-1/2 p-2 -mt-1 text-xs font-medium leading-tight text-white transform -translate-x-1/2 -translate-y-full bg-gray-dark rounded-lg shadow-lg">
                                    {{ $ticket->created_at }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-between py-3">
                            <p class="font-bold">Updated</p>
                            <div x-data="{ tooltip: false }" class="relative z-30 inline-flex">
                                <span x-on:mouseover="tooltip = true" x-on:mouseleave="tooltip = false">
                                    {{ $ticket->updated_at->diffForHumans() }}
                                </span>
                                <div x-cloak x-show.transition.origin.top="tooltip">
                                    <div class="info-tooltip absolute z-[999] max-w-2xl ring-1 ring-slate-400 whitespace-nowrap -top-2 left-1/2 p-2 -mt-1 text-xs font-medium leading-tight text-white transform -translate-x-1/2 -translate-y-full bg-gray-dark rounded-lg shadow-lg">
                                    {{ $ticket->updated_at }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- * Bottom --}}
                <div class="flex flex-col border border-slate-300">
                    <div class="p-3 flex justify-between bg-slate-200">
                        <h3>Attachments</h3>
                        <x-svg-icon class="scale-90" name="attachment" />
                    </div>
                    <div class="p-3 flex flex-col">
                        @if ($files->isNotEmpty())
                            <ul class="flex flex-col gap-4">
                                <div>
                                    @foreach($files as $file)
                                    <li class="flex items-center justify-between" x-data="{ submitting: false }">
                                        <a href="{{ asset('storage/attached_files/' . $file->file_path) }}" target="_blank">{{ $file->file_name }}</a>
                                        <form action="{{ route('tickets.files.destroy', ['ticket' => $ticket, 'file' => $file])}}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <div x-data="{ modelOpen: false }">
                                                <button @click.prevent="modelOpen =!modelOpen" class="text-red-primary">
                                                    <x-svg-icon name="trash" class="scale-75" />
                                                </button>

                                                <div x-show="modelOpen" x-bind:class="{ 'pointer-events-none': submitting }" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                                    <div class="flex items-center justify-center min-h-screen text-center md:items-center sm:block sm:p-0">
                                                        <div x-cloak @click.prevent="modelOpen = false" x-show="modelOpen"
                                                            x-transition:enter="transition ease-out duration-300 transform"
                                                            x-transition:enter-start="opacity-0"
                                                            x-transition:enter-end="opacity-100"
                                                            x-transition:leave="transition ease-in duration-200 transform"
                                                            x-transition:leave-start="opacity-100"
                                                            x-transition:leave-end="opacity-0"
                                                            class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-55" aria-hidden="true"
                                                        ></div>

                                                        <div x-cloak x-show="modelOpen"
                                                            x-transition:enter="transition ease-out duration-300 transform"
                                                            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                            x-transition:leave="transition ease-in duration-200 transform"
                                                            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                            x-transition:leave-end="opacity-0 transate-y-4 sm:translate-y-0 sm:scale-95"
                                                            class="inline-block w-full max-w-sm p-4 my-20 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl"
                                                        >
                                                            <div class="p-4 md:p-5 text-center">
                                                                <svg class="mx-auto mb-4 w-12 h-12 text-red-primary dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                                </svg>
                                                                <h1 class="mb-3 text-xl font-extrabold text-gray-800 ">Are you sure?</h1>
                                                                <h3 class="mb-4 text-sm font-normal text-gray-500 dark:text-gray-400">This action will delete <span class="font-bold">{{ $file->file_name }}</span>!</h3>
                                                                <div class="space-x-4">
                                                                    <x-primary-button @click.prevent="modelOpen = false" type="button" class="border border-slate-300">No, cancel</x-primary-button>
                                                                    <button :disabled="submitting" class="px-3 py-2 text-xs tracking-widest text-white uppercase transition-colors duration-200 transform bg-odc-red-600 rounded-md dark:bg-odc-red-700 dark:hover:bg-odc-red-800 dark:focus:bg-odc-red-800 hover:bg-odc-red-700 focus:outline-none focus:bg-odc-red-600 focus:ring focus:ring-odc-red-400 focus:ring-opacity-50">
                                                                        <span x-show="!submitting">Yes, delete it</span>
                                                                        <span x-show="submitting">
                                                                            <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-1 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                                                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"/>
                                                                            </svg>
                                                                            Deleting...
                                                                        </span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                    </li>
                                    @endforeach
                                </div>
                            </ul>
                        @else
                            <p>No files attached to this ticket.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
