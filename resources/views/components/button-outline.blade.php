@props(['type' => 'button'])

<button type="{{ $type }}" {{ $attributes->merge(['class' => 'ec-btn-outline font-semibold tracking-wide py-2.5 px-6 sm:px-8 border-2 border-orange-500 text-orange-500 bg-white outline-none rounded-full hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-400 hover:border-transparent hover:text-white transition-all duration-300 hover:shadow-orange-glow hover:-translate-y-0.5 active:scale-95 flex-shrink-0 relative overflow-hidden group']) }}>
  <span class="relative z-10">{{ $slot }}</span>
  {{-- Button shine effect --}}
  <div class="absolute inset-0 -translate-x-full bg-white/20 skew-x-12 group-hover:animate-[shine_1s_ease-in-out]"></div>
</button>

<style>
  @keyframes shine {
    100% { transform: translateX(100%); }
  }
</style>
