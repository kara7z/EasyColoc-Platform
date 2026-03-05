@props(['variant' => 'neutral'])

@php
  $map = [
    'neutral' => 'bg-gray-100/80 text-gray-700 border-gray-200 shadow-sm',
    'success' => 'bg-green-50 text-green-700 border-green-200 shadow-sm',
    'danger'  => 'bg-orange-50 text-orange-600 border-orange-200 shadow-sm',
    'info'    => 'bg-slate-50 text-slate-700 border-slate-200 shadow-sm',
  ];
@endphp

<span {{ $attributes->merge(['class' => 'ec-badge inline-flex items-center px-3 py-1 rounded-full border text-xs font-semibold tracking-wide uppercase shadow-[0_2px_10px_rgb(0,0,0,0.03)] ' . ($map[$variant] ?? $map['neutral'])]) }}>
  {{ $slot }}
</span>
