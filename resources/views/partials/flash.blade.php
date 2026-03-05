@if (session('status'))
  <div class="mb-6 overflow-hidden rounded-xl bg-white border border-green-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] animate-[slideDown_0.3s_ease-out]">
    <div class="flex">
      <div class="flex-shrink-0 bg-green-500/10 flex items-center justify-center w-12 border-r border-green-100">
        <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </div>
      <div class="px-4 py-3 flex-1 flex items-center text-green-800 font-medium text-sm">
        {{ session('status') }}
      </div>
    </div>
  </div>
@endif

@if ($errors->any())
  <div class="mb-6 overflow-hidden rounded-xl bg-white border border-orange-100 shadow-[0_8px_30px_rgb(0,0,0,0.06)] animate-[slideDown_0.3s_ease-out]">
    <div class="flex">
      <div class="flex-shrink-0 bg-orange-500/10 flex items-center justify-center w-12 border-r border-orange-100 self-stretch">
        <svg class="h-6 w-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
      </div>
      <div class="px-4 py-4 flex-1">
        <div class="font-bold text-orange-900 mb-1">Veuillez corriger les erreurs :</div>
        <ul class="list-disc pl-5 space-y-1 text-sm text-orange-800 font-medium">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
@endif

<style>
  @keyframes slideDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
  }
</style>
