<x-app-layout>
    <x-slot name="header">
        <h2 class="mr-10 text-left text-xl text-white dark:text-gray-200 leading-3">
            <p class="text-xs font-bold uppercase">Incident</p>
            <p class="font-thin">ODC{{ $ticket->number }}</p>
        </h2>
    </x-slot>
    <div class="mt-6 px-6 py-6 max-w-6xl mx-auto bg-white border border-slate-300">
        <div class="flex justify-between">
            <div>
                <div>
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
                    <div class="prose mt-6">
                        {!! clean($ticket->issue) !!}
                    </div>
                </div>
                <div class="mt-12 border-t border-t-slate-200">

                    @auth
                    <div class="mt-6">
                        <h3 class="text-lg font-bold">Notes</h3>
                    </div>
                    <ul class="divide-y mt-2 divide-slate-200">
                        @foreach ($notes as $note)
                        <li class="py-4 p-2">
                            <div class="px-3 py-2 rounded-md bg-slate-100">
                                <p class="text-base font-bold">{{ $note->user->first_name }} {{ $note->user->last_name }}</p>
                                <p>{!! clean($note->body) !!}</p>
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
                                <input
                                    id="x"
                                    name="body"
                                    type="hidden">
                                <trix-editor
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
                                    class="h-52 w-[42rem] rounded-md overflow-y-auto"
                                ></trix-editor>
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
            <div class="flex flex-col gap-4 w-72 text-blue-primary text-xs">
                <div class="flex flex-col border border-slate-300">
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
                            <x-badge class="bg-{{ $ticket->status_color }}-100 text-{{ $ticket->status_color }}-800 dark:bg-{{ $ticket->status_color }}-900 dark:text-{{ $ticket->status_color }}-300">{{ $ticket->status->name }}</x-badge>
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
                <div class="flex flex-col border border-slate-300">
                    <div class="p-3 flex justify-between bg-slate-200">
                        <h3>Attachments</h3>
                        <x-svg-icon class="scale-90" name="attachment" />
                    </div>
                    <div class="p-3 flex flex-col">
                        <a href="#">{!! clean(Illuminate\Support\Str::limit($ticket->files, 20, '...')) !!}</a>
                        {{-- <p class="">{{ $ticket->files }}</p> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
