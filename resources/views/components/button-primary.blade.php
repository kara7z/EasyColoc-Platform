@props(['type' => 'button'])

<button type="{{ $type }}" {{ $attributes->merge(['class' => 'py-3 lg:py-4 px-10 lg:px-12 text-white-500 font-semibold rounded-lg bg-orange-500 hover:shadow-orange-md transition-all outline-none']) }}>
  {{ $slot }}
</button>
