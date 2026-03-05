<div {{ $attributes->merge(['class' => 'ec-card bg-white rounded-2xl border border-gray-100 shadow-card hover:shadow-card-hover hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group']) }}>
  {{-- Subtle decorative gradient that appears on hover --}}
  <div class="absolute inset-0 bg-gradient-to-br from-white to-gray-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
  
  <div class="relative z-10">
    {{ $slot }}
  </div>
</div>
