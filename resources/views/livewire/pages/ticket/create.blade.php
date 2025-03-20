<x-app-layout>
    <x-slot name="header">
        <h2 class="mr-10 text-left font-semibold text-xl text-white leading-tight">
            {{ __('Create Incident') }}
        </h2>
    </x-slot>
    @section('title', 'Create Incident')

    <div class="max-w-8xl mx-auto relative my-8" x-data="{ submitting: false }">
        @auth
            <div x-show="submitting" @click.window="handleWindowClick" class="fixed inset-0 flex items-center justify-center pointer-event-all">
                <div class="absolute inset-0 opacity-50 pointer-event-all"></div>
            </div>
            <form @submit="submitting = true;" method="POST" action="/tickets" enctype="multipart/form-data" class="py-6 px-8 bg-primary-background mx-8 border rounded-md border-border">
                @csrf

                <div class="flex flex-row-reverse w-full gap-10"
                    x-data="{
                        ticketNumber: '{{ $nextTicketNumber }}',
                        showMsg: false,
                        ticketDate: '{{ now()->format('Y-m-d') }}',
                        ticketStatus: 'Open',
                        ticketRequestedBy: '{{ old('requested_by')}}',
                        ticketClient: '{{ old('client')}}',
                        ticketProduct: '{{ old('product')}}',
                        ticketTitle: '{{ old('title')}}',
                        ticketIssue: '{!! old('issue') !!}',
                    }"
                >
                    <div class="flex flex-col w-[25%]">
                        <div class="mb-4">
                            {{-- * Ticket Number (Copy to Clipboard) --}}
                            <div class="opacity-90">
                                <x-form.input-clipboard name="number" labelname="Ticket Number" type="number" readonly="true" :value="$nextTicketNumber" class="disabled:opacity-90"/>
                                <input type="hidden" x-on:input="wire.emit('ticketIdUpdated', input)">
                            </div>
                            <x-form.field>
                                <select name="status_id" id="status_id" disabled
                                class="disabled:opacity-90 disabled:text-slate-300 appearance-none block mt-1 w-full peer h-[3rem] px-6 text-sm text-white bg-gray-dark rounded-lg border-opacity-75 border-2 outline-none placeholder-gray-300 placeholder-opacity-0 transition duration-200 placeholder-transparent placeholder:pointer-events-none
                                ring-0 placeholder:select-none focus:shadow-md focus:shadow-odc-blue-700 focus:border-blue-secondary focus:ring-0">
                                    @php
                                        $statuses = \App\Models\Status::all();
                                    @endphp

                                    @foreach ($statuses as $status)
                                        <option
                                            value="{{ old('status_id') === $status->id ? 'selected' : '' }}"
                                            class="py-4"
                                        >{{ ucwords($status->name) }}</option>
                                    @endforeach
                                </select>
                                <x-form.label class="-translate-y-[6px] peer-focus:-translate-y-[6px]" name="status" labelname="Status"/>
                                <x-form.error name="status_id"/>
                            </x-form.field>
                            <div>
                                <x-form.date x-model="ticketDate" name="date_received" labelname="Date Received" type="date" class="appearance-none"/>
                            </div>
                        </div>
                        <div class="relative max-h-52 overflow-y-auto bg-[#f1f0ef] rounded-md border border-dashed border-blue-secondary">
                            <x-input.filepond name="files" multiple/>
                        </div>
                    </div>
                    <div class="flex flex-col w-[75%] pr-10 border-r border-r-border">
                        <div class="grid grid-cols-3 grid-rows-1 gap-4 mb-6">
                            <x-form.input-tooltip x-model="ticketRequestedBy" name="requested_by" labelname="Requested By" type="text" tooltip="Person who requested assistance."/>
                            <x-form.input-tooltip x-model="ticketClient" name="client" labelname="Client" type="text" tooltip="Client or customer associated."/>
                            <x-form.input-tooltip x-model="ticketProduct" name="product" labelname="Product" type="text" tooltip="Relevant product or service."/>
                        </div>
                        <div class="flex flex-col border-t border-t-border">
                            <x-form.input-tooltip x-model="ticketTitle" name="title" labelname="Title" type="text" tooltip="Brief description of the problem."/>

                            <div class="relative">
                                <x-form.trix-input :value="old('issue', $ticket->issue->toTrixHTML())" x-model="ticketIssue" id="issue" name="issue" class="h-52 rounded-md overflow-y-auto"/>
                            </div>

                            <div>
                                <div x-data="{ modelOpen: false }">
                                    <x-primary-button @click.prevent="modelOpen =!modelOpen" type="button" class="mt-4 float-end border border-slate-300">Submit</x-primary-button>

                                    <div x-show="modelOpen" x-bind:class="{ 'pointer-events-none': submitting }" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                        <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
                                            <div x-cloak @click.prevent="modelOpen = false" x-show="modelOpen"
                                                x-transition:enter="transition ease-out duration-300 transform"
                                                x-transition:enter-start="opacity-0"
                                                x-transition:enter-end="opacity-100"
                                                x-transition:leave="transition ease-in duration-200 transform"
                                                x-transition:leave-start="opacity-100"
                                                x-transition:leave-end="opacity-0"
                                                class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-40" aria-hidden="true"
                                            ></div>

                                            <div x-cloak x-show="modelOpen"
                                                x-transition:enter="transition ease-out duration-300 transform"
                                                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                x-transition:leave="transition ease-in duration-200 transform"
                                                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                class="inline-block w-full max-w-xl p-8 my-20 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl"
                                            >
                                                <div class="flex items-center justify-between space-x-4">
                                                    <h1 class="text-xl font-medium text-gray-800 ">Overview</h1>
                                                </div>

                                                <p class="mt-2 text-base text-slate-500">
                                                    Kindly review the fields before submitting the incident.
                                                </p>

                                                <div class="mt-5">
                                                    <div class="space-y-px divide-y divide-slate-200">
                                                        <div class="text-sm">
                                                            <div class="flex items-center justify-between">
                                                                <p class="text-slate-500">Ticket Number</p>
                                                                <p x-text="ticketNumber"></p>
                                                            </div>
                                                            <div class="flex items-center justify-between">
                                                                <p class="text-slate-500">Date Received</p>
                                                                <p x-text="ticketDate"></p>
                                                            </div>
                                                            <div class="flex items-center justify-between">
                                                                <p class="text-slate-500">Status</p>
                                                                <p x-text="ticketStatus"></p>
                                                            </div>
                                                        </div>
                                                        <div class="text-sm">
                                                            <div class="flex items-center justify-between">
                                                                <p class="text-slate-500">Requested By</p>
                                                                <p x-text="ticketRequestedBy ? ticketRequestedBy : '***This field is required***'"
                                                                :class="{ 'text-red-primary italic': !ticketRequestedBy, '': ticketRequestedBy }"
                                                                ></p>
                                                            </div>
                                                            <div class="flex items-center justify-between">
                                                                <p class="text-slate-500">Client</p>
                                                                <p x-text="ticketClient ? ticketClient : '***This field is required***'"
                                                                :class="{ 'text-red-primary italic': !ticketClient, '': ticketClient }"
                                                                ></p>
                                                            </div>
                                                            <div class="flex items-center justify-between">
                                                                <p class="text-slate-500">Product</p>
                                                                <p x-text="ticketProduct ? ticketProduct :'***This field is required***'"
                                                                :class="{ 'text-red-primary italic': !ticketProduct, '': ticketProduct }"
                                                                ></p>
                                                            </div>
                                                        </div>
                                                        <div class="flex flex-col text-sm">
                                                            <div class="flex items-center justify-between">
                                                                <p class="text-slate-500">Title</p>
                                                                <p x-text="ticketTitle ? ticketTitle : '***This field is required***'"
                                                                :class="{ 'text-red-primary italic': !ticketTitle, '': ticketTitle }"
                                                                ></p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="flex justify-end mt-6 space-x-2">
                                                        <x-primary-button @click.prevent="modelOpen = false" type="button" class="border border-slate-300">Review issue and files</x-primary-button>
                                                        <button :disabled="submitting" class="px-3 py-2 text-xs tracking-widest text-white uppercase transition-colors duration-200 transform bg-odc-blue-600 rounded-md dark:bg-odc-blue-700 dark:hover:bg-odc-blue-800 dark:focus:bg-odc-blue-800 hover:bg-odc-blue-700 focus:outline-none focus:bg-odc-blue-600 focus:ring focus:ring-odc-blue-400 focus:ring-opacity-50">
                                                            <span x-show="!submitting">Confirm and Submit</span>
                                                            <span x-show="submitting">
                                                                <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-1 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#ED1C24"/>
                                                                </svg>
                                                                Submitting...
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
            </form>
        @endauth
    </div>
</x-app-layout>