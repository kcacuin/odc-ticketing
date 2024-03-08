<x-app-layout>
    <x-slot name="header">
        <h2 class="mr-10 text-left text-xl text-white dark:text-gray-200 leading-3">
            <p class="text-xs font-bold uppercase">Incident</p>
            <p class="font-thin">ODC{{ $ticket->number }}</p>
        </h2>
    </x-slot>
    <div class="mt-6 px-6 py-6 max-w-6xl mx-auto bg-white border border-slate-200">
        <div class="flex justify-between">
            <div class="mr-32">
                <div>
                    <div class="flex items-start justify-between">
                        <div>
                            <h1 class="text-xl text-blue-primary font-semibold">
                                {!! $ticket->title !!}
                                {{-- {!! Illuminate\Support\Str::words($ticket->title, 5, '...') !!} --}}
                            </h1>
                            <div class="text-xs">
                                <span class="text-gray-600">
                                    {{ $ticket->created_at->diffForHumans() }} by
                                </span>
                                <span class="font-bold">
                                    {{ $ticket->user->first_name }} {{ $ticket->user->last_name }}
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
                                @foreach($files as $file)
                                <a href="{{ asset('storage/attached_files/' . $file->file_path . $file->file_name) }}" target="_blank">{{ $file->file_name }}</a>
                                @endforeach
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
