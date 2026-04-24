@props([
    'action' => '#',
    'text' => 'Delete',
    'size' => 'md',
    'variant' => 'danger',
    'confirmMessage' => 'Are you sure you want to delete this item?'
])

@php
    $sizeClasses = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-base',
        'lg' => 'px-6 py-3 text-lg',
    ][$size];
@endphp

<form action="{{ $action }}" method="POST" class="inline" onsubmit="return confirm('{{ $confirmMessage }}')">
    @csrf
    @method('DELETE')
    <button 
        type="submit"
        {{ $attributes->merge([
            'class' => "inline-flex items-center gap-2 rounded-lg border-2 border-red-500 bg-transparent hover:bg-red-500/10 transition-all duration-200 {$sizeClasses}"
        ]) }}
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
        </svg>
        <span class="text-red-500 font-semibold">{{ $text }}</span>
    </button>
</form>