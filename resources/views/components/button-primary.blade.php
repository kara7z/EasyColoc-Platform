@props(['type' => 'button'])

<button type="{{ $type }}" {{ $attributes->merge(['class' => 'ec-btn-primary py-3 lg:py-4 px-10 lg:px-12 text-white font-bold rounded-xl bg-gradient-to-r from-orange-500 to-red-500 hover:to-orange-500 hover:from-red-500 shadow-orange-md hover:shadow-orange-glow transition-all duration-300 outline-none hover:-translate-y-1 active:scale-95 flex-shrink-0 relative overflow-hidden group']) }}>
  <span class="relative z-10">{{ $slot }}</span>
  {{-- Subtle inner glow overlay --}}
  <div class="absolute inset-0 bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
</button>
