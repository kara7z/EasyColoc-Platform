@props(['variant' => 'neutral'])

@php
  $map = [
    'neutral' => 'bg-gray-100 text-black-600 border-gray-100',
    'success' => 'bg-white-500 text-green-500 border-green-500',
    'danger'  => 'bg-orange-100 text-orange-500 border-orange-500',
    'info'    => 'bg-white-300 text-black-600 border-gray-100',
  ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center px-2.5 py-1 rounded-full border text-xs font-medium ' . ($map[$variant] ?? $map['neutral'])]) }}>
  {{ $slot }}
</span>
