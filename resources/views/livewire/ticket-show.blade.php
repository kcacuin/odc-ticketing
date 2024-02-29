<div class="mt-6 px-6 py-12 max-w-6xl mx-auto bg-white border border-slate-300">
    <div class="flex justify-between">
        <div class="">
            <div>
                <h1 class="text-xl text-blue-primary font-semibold">
                    {!! Illuminate\Support\Str::words($ticket->issue, 5, '...') !!}
                </h1>
                <span class="text-xs text-gray-600">
                    {{ $ticket->created_at->diffForHumans() }} by {{ $ticket->user->first_name }} {{ $ticket->user->last_name }}
                </span>
            </div>
            <div class="prose mt-6">
                {!! $ticket->issue !!}
            </div>
            <div class="mt-12">
                {{-- <h2 id="comments" class="text-sm font-semibold">Comments</h2> --}}

                @auth
                    <form action="{{ route('tickets.comments.store', $ticket) }}" method="POST" class="mt-2">
                        @csrf

                        {{-- * Issue --}}
                        <x-form.textarea name="body" labelname="Comments" type="text"/>
                        {{-- <x-input.rich-text name="body" id="body"/> --}}

                        <x-primary-button type="submit" class="mt-4">Add Comment</x-primary-button>
                    </form>

                    <ul class="divide-y mt-4">
                        @foreach ($comments as $comment)
                        <li class="py-4 p-2">
                            <p>{{ $comment->body }}</p>
                            <span class="text-xs text-gray-600">
                                {{ $comment->created_at->diffForHumans() }} by {{ $comment->user->first_name }} {{ $comment->user->last_name }}
                            </span>

                            @can('delete', $comment)
                            @endcan
                            <form action="{{ route('tickets.comments.destroy', ['ticket' => $ticket, 'comment' => $comment])}}"
                                method="POST" class="mt-2">
                                @csrf
                                @method('DELETE')
                                <x-danger-button wire:click='refresh' type="submit">Delete</x-danger-button>
                            </form>
                        </li>
                        @endforeach
                    </ul>
                @endauth

                <div class="mt-2">
                    {{ $comments->fragment('comments')->links() }}
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-4 text-blue-primary text-xs">
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
                        @switch($ticket->status->name)
                            @case('Open')
                                <x-badge class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">{{ $ticket->status->name }}</x-badge>
                                @break
                            @case('Pending')
                                <x-badge class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">{{ $ticket->status->name }}</x-badge>
                                @break
                            @case('In-progress')
                                <x-badge class="bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">{{ $ticket->status->name }}</x-badge>
                                @break
                            @case('In-review')
                                <x-badge class="bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300">{{ $ticket->status->name }}</x-badge>
                                @break
                            @case('Closed')
                                <x-badge class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">{{ $ticket->status->name }}</x-badge>
                                @break

                            <span class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">{{ $ticket->status->name }}</span>
                            @default
                        @endswitch
                    </div>
                    <div class="flex justify-between py-3">
                        <p class="font-bold">Created</p>
                        {{ $ticket->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
            <div class="flex flex-col border border-slate-300">
                <div class="p-3 flex justify-between bg-slate-200">
                    <h3>Attachments</h3>
                    <x-svg-icon name="attachment" />
                </div>
                <div class="p-3 flex flex-col">
                    <p>Saample Files</p>
                </div>
            </div>
        </div>
    </div>
</div>
