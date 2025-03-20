<x-app-layout>
    <x-slot name="header">
        <h2 class="mr-10 text-left font-semibold text-xl text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @section('title', 'Dashboard')
    <div class="my-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                <div class="flex flex-col gap-6 overflow-y-auto">
                    <div class="grid grid-cols-3 grid-rows-1 gap-6">
                        <div role="status" class="p-4 bg-primary-background max-w-sm border border-border rounded animate-pulse shadow">
                            <div class="h-2.5 bg-slate-300 rounded-full w-48 mb-4"></div>
                            <div class="h-2 bg-slate-300 rounded-full max-w-[360px] mb-2.5"></div>
                            <div class="h-2 bg-slate-300 rounded-full mb-2.5"></div>
                            <div class="h-2 bg-slate-300 rounded-full max-w-[330px] mb-2.5"></div>
                            <div class="h-2 bg-slate-300 rounded-full max-w-[300px] mb-2.5"></div>
                            <div class="h-2 bg-slate-300 rounded-full max-w-[360px] mb-2.5"></div>
                            <div class="h-2 bg-slate-300 rounded-full mb-2.5"></div>
                            <div class="h-2 bg-slate-300 rounded-full max-w-[330px]"></div>
                            <span class="sr-only">Loading...</span>
                        </div>
                        <div role="status" class="p-4 bg-primary-background max-w-sm border border-border rounded animate-pulse shadow">
                            <div class="h-2.5 bg-slate-300 rounded-full w-48 mb-4"></div>
                            <div class="h-2 bg-slate-300 rounded-full max-w-[360px] mb-2.5"></div>
                            <div class="h-2 bg-slate-300 rounded-full mb-2.5"></div>
                            <div class="h-2 bg-slate-300 rounded-full max-w-[330px] mb-2.5"></div>
                            <div class="h-2 bg-slate-300 rounded-full max-w-[300px] mb-2.5"></div>
                            <div class="h-2 bg-slate-300 rounded-full max-w-[360px] mb-2.5"></div>
                            <div class="h-2 bg-slate-300 rounded-full mb-2.5"></div>
                            <div class="h-2 bg-slate-300 rounded-full max-w-[330px]"></div>
                            <span class="sr-only">Loading...</span>
                        </div>
                        <div role="status" class="p-4 bg-primary-background max-w-sm border border-border rounded animate-pulse shadow">
                            <div class="h-2.5 bg-slate-300 rounded-full w-48 mb-4"></div>
                            <div class="h-2 bg-slate-300 rounded-full max-w-[360px] mb-2.5"></div>
                            <div class="h-2 bg-slate-300 rounded-full mb-2.5"></div>
                            <div class="h-2 bg-slate-300 rounded-full max-w-[330px] mb-2.5"></div>
                            <div class="h-2 bg-slate-300 rounded-full max-w-[300px] mb-2.5"></div>
                            <div class="h-2 bg-slate-300 rounded-full max-w-[360px] mb-2.5"></div>
                            <div class="h-2 bg-slate-300 rounded-full mb-2.5"></div>
                            <div class="h-2 bg-slate-300 rounded-full max-w-[330px]"></div>
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>

                    <div class="flex gap-6">
                        <div role="status" class="w-full p-4 space-y-4 bg-primary-background border border-border rounded divide-y divide-gray-200 shadow animate-pulse dark:divide-gray-700 md:p-6 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="h-2.5 bg-gray-300 rounded-full w-24 mb-2.5"></div>
                                    <div class="w-32 h-2 bg-slate-300 rounded-full"></div>
                                </div>
                                <div class="h-2.5 bg-gray-300 rounded-full w-12"></div>
                            </div>
                            <div class="flex items-center justify-between pt-4">
                                <div>
                                    <div class="h-2.5 bg-gray-300 rounded-full w-24 mb-2.5"></div>
                                    <div class="w-32 h-2 bg-slate-300 rounded-full"></div>
                                </div>
                                <div class="h-2.5 bg-gray-300 rounded-full w-12"></div>
                            </div>
                            <div class="flex items-center justify-between pt-4">
                                <div>
                                    <div class="h-2.5 bg-gray-300 rounded-full w-24 mb-2.5"></div>
                                    <div class="w-32 h-2 bg-slate-300 rounded-full"></div>
                                </div>
                                <div class="h-2.5 bg-gray-300 rounded-full w-12"></div>
                            </div>
                            <div class="flex items-center justify-between pt-4">
                                <div>
                                    <div class="h-2.5 bg-gray-300 rounded-full w-24 mb-2.5"></div>
                                    <div class="w-32 h-2 bg-slate-300 rounded-full"></div>
                                </div>
                                <div class="h-2.5 bg-gray-300 rounded-full w-12"></div>
                            </div>
                            <div class="flex items-center justify-between pt-4">
                                <div>
                                    <div class="h-2.5 bg-gray-300 rounded-full w-24 mb-2.5"></div>
                                    <div class="w-32 h-2 bg-slate-300 rounded-full"></div>
                                </div>
                                <div class="h-2.5 bg-gray-300 rounded-full w-12"></div>
                            </div>
                            <span class="sr-only">Loading...</span>
                        </div>

                        <div role="status" class="w-full p-4 bg-primary-background border border-border rounded shadow animate-pulse md:p-6 dark:border-gray-700">
                            <div class="h-2.5 bg-slate-300 rounded-full w-32 mb-2.5"></div>
                            <div class="w-48 h-2 mb-10 bg-slate-300 rounded-full"></div>
                            <div class="flex items-baseline mt-4">
                                <div class="w-full bg-slate-300 rounded-t-lg h-72"></div>
                                <div class="w-full h-56 ms-6 bg-slate-300 rounded-t-lg"></div>
                                <div class="w-full bg-slate-300 rounded-t-lg h-72 ms-6"></div>
                                <div class="w-full h-64 ms-6 bg-slate-300 rounded-t-lg"></div>
                                <div class="w-full bg-slate-300 rounded-t-lg h-80 ms-6"></div>
                                <div class="w-full bg-slate-300 rounded-t-lg h-72 ms-6"></div>
                                <div class="w-full bg-slate-300 rounded-t-lg h-80 ms-6"></div>
                            </div>
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

