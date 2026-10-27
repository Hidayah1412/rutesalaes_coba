@props([
    'title',
    'value',
    'subtitle' => null,
    'color' => 'blue',
    'icon' => 'chart'
])

@php
    $colorClasses = match($color) {
        'green', 'emerald' => [
            'bg' => 'bg-emerald-50 text-emerald-600',
            'border' => 'border-emerald-100',
            'text' => 'text-emerald-700'
        ],
        'blue', 'sky' => [
            'bg' => 'bg-blue-50 text-blue-600',
            'border' => 'border-blue-100',
            'text' => 'text-blue-700'
        ],
        'indigo', 'purple' => [
            'bg' => 'bg-indigo-50 text-indigo-600',
            'border' => 'border-indigo-100',
            'text' => 'text-indigo-700'
        ],
        'amber', 'yellow' => [
            'bg' => 'bg-amber-50 text-amber-600',
            'border' => 'border-amber-100',
            'text' => 'text-amber-700'
        ],
        'rose', 'red' => [
            'bg' => 'bg-rose-50 text-rose-600',
            'border' => 'border-rose-100',
            'text' => 'text-rose-700'
        ],
        default => [
            'bg' => 'bg-slate-50 text-slate-600',
            'border' => 'border-slate-100',
            'text' => 'text-slate-700'
        ]
    };
@endphp

<div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs font-medium uppercase tracking-wider text-slate-400">{{ $title }}</p>
            <h3 class="text-2xl font-bold text-slate-900 mt-1 tracking-tight">{{ $value }}</h3>
            @if($subtitle)
                <p class="text-xs text-slate-500 mt-1 flex items-center gap-1">
                    {{ $subtitle }}
                </p>
            @endif
        </div>
        <div class="w-12 h-12 rounded-xl {{ $colorClasses['bg'] }} flex items-center justify-center shrink-0">
            @if($icon === 'check')
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            @elseif($icon === 'currency')
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            @elseif($icon === 'percent')
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                </svg>
            @elseif($icon === 'store')
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            @elseif($icon === 'users')
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            @else
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            @endif
        </div>
    </div>
</div>

