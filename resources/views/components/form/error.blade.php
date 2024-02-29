@props(['name'])

@error($name)
<div {{ $attributes->merge(['class' => 'flex text-sm text-odc-red-700 dark:text-pink-400']) }}>
    <span class="mt-[1px] mr-1">
        <svg aria-hidden="true" fill="currentColor" focusable="false" width="16px" height="16px" viewBox="0 0 24 24" xmlns="https://www.w3.org/2000/svg"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"></path></svg>
    </span>
    <span> {{ $message }} </span>
</div>
@enderror
