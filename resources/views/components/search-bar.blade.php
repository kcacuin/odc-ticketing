@props([
    'wireModel',
    'placeholder',
    'xInitVar',
])

<div class="flex w-3/4">
    <input
        type="text"
        wire:model.live.debounce.150ms="{{ $wireModel }}"
        class="py-2.5 w-[40rem] text-xs text-text placeholder:text-text-placeholder rounded-s-md bg-primary-background shadow border border-border border-e border-e-border focus:border-border focus:ring-4 focus:ring-border/70 focus:z-10"
        placeholder="{{ $placeholder }}"
    />
    <button x-on:click.prevent="expanded = ! expanded" class="flex items-center gap-2 bg-cta py-2.5 px-5 text-xs font-bold whitespace-nowrap text-cta-text rounded-e-md border border-l-0 border-cta-border shadow outline-none hover:bg-cta-active hover:border-cta-active focus:ring-4 focus:ring-border/70">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
            <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
        </svg>
        <p x-text="{{ $xInitVar }} ? 'Hide' : 'Advance Search...'" x-transition></p>
    </button>
</div>