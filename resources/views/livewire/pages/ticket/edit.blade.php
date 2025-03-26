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
    @section('title', 'Edit - Incident ' . $ticket->number)

    <div class="max-w-8xl mx-auto relative my-8" x-data="{ submitting: false }">
        @auth
            <div x-show="submitting" @click.window="handleWindowClick" class="fixed inset-0 flex items-center justify-center pointer-event-all">
                <div class="absolute inset-0 opacity-50 pointer-event-all"></div>
            </div>

            <form @submit="submitting = true;" method="POST" action="{{ route('tickets.update', $ticket->number) }}" enctype="multipart/form-data" class="py-2 pb-6 px-8 bg-primary-background rounded-md border border-border mx-8">
                @csrf
                @method('PATCH')

                <div class="flex flex-row-reverse w-full gap-10">
                    <div class="flex flex-col w-[25%]">
                        <div class="mb-4">
                            <div>
                                <x-form.input-clipboard name="number" labelname="Ticket Number" type="number" readonly="true" :value="old('number', $ticket->number)" class="disabled:opacity-30 disabled:bg-slate-400/20"/>
                                <input type="hidden" x-on:input="wire.emit('ticketIdUpdated', input)">
                            </div>
                            {{-- <x-form.input :value="old('number', $ticket->number)" name="number" labelname="Ticket Number" type="number"/> --}}
                            <x-form.field>
                                <select xModel="ticketStatus" name="status_id" id="status_id"
                                class="disabled:opacity-30 disabled:bg-slate-400/20 appearance-none block mt-1 w-full peer h-[3rem] px-6 text-sm text-text bg-primary-background rounded-lg border-border border-2 outline-none placeholder-gray-300 placeholder-opacity-0 transition duration-200 placeholder-transparent placeholder:pointer-events-none
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
                            <x-form.date xModel="ticketDate" :value="old('date_received', $ticket->date_received)" name="date_received" labelname="Date Received" type="date" class="appearance-none"/>
                        </div>
                        <div class="flex flex-col h-52 overflow-y-auto">
                            <div class="relative max-h-52 overflow-y-auto bg-primary-background rounded-md border border-dashed border-border">
                                <x-input.filepond xModel="ticketFiles" name="files" multiple/>
                            </div>
                            @if ($files->isNotEmpty())
                                <div class="mt-4 flex flex-col text-center text-xs text-blue-secondary">
                                    <span>There are files attached to this ticket.</span>
                                    <a href="{{ route('tickets.show', $ticket->number) }}" class="underline">Click here to view</a>
                                </div>
                            @else
                                <span class="mt-4 text-center text-xs text-text/65 italic">No files attached to this ticket.</span>
                            @endif
                        </div>
                    </div>
                    <div class="flex flex-col w-[75%] pr-10 border-r border-r-border">
                        <div class="grid grid-cols-3 grid-rows-1 gap-4 mb-6">
                            <x-form.input-tooltip xModel="ticketRequestedBy" :value="old('requested_by', $ticket->requested_by)" name="requested_by" labelname="Requested By" type="text" tooltip="Person who requested assistance."/>
                            <x-form.input-tooltip xModel="ticketClient" :value="old('client', $ticket->client)" name="client" labelname="Client" type="text" tooltip="Client or customer associated."/>
                            <x-form.input-tooltip xModel="ticketProduct" :value="old('product', $ticket->product)" name="product" labelname="Product" type="text" tooltip="Relevant product or service."/>
                        </div>
                        <div class="flex flex-col border-t border-t-border">
                            <x-form.input-tooltip xModel="ticketTitle" :value="old('title', $ticket->title)" name="title" labelname="Title" type="text" tooltip="Brief description of the problem."/>

                            <div class="relative">
                                <x-form.trix-input value="{!! $ticket->issue->toTrixHTML() !!}" id="issue" name="issue" class="h-52 rounded-md overflow-y-auto"/>
                            </div>

                            <div>
                                <div x-data="{ modelOpen: false }">
                                    <x-primary-button @click.prevent="modelOpen =!modelOpen"
                                        type="button" class="mt-4 float-end border border-slate-300"
                                    >Update</x-primary-button>

                                    <div x-show="modelOpen" x-bind:class="{ 'pointer-events-none': submitting }" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                        <div class="flex items-center justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
                                            <div x-cloak @click.prevent="modelOpen = false" x-show="modelOpen"
                                                x-transition:enter="transition ease-out duration-300 transform"
                                                x-transition:enter-start="opacity-0"
                                                x-transition:enter-end="opacity-100"
                                                x-transition:leave="transition ease-in duration-200 transform"
                                                x-transition:leave-start="opacity-100"
                                                x-transition:leave-end="opacity-0"
                                                class="fixed inset-0 transition-opacity bg-primary-background/10 backdrop-blur-sm" aria-hidden="true"
                                            ></div>

                                            <div x-cloak x-show="modelOpen"
                                                x-transition:enter="transition ease-out duration-300 transform"
                                                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                x-transition:leave="transition ease-in duration-200 transform"
                                                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                class="inline-block w-full max-w-xl p-8 my-20 overflow-hidden text-left transition-all transform bg-primary-background border border-border rounded-lg shadow-xl 2xl:max-w-2xl"
                                            >
                                                <div class="flex items-center justify-between space-x-4">
                                                    <h1 class="text-xl font-extrabold text-text ">Save Changes?</h1>
                                                </div>

                                                <p class="mt-2 text-base text-text/75">
                                                    Kindly review the fields before saving the changes.
                                                </p>

                                                <div class="mt-5">
                                                    <div class="flex justify-end mt-6 space-x-2">
                                                        <x-primary-button @click.prevent="modelOpen = false" type="button" class="border border-slate-300">Review Changes</x-primary-button>
                                                        <button :disabled="submitting" class="px-3 py-2 text-xs tracking-widest text-white uppercase transition-colors duration-200 transform bg-odc-blue-600 rounded-md dark:bg-odc-blue-700 dark:hover:bg-odc-blue-800 dark:focus:bg-odc-blue-800 hover:bg-odc-blue-700 focus:outline-none focus:bg-odc-blue-600 focus:ring focus:ring-odc-blue-400 focus:ring-opacity-50">
                                                            <span x-show="!submitting">Confirm and Save</span>
                                                            <span x-show="submitting">
                                                                <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-1 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#ED1C24"/>
                                                                </svg>
                                                                Updating...
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                </div>
            </form>
        @endauth
        
    </div>
    
    <x-flash-message key="no-changes-to-incident" icon="check-circle"/>
</x-app-layout>