@if (session('status'))
  <div class="mb-6 rounded-lg border border-green-500 bg-white-500 px-4 py-3 text-black-600">
    {{ session('status') }}
  </div>
@endif

@if ($errors->any())
  <div class="mb-6 rounded-lg border border-orange-500 bg-orange-100 px-4 py-3 text-black-600">
    <div class="font-semibold mb-2">Veuillez corriger les erreurs :</div>
    <ul class="list-disc pl-5 space-y-1">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif
