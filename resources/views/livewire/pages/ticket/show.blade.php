<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>
    <div class="py-12 max-w-5xl mx-auto">
        <div>
            <h1 class="text-3xl font-semibold">{{ $post->title }}</h1>
            <span class="text-sm text-gray-600">
                {{ $post->created_at->diffForHumans() }} by {{ $post->user->name }}
            </span>
        </div>
        <div class="prose mt-6">
            {!! $post->body !!}
        </div>
        <div class="mt-12">
            <h2 id="comments" class="2xl font-semibold">Comments</h2>

            @auth
                <form action="{{ route('posts.comments.store', $post) }}" method="POST" class="mt-2">
                    @csrf

                    <textarea name="body" id="body" cols="30" rows="5" class="w-full"></textarea>
                    <x-primary-button type="submit">Add Comment</x-primary-button>
                </form>
            @endauth

            <ul class="divide-y mt-4">
                @foreach ($comments as $comment)
                    <li class="py-4 p-2">
                        <p>{{ $comment->body }}</p>
                        <span class="text-sm text-gray-600">
                            {{ $comment->created_at->diffForHumans() }} by {{ $comment->user->name }}
                        </span>

                        @can('delete', $comment)
                            <form action="{{ route('posts.comments.destroy', ['post' => $post, 'comment' => $comment])}}"
                                method="POST" class="mt-2">
                                @csrf
                                @method('DELETE')
                                <x-danger-button wire:click='refresh' type="submit">Delete</x-danger-button>
                            </form>
                        @endcan
                    </li>
                @endforeach
            </ul>

            <div class="mt-2">
                {{ $comments->fragment('comments')->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
